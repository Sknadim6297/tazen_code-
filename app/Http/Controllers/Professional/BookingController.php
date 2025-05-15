<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingTimedate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    public function uploadDocuments(Request $request, $bookingId)
    {
        $request->validate([
            'documents.*' => 'mimes:pdf|max:2048',
        ]);
        $booking = Booking::findOrFail($bookingId);

        if ($request->hasFile('documents')) {
            $filePaths = [];
            if ($booking->professional_documents) {
                $filePaths = explode(',', $booking->professional_documents);
            }

            foreach ($request->file('documents') as $file) {
                $filePath = $file->store('uploads/documents', 'public');
                $filePaths[] = $filePath;
            }
            $booking->professional_documents = implode(',', $filePaths);
            $booking->save();

            return back()->with('success', 'Documents uploaded successfully!');
        }

        return back()->with('error', 'No documents were uploaded.');
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
    // app/Http/Controllers/Professional/BookingController.php

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
            'remarks' => 'nullable|string'
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

        $timedate->status = 'completed';
        $timedate->remarks = $request->remarks;
        $timedate->save();

        return response()->json(['success' => true, 'message' => 'Booking status updated successfully.']);
    }
}
