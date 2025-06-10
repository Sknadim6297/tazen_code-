<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingTimedate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UpcomingAppointmentController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Log the start of the request for debugging
            Log::info('Loading upcoming appointments page', ['user_id' => Auth::guard('user')->id()]);
            
            // Start with base query for the user's bookings
            $query = Booking::with([
                'professional' => function ($q) {
                    $q->select('id', 'name');
                }
            ])->where('user_id', Auth::guard('user')->id());

            // Apply search filters if provided
            if ($request->filled('search_name')) {
                $search = $request->search_name;
                $query->whereHas('professional', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
            }

            // Get the bookings
            $allBookings = $query->get();
            
            Log::info('Found bookings', ['count' => $allBookings->count()]);
            
            // Group bookings by booking_id to ensure we only show one timedate per booking
            $processedBookings = collect();
            
            foreach ($allBookings as $booking) {
                try {
                    // For each booking, get ALL timedates
                    $allTimedates = BookingTimedate::where('booking_id', $booking->id)
                        ->orderBy('date', 'asc')
                        ->get();
                    
                    // Find the next upcoming timedate (first future date)
                    $nextTimedate = $allTimedates->first(function ($timedate) {
                        return Carbon::parse($timedate->date)->startOfDay()->gte(Carbon::today());
                    });
                    
                    // Only add this booking if it has a future timedate
                    if ($nextTimedate) {
                        // Replace the timedates collection with just this single upcoming timedate
                        $booking->setRelation('timedates', collect([$nextTimedate]));
                        
                        // Add calculated session information
                        $booking->sessions_taken = $allTimedates->where('status', 'completed')->count();
                        $booking->total_sessions = $allTimedates->count();
                        $booking->sessions_remaining = $booking->total_sessions - $booking->sessions_taken;
                        
                        $processedBookings->push($booking);
                    }
                } catch (\Exception $e) {
                    Log::error('Error processing booking', [
                        'booking_id' => $booking->id,
                        'error' => $e->getMessage()
                    ]);
                    // Continue with next booking even if this one fails
                    continue;
                }
            }
            
            // Apply date filtering if requested
            if ($request->filled('search_date_from') || $request->filled('search_date_to')) {
                $processedBookings = $processedBookings->filter(function ($booking) use ($request) {
                    $timedate = $booking->timedates->first();
                    if (!$timedate) return false;
                    
                    $date = Carbon::parse($timedate->date);
                    
                    if ($request->filled('search_date_from') && $request->filled('search_date_to')) {
                        $from = Carbon::parse($request->search_date_from);
                        $to = Carbon::parse($request->search_date_to);
                        return $date->between($from, $to);
                    } elseif ($request->filled('search_date_from')) {
                        return $date->gte(Carbon::parse($request->search_date_from));
                    } elseif ($request->filled('search_date_to')) {
                        return $date->lte(Carbon::parse($request->search_date_to));
                    }
                    
                    return true;
                });
            }
            
            // Sort by the nearest upcoming date
            $sortedBookings = $processedBookings->sortBy(function ($booking) {
                $timedate = $booking->timedates->first();
                return $timedate ? Carbon::parse($timedate->date)->timestamp : PHP_INT_MAX;
            })->values();
            
            // Pass to view
            $bookings = $sortedBookings;
            
            Log::info('Processed bookings', ['count' => $bookings->count()]);
            
            return view('customer.upcoming-appointment.index', compact('bookings'));
        } catch (\Exception $e) {
            Log::error('Error loading upcoming appointments', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Provide a friendly error message to the user
            return redirect()->back()->with('error', 'An error occurred while loading your appointments. Please try again later.');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function uploadDocument(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'document' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
                'booking_id' => 'required|exists:bookings,id'
            ]);

            // Log the request data for debugging
            Log::info('Upload document request:', [
                'booking_id' => $request->booking_id,
                'has_file' => $request->hasFile('document'),
                'file_name' => $request->hasFile('document') ? $request->file('document')->getClientOriginalName() : null,
            ]);

            $booking = Booking::findOrFail($request->booking_id);

            if ($request->hasFile('document')) {
                $file = $request->file('document');
                if ($booking->customer_document && Storage::disk('public')->exists($booking->customer_document)) {
                    try {
                        Storage::disk('public')->delete($booking->customer_document);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete old file: ' . $e->getMessage());
                    }
                }

                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

                try {
                    $path = $file->storeAs('customer-documents', $fileName, 'public');
                    if (!Storage::disk('public')->exists($path)) {
                        throw new \Exception('File was not stored properly');
                    }

                    $booking->customer_document = $path;
                    $booking->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'Document uploaded successfully',
                        'file' => [
                            'path' => $path,
                            'url' => Storage::disk('public')->url($path),
                            'name' => $fileName,
                            'type' => $file->getClientOriginalExtension(),
                            'size' => $this->formatFileSize($file->getSize())
                        ]
                    ]);
                } catch (\Exception $e) {
                    Log::error('File storage error: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Error storing file: ' . $e->getMessage()
                    ], 500);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'No document was uploaded'
            ], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Document upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error uploading document: ' . $e->getMessage()
            ], 500);
        }
    }

    private function formatFileSize($size)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        return round($size, 2) . ' ' . $units[$i];
    }

    public function getDocumentInfo($id)
    {
        try {
            $booking = Booking::findOrFail($id);

            if (!$booking->customer_document) {
                return response()->json([
                    'success' => false,
                    'message' => 'No document found'
                ], 404);
            }

            if (!Storage::disk('public')->exists($booking->customer_document)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Document file not found'
                ], 404);
            }

            $path = $booking->customer_document;
            $fileInfo = [
                'path' => $path,
                'url' => Storage::disk('public')->url($path),
                'name' => basename($path),
                'type' => pathinfo($path, PATHINFO_EXTENSION),
                'size' => $this->formatFileSize(Storage::disk('public')->size($path))
            ];

            return response()->json([
                'success' => true,
                'file' => $fileInfo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting document information'
            ], 500);
        }
    }
}
