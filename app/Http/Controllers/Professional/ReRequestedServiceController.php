<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\ReRequestedService;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReRequestedServiceController extends Controller
{
    public function index(Request $request)
    {
        $professionalId = Auth::id();
        
        $query = ReRequestedService::with(['customer', 'originalBooking'])
            ->where('professional_id', $professionalId);

        // Apply filters
        $query->byStatus($request->status)
              ->byPaymentStatus($request->payment_status)
              ->byPriority($request->priority)
              ->searchByName($request->search);

        // Apply date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('requested_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('requested_at', '<=', $request->date_to);
        }

        $reRequestedServices = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('professional.re-requested-service.index', compact('reRequestedServices'));
    }

    public function create()
    {
        $professionalId = Auth::id();
        
    // Get customers who have bookings with this professional (use Booking model)
    $customerIds = Booking::where('professional_id', $professionalId)->pluck('user_id')->unique();
    $customers = User::whereIn('id', $customerIds)->get();

        // Get completed bookings for this professional (bookings with timedates marked completed)
        $bookings = Booking::where('professional_id', $professionalId)
            ->whereHas('timedates', function($q) {
                $q->where('status', 'completed');
            })
            ->with('customer')
            ->get();

        return view('professional.re-requested-service.create', compact('customers', 'bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'service_name' => 'required|string|max:255',
            'reason' => 'required|string|min:10|max:1000',
            'original_price' => 'required|numeric|min:1|max:999999',
            'original_booking_id' => 'nullable|exists:bookings,id',
            'priority' => 'required|in:low,normal,high,urgent'
        ], [
            'reason.min' => 'Reason must be at least 10 characters long.',
            'original_price.max' => 'Price cannot exceed ₹999,999.',
            'priority.required' => 'Please select a priority level.'
        ]);

        $professionalId = Auth::id();
        $originalPrice = $request->original_price;
        
        // Calculate CGST and SGST (8% each)
        $cgstAmount = ($originalPrice * 8) / 100;
        $sgstAmount = ($originalPrice * 8) / 100;
        $totalGstAmount = $cgstAmount + $sgstAmount;
        $totalAmount = $originalPrice + $totalGstAmount;

        $reRequestedService = ReRequestedService::create([
            'professional_id' => $professionalId,
            'customer_id' => $request->customer_id,
            'original_booking_id' => $request->original_booking_id,
            'service_name' => $request->service_name,
            'reason' => $request->reason,
            'original_price' => $originalPrice,
            'final_price' => $originalPrice,
            'gst_amount' => $totalGstAmount,
            'cgst_amount' => $cgstAmount,
            'sgst_amount' => $sgstAmount,
            'cgst_rate' => 8.00,
            'sgst_rate' => 8.00,
            'total_amount' => $totalAmount,
            'status' => 'pending',
            'priority' => $request->priority,
            'payment_status' => 'unpaid',
            'requested_at' => now()
        ]);

        // Send notification to admin (implement later)
        // $this->notifyAdmin($reRequestedService);
        
        return redirect()->route('professional.re-requested-service.index')
            ->with('success', 'Re-booking service request has been submitted successfully. Waiting for admin approval.');
    }

    public function show($id)
    {
        $reRequestedService = ReRequestedService::with(['customer', 'originalBooking'])
            ->where('professional_id', Auth::id())
            ->findOrFail($id);

        return view('professional.re-requested-service.show', compact('reRequestedService'));
    }

    public function edit($id)
    {
        $reRequestedService = ReRequestedService::where('professional_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

    $customerIds = Booking::where('professional_id', Auth::id())->pluck('user_id')->unique();
    $customers = User::whereIn('id', $customerIds)->get();

        $bookings = Booking::where('professional_id', Auth::id())
            ->whereHas('timedates', function($q) {
                $q->where('status', 'completed');
            })
            ->with('customer')
            ->get();

        return view('professional.re-requested-service.edit', compact('reRequestedService', 'customers', 'bookings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'service_name' => 'required|string|max:255',
            'reason' => 'required|string|min:10|max:1000',
            'original_price' => 'required|numeric|min:1|max:999999',
            'original_booking_id' => 'nullable|exists:bookings,id',
            'priority' => 'required|in:low,normal,high,urgent'
        ], [
            'reason.min' => 'Reason must be at least 10 characters long.',
            'original_price.max' => 'Price cannot exceed ₹999,999.',
            'priority.required' => 'Please select a priority level.'
        ]);

        $reRequestedService = ReRequestedService::where('professional_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $originalPrice = $request->original_price;
        
        // Calculate CGST and SGST (8% each)
        $cgstAmount = ($originalPrice * 8) / 100;
        $sgstAmount = ($originalPrice * 8) / 100;
        $totalGstAmount = $cgstAmount + $sgstAmount;
        $totalAmount = $originalPrice + $totalGstAmount;

        $reRequestedService->update([
            'customer_id' => $request->customer_id,
            'original_booking_id' => $request->original_booking_id,
            'service_name' => $request->service_name,
            'reason' => $request->reason,
            'original_price' => $originalPrice,
            'final_price' => $originalPrice,
            'gst_amount' => $totalGstAmount,
            'cgst_amount' => $cgstAmount,
            'sgst_amount' => $sgstAmount,
            'total_amount' => $totalAmount,
            'priority' => $request->priority
        ]);

        return redirect()->route('professional.re-requested-service.index')
            ->with('success', 'Re-booking service request has been updated successfully.');
    }

    public function destroy($id)
    {
        $reRequestedService = ReRequestedService::where('professional_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $reRequestedService->delete();

        return redirect()->route('professional.re-requested-service.index')
            ->with('success', 'Re-requested service has been cancelled successfully.');
    }
}
