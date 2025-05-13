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
    public function index()
    {
        $bookings = Booking::with(['timedates' => function ($q) {
            $q->orderBy('date', 'desc');
        }])
            ->where('professional_id', Auth::guard('professional')->id())
            ->get();

        // $bookingTimedate = BookingTimedate::with('booking')->whereIn('booking_id', $bookings->pluck('id'))->get();
        // dd($bookingTimedate);
        // dd($bookings);
        return view('professional.booking.index', compact('bookings'));
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
}
