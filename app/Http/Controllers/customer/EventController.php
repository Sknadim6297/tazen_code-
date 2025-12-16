<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\AllEvent;
use App\Models\EventBooking;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EventBooking::with('event')->where('user_id', auth()->guard('user')->id());
        if ($request->filled('search_name')) {
            $query->whereHas('event', function ($q) use ($request) {
                $q->where('heading', 'like', '%' . $request->search_name . '%');
            });
        }
        if ($request->filled('search_type')) {
            $query->where('type', $request->search_type);
        }
        if ($request->filled('search_date_from')) {
            $query->whereDate('event_date', '>=', $request->search_date_from);
        }
        
        if ($request->filled('search_date_to')) {
            $query->whereDate('event_date', '<=', $request->search_date_to);
        }
        
        $bookings = $query->latest()->get();
         
        return view('customer.event.index', compact('bookings'));
    }

    /**
     * Display the event booking success page
     */
    public function bookingSuccess(Request $request)
    {
        if (!session()->has('event_booking_data')) {
            $booking = EventBooking::where('user_id', auth()->guard('user')->id())
                ->latest()
                ->first();
                
            if ($booking) {
                $event = AllEvent::find($booking->event_id);
                $user = auth()->guard('user')->user();
                
                return view('customer.booking.event_success', compact('booking', 'event', 'user'));
            }
            return redirect()->route('user.customer-event.index')
                ->with('error', 'No booking information found. Please check your bookings list.');
        }
        $bookingData = session('event_booking_data');
        $event = AllEvent::find($bookingData['event_id'] ?? null);
        $user = auth()->guard('user')->user();
        
        return view('customer.booking.event_success', compact('bookingData', 'event', 'user'));
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
    public function show(string $id)
    {
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

    /**
     * Generate PDF invoice for a paid event booking
     */
    public function downloadInvoice($id)
    {
        $eventBooking = EventBooking::with(['event.professional', 'user'])
            ->where('id', $id)
            ->where('user_id', auth()->guard('user')->id())
            ->whereIn('payment_status', ['paid', 'success'])
            ->first();

        if (!$eventBooking) {
            return redirect()->back()->with('error', 'Event booking not found or not eligible for invoice generation.');
        }

        // Prepare invoice data
        $invoiceNumber = 'INV-EVT-' . str_pad($eventBooking->id, 6, '0', STR_PAD_LEFT) . '-' . date('Y');
        $invoiceDate = $eventBooking->created_at->format('d M, Y');
        
        // Get pricing details
        $pricing = [
            'base_price' => $eventBooking->price,
            'cgst' => $eventBooking->cgst ?? 0,
            'sgst' => $eventBooking->sgst ?? 0,
            'igst' => $eventBooking->igst ?? 0,
            'total_price' => $eventBooking->total_price ?? $eventBooking->price
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('customer.event.invoice-pdf', [
            'eventBooking' => $eventBooking,
            'customer' => auth()->guard('user')->user(),
            'professional' => $eventBooking->event->professional ?? null,
            'event' => $eventBooking->event,
            'invoice_no' => $invoiceNumber,
            'invoice_date' => $invoiceDate,
            'pricing' => $pricing
        ]);

        return $pdf->download('event-invoice-' . $invoiceNumber . '.pdf');
    }
}
