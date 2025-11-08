<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingTimedate;
use App\Models\McqAnswer;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $professionalId = Auth::guard('professional')->id();

    $query = Booking::with('timedates')
        ->where('professional_id', $professionalId);

    if ($request->filled('search_name')) {
        $search = $request->search_name;
        $query->where(function ($q) use ($search) {
            $q->where('customer_name', 'like', "%{$search}%")
              ->orWhere('service_name', 'like', "%{$search}%")
              ->orWhere('remarks', 'like', "%{$search}%");
        });
    }
    if ($request->filled('search_date_from') && $request->filled('search_date_to')) {
        $query->whereBetween('booking_date', [$request->search_date_from, $request->search_date_to]);
    } elseif ($request->filled('search_date_from')) {
        $query->where('booking_date', '>=', $request->search_date_from);
    } elseif ($request->filled('search_date_to')) {
        $query->where('booking_date', '<=', $request->search_date_to);
    }

    if ($request->filled('plan_type')) {
        $query->where('plan_type', $request->plan_type);
    }
    if ($request->filled('status')) {
        if ($request->status === 'completed') {
            $query->whereHas('timedates', function($q) {
                $q->where('status', 'completed');
            }, '=', DB::raw('(select count(*) from booking_timedates where booking_timedates.booking_id = bookings.id)'));
        } elseif ($request->status === 'pending') {
            $query->whereHas('timedates', function($q) {
                $q->where('status', 'pending')->orWhereNull('status');
            });
        }
    }

    $bookings = $query->orderBy('booking_date', 'desc')->get();

    $planTypes = Booking::where('professional_id', $professionalId)
        ->select('plan_type')
        ->distinct()
        ->pluck('plan_type');

    return view('professional.booking.index', compact('bookings', 'planTypes'));
}

/**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function uploadDocuments(Request $request, $bookingId)
    {
        try {
            $request->validate([
                'document' => 'required|mimes:pdf|max:2048',
            ]);

            $booking = Booking::findOrFail($bookingId);

            if ($request->hasFile('document')) {
                if ($booking->professional_documents) {
                    $oldPath = storage_path('app/public/' . $booking->professional_documents);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                $file = $request->file('document');
                $timestamp = time();
                $extension = $file->getClientOriginalExtension();
                $filename = $timestamp . '_' . uniqid() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $filePath = $file->storeAs('uploads/documents', $filename, 'public');
                $booking->professional_documents = $filePath;
                $booking->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Document ' . ($booking->wasChanged('professional_documents') ? 'updated' : 'uploaded') . ' successfully!',
                    'file_path' => $filePath
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No document was uploaded.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading document: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    }

    public function details($id)
    {
        $booking = Booking::with('timedates')->find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        return response()->json([
            'dates' => $booking->timedates->map(function ($td) {
                return [
                    'date' => $td->date,
                    'time_slot' => explode(',', $td->time_slot),
                    'status' => $td->status ?? 'Pending',
                ];
            })
        ]);
    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|integer',
            'date' => 'required|date',
            'slot' => 'required|string',
            'remarks' => 'nullable|string',
            'status' => 'required|in:completed,pending'
        ]);

        $timedate = BookingTimedate::where('booking_id', $request->booking_id)
            ->where('date', $request->date)
            ->first();

        if (!$timedate) {
            return response()->json(['success' => false, 'message' => 'Time slot not found.']);
        }

        $slots = explode(',', $timedate->time_slot);
        if (!in_array($request->slot, $slots)) {
            return response()->json(['success' => false, 'message' => 'Slot not found in booking.']);
        }

        $timedate->status = $request->status;
        $timedate->remarks = $request->remarks;
        $timedate->save();
        $booking = Booking::findOrFail($request->booking_id);
        if ($request->status === 'completed') {
            $mcqAnswers = McqAnswer::where('user_id', $booking->user_id)
                                ->where('service_id', $booking->service_id)
                                ->whereNull('booking_id')
                                ->get();
            
            foreach ($mcqAnswers as $answer) {
                $answer->booking_id = $booking->id;
                $answer->save();
            }
        }

        return response()->json(['success' => true, 'message' => 'Booking status updated successfully.']);
    }
    
    /**
     * Get questionnaire answers for a specific booking
     */
    public function getQuestionnaireAnswers($bookingId)
    {
        try {
            $booking = Booking::with(['customer'])->findOrFail($bookingId);
            
            // Get all answers for this user and service, not just those linked to this specific booking
            $answers = McqAnswer::with('serviceMcq')
                ->where('user_id', $booking->user_id)
                ->where('service_id', $booking->service_id)
                ->get();
            
            if ($answers->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No questionnaire answers found for this booking.',
                    'debug_info' => [
                        'booking_id' => $bookingId,
                        'user_id' => $booking->user_id,
                        'service_id' => $booking->service_id
                    ]
                ]);
            }
            
            $formattedAnswers = $answers->map(function ($answer) {
                return [
                    'question' => $answer->serviceMcq ? $answer->serviceMcq->question : 'Question not found',
                    'answer' => $answer->answer,
                    'service_id' => $answer->service_id,
                    'user_id' => $answer->user_id
                ];
            });
            
            $serviceName = $booking->service_name ?? 'Unknown Service';
            $customerName = $booking->customer ? $booking->customer->name : 'Unknown Customer';
            
            return response()->json([
                'success' => true,
                'answers' => $formattedAnswers,
                'booking_details' => [
                    'service_name' => $serviceName,
                    'customer_name' => $customerName
                ]
            ]);
} catch (\Exception $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving questionnaire answers: ' . $e->getMessage()
            ]);
        }
    }
}
