<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UpcomingAppointmentController extends Controller
{

    public function index(Request $request)
    {
        $query = Booking::with([
            'timedates' => function ($q) {
                $q->where('date', '>=', \Carbon\Carbon::today())  
                    ->orderBy('date', 'asc');
            },
            'professional' => function ($q) {
                $q->select('id', 'name');
            }
        ])
            ->where('user_id', Auth::guard('user')->id());

        // 🔍 Search by Professional Name (search_name)
        if ($request->filled('search_name')) {
            $search = $request->search_name;
            $query->
             
            
            whereHas('professional', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            }
        );
        }

        // 📅 Search by Date Range (search_date_from & search_date_to)
        if ($request->filled('search_date_from') && $request->filled('search_date_to')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->whereBetween('booking_date', [$request->search_date_from, $request->search_date_to]);
            });
        } elseif ($request->filled('search_date_from')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('booking_date', '>=', $request->search_date_from);
            });
        } elseif ($request->filled('search_date_to')) {
            $query->whereHas('timedates', function ($q) use ($request) {
                $q->where('booking_date', '<=', $request->search_date_to);
            });
        }

        $bookings = $query->get();

        return view('customer.upcoming-appointment.index', compact('bookings'));
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
                
                // Log file information
                Log::info('File information:', [
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);

                // Delete old file if exists
                if ($booking->customer_document && Storage::disk('public')->exists($booking->customer_document)) {
                    try {
                        Storage::disk('public')->delete($booking->customer_document);
                    } catch (\Exception $e) {
                        Log::warning('Failed to delete old file: ' . $e->getMessage());
                    }
                }

                // Generate safe filename
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                
                try {
                    // Store the file
                    $path = $file->storeAs('customer-documents', $fileName, 'public');
                    
                    // Verify file was stored
                    if (!Storage::disk('public')->exists($path)) {
                        throw new \Exception('File was not stored properly');
                    }

                    // Update database
                    $booking->customer_document = $path;
                    $booking->save();

                    // Log success
                    Log::info('File uploaded successfully:', ['path' => $path]);

                    // Return success response
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
            \Log::error('Document info error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error getting document information'
            ], 500);
        }
    }
}
