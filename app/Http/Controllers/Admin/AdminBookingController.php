<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\SubService;
use App\Models\Professional;
use App\Models\Booking;
use App\Models\BookingTimedate;
use App\Models\ProfessionalService;
use App\Models\Rate;
use App\Models\Availability;
use App\Models\AvailabilitySlot;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Mail\OtpVerificationMail;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Razorpay\Api\Api;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        // Start building the query
        $query = Booking::with(['user', 'professional', 'timedates', 'service', 'subService']);

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('service_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('professional', function($profQuery) use ($search) {
                      $profQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Apply professional filter
        if ($request->filled('professional_id')) {
            $query->where('professional_id', $request->professional_id);
        }

        // Apply service filter
        if ($request->filled('service_id')) {
            $query->where('service_id', $request->service_id);
        }

        // Apply date range filter
        if ($request->filled('from_date')) {
            $query->where('booking_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('booking_date', '<=', $request->to_date);
        }

        // Apply amount range filter
        if ($request->filled('min_amount')) {
            $query->where('total_amount', '>=', $request->min_amount);
        }

        if ($request->filled('max_amount')) {
            $query->where('total_amount', '<=', $request->max_amount);
        }

        // Handle export requests
        if ($request->filled('export')) {
            return $this->export($query, $request->export);
        }

        // Get per page value
        $perPage = $request->get('per_page', 15);
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 15;
        }

        // Get paginated results
        $bookings = $query->orderBy('created_at', 'desc')->paginate($perPage);
        
        // Load services for the multi-step admin booking UI
        $services = Service::where('status', 'active')->get();

        // Load a small set of customers for initial display (limit to 50)
        // Users are considered customers if they have a related CustomerProfile
        $customers = User::whereHas('customerProfile')->orderBy('created_at', 'desc')->limit(50)->get();

        return view('admin.admin-booking.index', compact('bookings', 'services', 'customers'));
    }

    /**
     * Export bookings to Excel or PDF
     */
    private function export($query, $format)
    {
        $bookings = $query->get();
        
        if ($format === 'excel') {
            return $this->exportToExcel($bookings);
        } elseif ($format === 'pdf') {
            return $this->exportToPDF($bookings);
        }
        
        return redirect()->back();
    }

    /**
     * Export to Excel
     */
    private function exportToExcel($bookings)
    {
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="admin-bookings-' . date('Y-m-d') . '.xlsx"',
        ];

        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for proper UTF-8 encoding
            fwrite($file, "\xEF\xBB\xBF");
            
            // Headers
            fputcsv($file, [
                'ID',
                'Customer Name',
                'Customer Email',
                'Professional Name',
                'Professional Email',
                'Service Name',
                'Session Type',
                'Booking Date',
                'Total Amount',
                'Status',
                'Created At'
            ]);

            // Data
            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->customer_name,
                    optional($booking->user)->email,
                    optional($booking->professional)->name,
                    optional($booking->professional)->email,
                    $booking->service_name,
                    $booking->session_type,
                    $booking->booking_date,
                    $booking->total_amount,
                    $booking->status,
                    $booking->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export to PDF
     */
    private function exportToPDF($bookings)
    {
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('admin.admin-booking.pdf-export', compact('bookings'));
        
        return $pdf->download('admin-bookings-' . date('Y-m-d') . '.pdf');
    }

    public function create()
    {
        return view('admin.admin-booking.create');
    }

    public function selectCustomer(Request $request)
    {
        $request->validate([
            'customer_type' => 'required|in:existing,new',
            'customer_id' => 'required|exists:users,id',
        ]);

        $customer = User::find($request->customer_id);
        if (!$customer) {
            return back()->with('error', 'Customer not found.');
        }

        session(['admin_booking_customer_id' => $customer->id]);
        return redirect()->route('admin.admin-booking.select-service');
    }

    public function selectService()
    {
        if (!session('admin_booking_customer_id')) {
            return redirect()->route('admin.admin-booking.create')->with('error', 'Please select a customer first.');
        }

        $customer = User::find(session('admin_booking_customer_id'));
        $services = Service::where('status', 'active')->get();
        
        return view('admin.admin-booking.select-service', compact('customer', 'services'));
    }

    public function getSubServices(Request $request)
    {
        try {
            $serviceId = $request->service_id;
            
            if (!$serviceId) {
                return response()->json([]);
            }

            // Fetch active sub-services for the selected service
            $subServices = SubService::where('service_id', $serviceId)
                ->where('status', 1) // 1 = active
                ->select('id', 'name', 'description')
                ->get();

            return response()->json($subServices);
        } catch (\Exception $e) {
            Log::error('Error fetching sub-services: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    public function storeServiceSelection(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'sub_service_id' => 'nullable', // Make sub_service_id optional
        ]);

        session([
            'admin_booking_service_id' => $request->service_id,
            'admin_booking_sub_service_id' => $request->sub_service_id,
        ]);

        return redirect()->route('admin.admin-booking.select-professional');
    }

    public function searchCustomers(Request $request)
    {
        $query = $request->get('query', '');
        
        if (empty(trim($query))) {
            return response()->json([
                'success' => true,
                'customers' => [],
                'message' => 'Empty query'
            ]);
        }
        
        try {
            // Simple search
            $customers = User::where('name', 'like', "%{$query}%")
                           ->orWhere('email', 'like', "%{$query}%")
                           ->limit(15)
                           ->get();

            // Format results
            $results = $customers->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    // return empty string when phone is null so frontend can decide how to display
                    'phone' => $user->phone ?? ''
                ];
            })->toArray();

            return response()->json([
                'success' => true,
                'customers' => $results,
                'total' => $customers->count()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'customers' => [],
                'message' => 'Search failed. Please try again.'
            ], 500);
        }
    }

    public function sendOtp(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
        ], [
            'email.unique' => 'This email address is already registered. Please use the "Existing Customer" option to search for this customer.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        // Generate OTP
        $otp = sprintf('%06d', mt_rand(0, 999999));
        $token = Str::random(64);

        // Store OTP data in cache for 10 minutes
        $otpData = [
            'otp' => $otp,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'expires_at' => now()->addMinutes(10)
        ];

        Cache::put("otp_verification_{$token}", $otpData, 600); // 10 minutes

        try {
            // Send OTP email
            Mail::to($request->email)->send(new OtpVerificationMail($otp, $request->first_name));
            
            return response()->json([
                'success' => true,
                'token' => $token,
                'message' => 'OTP sent successfully to your email.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'otp' => 'required|string|size:6',
        ]);

        $otpData = Cache::get("otp_verification_{$request->token}");

        if (!$otpData) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired or invalid. Please request a new OTP.'
            ], 400);
        }

        if ($otpData['otp'] !== $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP. Please try again.'
            ], 400);
        }

        if (now()->gt($otpData['expires_at'])) {
            Cache::forget("otp_verification_{$request->token}");
            return response()->json([
                'success' => false,
                'message' => 'OTP expired. Please request a new OTP.'
            ], 400);
        }

        try {
            // Create user
            $fullName = trim($otpData['first_name'] . ' ' . $otpData['last_name']);
            
            $user = User::create([
                'name' => $fullName,
                'email' => $otpData['email'],
                'phone' => $otpData['phone'],
                'password' => 'temporary123', // Will be updated when password is set
                'email_verified_at' => now(),
            ]);

            // Remove OTP data from cache
            Cache::forget("otp_verification_{$request->token}");

            return response()->json([
                'success' => true,
                'customer_id' => $user->id,
                'message' => 'OTP verified successfully. Please set a password.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create customer account. Please try again.'
            ], 500);
        }
    }

    public function setPassword(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = User::find($request->customer_id);
            $user->password = $request->password; // Model mutator will hash it
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Password set successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to set password. Please try again.'
            ], 500);
        }
    }

    // Step: Select Professional for the chosen service
    public function selectProfessional()
    {
        if (!session('admin_booking_customer_id')) {
            return redirect()->route('admin.admin-booking.create')->with('error', 'Please select a customer first.');
        }

        if (!session('admin_booking_service_id')) {
            return redirect()->route('admin.admin-booking.select-service')->with('error', 'Please select a service first.');
        }

        $customer = User::find(session('admin_booking_customer_id'));
        $serviceId = session('admin_booking_service_id');
        $subServiceId = session('admin_booking_sub_service_id'); // Can be null

        // Load professional services matching the selected service
        $query = ProfessionalService::where('service_id', $serviceId)
            ->with([
                'professional.profile', 
                'professional.rates' => function($q) use ($serviceId, $subServiceId) {
                    $q->where('service_id', $serviceId);
                    if ($subServiceId) {
                        $q->where('sub_service_id', $subServiceId);
                    } else {
                        $q->whereNull('sub_service_id');
                    }
                },
                'professional.reviews',
                'subServices'
            ]);

        // If sub-service is selected, filter professionals who have that sub-service
        if ($subServiceId) {
            $query->whereHas('subServices', function($q) use ($subServiceId) {
                $q->where('sub_services.id', $subServiceId);
            });
        }

        $professionalServices = $query->get();

        // Extract unique professionals with their rates
        $professionals = $professionalServices->pluck('professional')->unique('id')->filter();

        return view('admin.admin-booking.select-professional', compact('customer', 'professionals'));
    }

    public function storeProfessionalSelection(Request $request)
    {
        $request->validate([
            'professional_id' => 'required|exists:professionals,id',
        ]);

        if (!session('admin_booking_customer_id') || !session('admin_booking_service_id')) {
            return redirect()->route('admin.admin-booking.create')->with('error', 'Session expired. Please start over.');
        }

        session(['admin_booking_professional_id' => $request->professional_id]);
        
        return redirect()->route('admin.admin-booking.select-session');
    }

    // Step: Select Session (e.g., session type or plan)
    public function selectSession()
    {
        if (!session('admin_booking_customer_id') || !session('admin_booking_professional_id') || !session('admin_booking_service_id')) {
            return redirect()->route('admin.admin-booking.create')->with('error', 'Please complete previous steps first.');
        }

        $customer = User::find(session('admin_booking_customer_id'));
        $professional = Professional::find(session('admin_booking_professional_id'));
        $serviceId = session('admin_booking_service_id');
        $subServiceId = session('admin_booking_sub_service_id'); // Can be null

        // Load available rate sessions for this professional based on service/sub-service
        $sessionsQuery = Rate::where('professional_id', $professional->id)
            ->where('service_id', $serviceId);

        // If sub-service is selected, filter by sub-service, otherwise get service-level rates
        if ($subServiceId) {
            $sessionsQuery->where('sub_service_id', $subServiceId);
        } else {
            $sessionsQuery->whereNull('sub_service_id');
        }

        $sessions = $sessionsQuery->get();
        
        // If no exact service match found and we're looking for sub-service, try broader search
        if ($sessions->isEmpty() && $subServiceId) {
            // Look for any rate with this sub-service ID for this professional
            $sessions = Rate::where('professional_id', $professional->id)
                ->where('sub_service_id', $subServiceId)
                ->get();
        }

        return view('admin.admin-booking.select-session', compact('customer', 'professional', 'sessions'));
    }

    public function storeSessionSelection(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:rates,id',
        ]);

        // Store the selected rate/session
        $selectedRate = Rate::find($request->session_id);
        session([
            'admin_booking_session_id' => $request->session_id,
            'admin_booking_session_type' => $selectedRate->session_type,
            'admin_booking_amount' => $selectedRate->final_rate,
        ]);

        return redirect()->route('admin.admin-booking.select-datetime');
    }

    // Step: Select Date & Time
    public function selectDateTime()
    {
        if (!session('admin_booking_customer_id') || !session('admin_booking_professional_id') || !session('admin_booking_session_id')) {
            return redirect()->route('admin.admin-booking.create')->with('error', 'Please complete previous steps first.');
        }

        $customer = User::find(session('admin_booking_customer_id'));
        $professional = Professional::find(session('admin_booking_professional_id'));
        $selectedRate = Rate::find(session('admin_booking_session_id'));

        // Get professional's availability - only get future availabilities
        $currentMonth = Carbon::now()->format('Y-m'); // Current month in YYYY-MM format
        $availabilities = Availability::where('professional_id', $professional->id)
            ->where('month', '>=', $currentMonth) // Only future and current month availabilities
            ->with('slots')
            ->get();
        
        // Calculate enabled dates based on professional's availability
        $enabledDates = $this->calculateEnabledDates($availabilities);
        
        // Get existing bookings for this professional
        $existingBookings = BookingTimedate::getBookedSlots($professional->id);

        return view('admin.admin-booking.select-datetime', compact('customer', 'professional', 'selectedRate', 'enabledDates', 'existingBookings'));
    }

    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'professional_id' => 'required|exists:professionals,id'
        ]);

        $professionalId = $request->professional_id;
        $date = $request->date;
        
        // Get day names in different formats for comparison
        $carbonDate = Carbon::parse($date);
        $dayName3Letter = strtolower($carbonDate->format('D')); // mon, tue, etc.
        $dayNameFull = strtolower($carbonDate->format('l')); // monday, tuesday, etc.
        $monthKey = $carbonDate->format('Y-m'); // 2026-05 format to match availability storage
        
        $availability = Availability::where('professional_id', $professionalId)
            ->where('month', $monthKey)
            ->with('slots')
            ->first();

        if (!$availability) {
            return response()->json([
                'available_slots' => [],
                'message' => "No availability set for {$monthKey}"
            ]);
        }

        // Get slots for the specific weekday using the new weekday-specific structure
        $daySlots = [];
        if ($availability->slots && $availability->slots->count() > 0) {
            // Filter slots that match the requested weekday (try both formats)
            $matchingSlots = $availability->slots->filter(function($slot) use ($dayName3Letter, $dayNameFull) {
                $slotWeekday = strtolower($slot->weekday);
                return $slotWeekday === $dayName3Letter || $slotWeekday === $dayNameFull;
            });
            
            if ($matchingSlots->count() > 0) {
                // Professional has specific slots for this weekday
                foreach ($matchingSlots as $slot) {
                    try {
                        $startTime = Carbon::parse($slot->start_time)->format('h:i A');
                        $endTime = Carbon::parse($slot->end_time)->format('h:i A');
                        $daySlots[] = "{$startTime} - {$endTime}";
                    } catch (\Exception $e) {
                        // Skip invalid time slots
                        Log::warning("Invalid time slot format for slot ID {$slot->id}: start={$slot->start_time}, end={$slot->end_time}");
                        continue;
                    }
                }
            }
        }
        
        // If no slots found for this specific weekday, check if it's a legacy availability
        if (empty($daySlots)) {
            // Check legacy weekdays field as fallback
            $availableWeekdays = $availability->weekdays;
            
            // Handle double JSON encoding
            if (is_string($availableWeekdays) && str_starts_with($availableWeekdays, '"') && str_ends_with($availableWeekdays, '"')) {
                $availableWeekdays = json_decode($availableWeekdays);
            }
            
            if (is_string($availableWeekdays)) {
                $availableWeekdays = json_decode($availableWeekdays);
            }
            
            if (is_string($availableWeekdays)) {
                $availableWeekdays = json_decode($availableWeekdays);
            }
            
            // Debug logging
            if (is_array($availableWeekdays) && (in_array($dayName3Letter, array_map('strtolower', $availableWeekdays)) || in_array($dayNameFull, array_map('strtolower', $availableWeekdays)))) {
                // Use general slots for legacy availability
                if ($availability->slots && $availability->slots->count() > 0) {
                    foreach ($availability->slots as $slot) {
                        try {
                            $startTime = Carbon::parse($slot->start_time)->format('h:i A');
                            $endTime = Carbon::parse($slot->end_time)->format('h:i A');
                            $daySlots[] = "{$startTime} - {$endTime}";
                        } catch (\Exception $e) {
                            Log::warning("Invalid time slot format for slot ID {$slot->id}: start={$slot->start_time}, end={$slot->end_time}");
                            continue;
                        }
                    }
                } else {
                    // Use default time slots as final fallback
                    $daySlots = [
                        '09:00 AM - 10:00 AM',
                        '10:00 AM - 11:00 AM', 
                        '11:00 AM - 12:00 PM',
                        '12:00 PM - 01:00 PM',
                        '02:00 PM - 03:00 PM',
                        '03:00 PM - 04:00 PM',
                        '04:00 PM - 05:00 PM',
                        '05:00 PM - 06:00 PM',
                        '06:00 PM - 07:00 PM',
                        '07:00 PM - 08:00 PM',
                    ];
                }
            }
        }

        if (empty($daySlots)) {
            return response()->json([
                'available_slots' => [],
                'message' => 'Professional not available on this day',
                'debug' => [
                    'day_3_letter' => $dayName3Letter,
                    'day_full' => $dayNameFull,
                    'slotsCount' => $availability->slots ? $availability->slots->count() : 0,
                    'slotsWithWeekday3' => $availability->slots ? $availability->slots->where('weekday', $dayName3Letter)->count() : 0,
                    'slotsWithWeekdayFull' => $availability->slots ? $availability->slots->where('weekday', $dayNameFull)->count() : 0
                ]
            ]);
        }

        // Get booked slots for this date
        $bookedSlots = BookingTimedate::getBookedSlots($professionalId)[$date] ?? [];

        // Filter out booked slots
        $availableSlots = array_diff($daySlots, $bookedSlots);

        return response()->json([
            'available_slots' => array_values($availableSlots),
            'booked_slots' => $bookedSlots,
            'all_slots' => $daySlots
        ]);
    }

    public function storeDateTimeSelection(Request $request)
    {
        $request->validate([
            'booking_dates' => 'required|string',
        ]);

        // Decode the JSON string to array
        $bookingDates = json_decode($request->booking_dates, true);
        
        if (!is_array($bookingDates) || empty($bookingDates)) {
            return back()->with('error', 'Please select at least one date and time slot.');
        }

        // Validate each booking date
        foreach ($bookingDates as $booking) {
            if (!isset($booking['date']) || !isset($booking['time_slot'])) {
                return back()->with('error', 'Invalid booking data format.');
            }
        }

        session(['admin_booking_datetime_selections' => $bookingDates]);

        return redirect()->route('admin.admin-booking.confirm');
    }

    public function confirm()
    {
        if (!session('admin_booking_customer_id') || !session('admin_booking_professional_id') || !session('admin_booking_session_id')) {
            return redirect()->route('admin.admin-booking.create')->with('error', 'Please complete all steps first.');
        }

        $customer = User::find(session('admin_booking_customer_id'));
        $professional = Professional::find(session('admin_booking_professional_id'));
        $selectedRate = Rate::find(session('admin_booking_session_id'));
        $service = Service::find(session('admin_booking_service_id'));
        $subService = session('admin_booking_sub_service_id') ? SubService::find(session('admin_booking_sub_service_id')) : null;
        $datetimeSelections = session('admin_booking_datetime_selections', []);

        return view('admin.admin-booking.confirm', compact('customer', 'professional', 'selectedRate', 'service', 'subService', 'datetimeSelections'));
    }

    public function processBooking(Request $request)
    {
        $request->validate([
            'payment_status' => 'sometimes|in:pending,paid',
            'transaction_id' => 'nullable|string|max:255',
            'payment_method' => 'nullable|string|max:100',
            'payment_screenshot' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:5120',
            'payment_notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            $customer = User::find(session('admin_booking_customer_id'));
            $professional = Professional::find(session('admin_booking_professional_id'));
            $selectedRate = Rate::find(session('admin_booking_session_id'));
            $service = Service::find(session('admin_booking_service_id'));
            $subService = session('admin_booking_sub_service_id') ? SubService::find(session('admin_booking_sub_service_id')) : null;
            $datetimeSelections = session('admin_booking_datetime_selections', []);

            if (!$customer || !$professional || !$selectedRate || !$service || empty($datetimeSelections)) {
                throw new \Exception('Missing required booking data');
            }

            // For admin bookings, default to paid status unless specified otherwise
            $paymentStatus = $request->input('payment_status', 'paid');
            
            // Handle payment screenshot upload
            $paymentScreenshot = null;
            if ($request->hasFile('payment_screenshot')) {
                $file = $request->file('payment_screenshot');
                $fileName = 'payment_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $paymentScreenshot = $file->storeAs('payment_screenshots', $fileName, 'public');
            }
            
            // Calculate GST (9% CGST + 9% SGST = 18% total)
            $baseAmount = $selectedRate->final_rate;
            $cgstAmount = $baseAmount * 0.09;
            $sgstAmount = $baseAmount * 0.09;
            $totalAmount = $baseAmount + $cgstAmount + $sgstAmount;

            // Get first booking date for main booking record
            $firstBookingDate = Carbon::parse($datetimeSelections[0]['date']);

            // Create the main booking record - matching CustomerBookingController structure
            $booking = Booking::create([
                'user_id' => $customer->id, // Use user_id as per database structure
                'professional_id' => $professional->id,
                'service_id' => $service->id,
                'sub_service_id' => $subService ? $subService->id : null,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone ?? '',
                'service_name' => $service->name,
                'sub_service_name' => $subService ? $subService->name : null,
                'session_type' => $selectedRate->session_type,
                'plan_type' => $selectedRate->session_type, // Add plan_type field
                'amount' => $totalAmount, // Total amount including GST
                'base_amount' => $baseAmount,
                'cgst_amount' => $cgstAmount, // 9% CGST
                'sgst_amount' => $sgstAmount, // 9% SGST
                'igst_amount' => 0,
                'payment_status' => $paymentStatus,
                'paid_status' => $paymentStatus === 'paid' ? 'paid' : 'unpaid', // Add paid_status field
                'transaction_id' => $request->input('transaction_id'),
                'payment_method' => $request->input('payment_method'),
                'payment_screenshot' => $paymentScreenshot,
                'payment_notes' => $request->input('payment_notes'),
                'booking_date' => $firstBookingDate->format('Y-m-d'),
                'booking_time' => $datetimeSelections[0]['time_slot'] ?? '09:00',
                'month' => $firstBookingDate->format('M'), // Add month field
                'days' => json_encode(array_map(function ($b) {
                    return Carbon::parse($b['date'])->day;
                }, $datetimeSelections)), // Add days field
                'time_slot' => json_encode(array_column($datetimeSelections, 'time_slot')), // Add time_slot field
                'status' => 'pending',
                'created_by' => 'admin',
            ]);

            // Create booking time date records
            foreach ($datetimeSelections as $datetime) {
                BookingTimedate::create([
                    'booking_id' => $booking->id,
                    'date' => $datetime['date'],
                    'time_slot' => $datetime['time_slot'],
                    'status' => 'pending',
                ]);
            }

            // Clear session data
            session()->forget([
                'admin_booking_customer_id',
                'admin_booking_service_id',
                'admin_booking_sub_service_id', 
                'admin_booking_professional_id',
                'admin_booking_session_id',
                'admin_booking_session_type',
                'admin_booking_amount',
                'admin_booking_datetime_selections'
            ]);

            DB::commit();

            // Check if this is an AJAX request
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Booking created successfully!',
                    'booking_id' => $booking->id,
                    'redirect' => route('admin.admin-booking.index') . '?booking_created=' . $booking->id
                ]);
            }

            return redirect()->route('admin.admin-booking.index')
                ->with('success', 'Booking created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Admin booking creation failed: ' . $e->getMessage(), [
                'customer_id' => session('admin_booking_customer_id'),
                'professional_id' => session('admin_booking_professional_id'),
                'session_id' => session('admin_booking_session_id'),
                'datetime_selections' => session('admin_booking_datetime_selections'),
                'stack_trace' => $e->getTraceAsString()
            ]);
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create booking: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to create booking: ' . $e->getMessage());
        }
    }

    public function success($bookingId)
    {
        $booking = Booking::with(['user', 'professional', 'timedates'])->findOrFail($bookingId);
        return view('admin.admin-booking.success', compact('booking'));
    }

    /**
     * Calculate enabled dates based on professional's availability
     */
    private function calculateEnabledDates($availabilities)
    {
        $enabledDates = [];
        
        // Map day names to Carbon weekday names (support both 3-letter and full names)
        $dayMap = [
            'mon' => 'monday',
            'tue' => 'tuesday', 
            'wed' => 'wednesday',
            'thu' => 'thursday',
            'fri' => 'friday',
            'sat' => 'saturday',
            'sun' => 'sunday',
            'monday' => 'monday',
            'tuesday' => 'tuesday',
            'wednesday' => 'wednesday',
            'thursday' => 'thursday',
            'friday' => 'friday',
            'saturday' => 'saturday',
            'sunday' => 'sunday',
        ];

        if ($availabilities->isEmpty()) {
            return $enabledDates;
        }

        // Process each availability month individually
        foreach ($availabilities as $availability) {
            $availabilityMonth = $availability->month; // e.g., "2026-05"
            
            // Parse the month to get year and month
            try {
                $monthDate = Carbon::createFromFormat('Y-m', $availabilityMonth)->startOfMonth();
                $monthStart = $monthDate->copy();
                $monthEnd = $monthDate->copy()->endOfMonth();
                
                // Make sure we don't go before today
                $startDate = Carbon::today()->max($monthStart);
                $endDate = $monthEnd;
                
            } catch (\Exception $e) {
                continue;
            }
            
            // Skip if the entire month is in the past
            if ($endDate->isPast()) {
                continue;
            }
            
            // Get weekdays available for this month
            $availableWeekdays = collect();
            
            // Get weekdays from slots (new structure)
            if ($availability->slots && $availability->slots->count() > 0) {
                foreach ($availability->slots as $slot) {
                    if ($slot->weekday) {
                        $weekday = strtolower($slot->weekday);
                        if (isset($dayMap[$weekday])) {
                            $availableWeekdays->push($dayMap[$weekday]);
                        }
                    }
                }
            }
            
            // Fallback to legacy weekdays field if no slots found
            if ($availableWeekdays->isEmpty() && $availability->weekdays) {
                $weekdays = $availability->weekdays;
                
                // Handle potential double JSON encoding
                if (is_string($weekdays) && str_starts_with($weekdays, '"') && str_ends_with($weekdays, '"')) {
                    $weekdays = json_decode($weekdays);
                }
                
                if (is_string($weekdays)) {
                    $weekdays = json_decode($weekdays);
                }
                
                if (is_array($weekdays)) {
                    foreach ($weekdays as $day) {
                        $dayLower = strtolower($day);
                        if (isset($dayMap[$dayLower])) {
                            $availableWeekdays->push($dayMap[$dayLower]);
                        }
                    }
                }
            }
            
            $availableWeekdays = $availableWeekdays->unique();

            // Generate dates for this specific month where professional is available
            if ($availableWeekdays->isNotEmpty()) {
                $period = CarbonPeriod::create($startDate, $endDate);
                
                foreach ($period as $date) {
                    $dayName = strtolower($date->format('l')); // monday, tuesday, etc.
                    
                    if ($availableWeekdays->contains($dayName)) {
                        $enabledDates[] = $date->toDateString();
                    }
                }
            }
        }

        return array_unique($enabledDates);
    }

    /**
     * Initiate payment for admin booking
     */
    public function initiatePayment(Request $request)
    {
        Log::info('Admin payment initiation started', [
            'request_data' => $request->all(),
            'session_data' => [
                'customer_id' => session('admin_booking_customer_id'),
                'professional_id' => session('admin_booking_professional_id'),
                'session_id' => session('admin_booking_session_id'),
                'service_id' => session('admin_booking_service_id'),
                'datetime_selections' => session('admin_booking_datetime_selections')
            ]
        ]);

        try {
            // Validate session data
            if (!session('admin_booking_customer_id') || !session('admin_booking_professional_id') || !session('admin_booking_session_id')) {
                Log::error('Admin payment initiation: Missing session data', [
                    'customer_id' => session('admin_booking_customer_id'),
                    'professional_id' => session('admin_booking_professional_id'),
                    'session_id' => session('admin_booking_session_id')
                ]);
                
                return response()->json([
                    'status' => 'error',
                    'message' => 'Booking session expired. Please start over.'
                ], 400);
            }

            $customer = User::find(session('admin_booking_customer_id'));
            $selectedRate = Rate::find(session('admin_booking_session_id'));
            
            if (!$customer || !$selectedRate) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid booking data.'
                ], 400);
            }

            // Calculate amount with GST
            $baseAmount = $selectedRate->final_rate;
            $cgst = $baseAmount * 0.09; // 9% CGST
            $sgst = $baseAmount * 0.09; // 9% SGST
            $totalWithGst = $baseAmount + $cgst + $sgst;
            
            // Store GST details in session
            session(['admin_booking_gst_details' => [
                'base_amount' => $baseAmount,
                'cgst' => $cgst,
                'sgst' => $sgst,
                'total_with_gst' => $totalWithGst
            ]]);

            $amount = $totalWithGst * 100; // Convert to paise for Razorpay
            
            // Check Razorpay credentials
            $razorpayKey = config('services.razorpay.key');
            $razorpaySecret = config('services.razorpay.secret');
            
            if (!$razorpayKey || !$razorpaySecret) {
                Log::error('Razorpay configuration missing for admin booking', [
                    'key_present' => !empty($razorpayKey),
                    'secret_present' => !empty($razorpaySecret),
                    'customer_id' => $customer->id
                ]);
                
                return response()->json([
                    'status' => 'error',
                    'message' => 'Payment gateway configuration error. Please contact support.'
                ], 500);
            }

            $api = new Api($razorpayKey, $razorpaySecret);

            $order = $api->order->create([
                'amount' => $amount,
                'currency' => 'INR',
                'payment_capture' => 1
            ]);

            // Store order details in session
            session(['admin_booking_razorpay_order_id' => $order->id]);

            return response()->json([
                'status' => 'success',
                'order_id' => $order->id,
                'amount' => $amount,
                'key' => $razorpayKey,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone ?? '9999999999'
            ]);
        } catch (\Exception $e) {
            Log::error('Admin booking payment initiation failed: ' . $e->getMessage(), [
                'customer_id' => session('admin_booking_customer_id'),
                'stack_trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Payment initiation failed. Please try again.'
            ], 500);
        }
    }

    public function verifyPayment(Request $request)
    {
        // Force log with file driver to ensure it's written
        Log::channel('single')->info('==== ADMIN PAYMENT VERIFICATION STARTED ====', [
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'payment_id' => $request->razorpay_payment_id ?? null,
            'order_id' => $request->razorpay_order_id ?? null,
            'request_data' => $request->all(),
            'session_data' => [
                'customer_id' => session('admin_booking_customer_id'),
                'professional_id' => session('admin_booking_professional_id'),
                'session_id' => session('admin_booking_session_id'),
                'service_id' => session('admin_booking_service_id'),
                'datetime_selections' => session('admin_booking_datetime_selections')
            ]
        ]);
        
        Log::info('Payment verification started', [
            'payment_id' => $request->razorpay_payment_id ?? null,
            'order_id' => $request->razorpay_order_id ?? null,
            'session_data' => [
                'customer_id' => session('admin_booking_customer_id'),
                'professional_id' => session('admin_booking_professional_id'),
                'session_id' => session('admin_booking_session_id'),
                'service_id' => session('admin_booking_service_id'),
                'datetime_selections' => session('admin_booking_datetime_selections')
            ]
        ]);

        try {
            $request->validate([
                'razorpay_payment_id' => 'required',
                'razorpay_order_id' => 'required',
                'razorpay_signature' => 'required'
            ]);

            // Verify payment signature
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);
            Log::info('Payment signature verified successfully');

            // Payment verification successful, now create the booking
            DB::beginTransaction();

            $customer = User::find(session('admin_booking_customer_id'));
            $professional = Professional::find(session('admin_booking_professional_id'));
            $selectedRate = Rate::find(session('admin_booking_session_id'));
            $service = Service::find(session('admin_booking_service_id'));
            $subService = session('admin_booking_sub_service_id') ? SubService::find(session('admin_booking_sub_service_id')) : null;
            $datetimeSelections = session('admin_booking_datetime_selections', []);
            $gstDetails = session('admin_booking_gst_details', []);

            Log::channel('single')->info('==== SESSION DATA CHECK ====', [
                'customer_found' => $customer ? 'YES (ID: '.$customer->id.')' : 'NO',
                'professional_found' => $professional ? 'YES (ID: '.$professional->id.')' : 'NO',
                'selectedRate_found' => $selectedRate ? 'YES (ID: '.$selectedRate->id.')' : 'NO',
                'service_found' => $service ? 'YES (ID: '.$service->id.')' : 'NO',
                'sub_service_found' => $subService ? 'YES (ID: '.$subService->id.')' : 'NO (Optional)',
                'datetime_selections_count' => count($datetimeSelections),
                'datetime_selections' => $datetimeSelections,
                'gst_details' => $gstDetails
            ]);

            if (!$customer || !$professional || !$selectedRate || !$service || empty($datetimeSelections)) {
                $missingData = [];
                if (!$customer) $missingData[] = 'Customer (session key: admin_booking_customer_id)';
                if (!$professional) $missingData[] = 'Professional (session key: admin_booking_professional_id)';
                if (!$selectedRate) $missingData[] = 'Rate (session key: admin_booking_session_id)';
                if (!$service) $missingData[] = 'Service (session key: admin_booking_service_id)';
                if (empty($datetimeSelections)) $missingData[] = 'Datetime selections (session key: admin_booking_datetime_selections)';
                
                $errorMessage = 'Missing required booking data: ' . implode(', ', $missingData);
                Log::channel('single')->error('==== BOOKING DATA MISSING ====', [
                    'missing_data' => $missingData,
                    'all_session_keys' => array_keys(session()->all()),
                    'admin_booking_session_keys' => array_filter(array_keys(session()->all()), function($key) {
                        return strpos($key, 'admin_booking_') === 0;
                    })
                ]);
                
                throw new \Exception($errorMessage);
            }

            Log::info('Creating booking with data', [
                'customer_id' => $customer->id,
                'professional_id' => $professional->id,
                'service_name' => $service->name,
                'session_type' => $selectedRate->session_type,
                'amount' => $gstDetails['total_with_gst'] ?? $selectedRate->final_rate,
                'datetime_selections_count' => count($datetimeSelections)
            ]);

            // Get first booking date for main booking record
            $firstBookingDate = Carbon::parse($datetimeSelections[0]['date']);

            // Create the main booking record with payment details - matching CustomerBookingController
            $booking = Booking::create([
                'user_id' => $customer->id, // Use user_id as per database structure
                'professional_id' => $professional->id,
                'service_id' => $service->id,
                'sub_service_id' => $subService ? $subService->id : null,
                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'customer_phone' => $customer->phone ?? '',
                'service_name' => $service->name,
                'sub_service_name' => $subService ? $subService->name : null,
                'session_type' => $selectedRate->session_type,
                'plan_type' => $selectedRate->session_type, // Add plan_type field
                'amount' => $gstDetails['total_with_gst'] ?? $selectedRate->final_rate,
                'base_amount' => $gstDetails['base_amount'] ?? $selectedRate->final_rate,
                'cgst_amount' => $gstDetails['cgst'] ?? 0,
                'sgst_amount' => $gstDetails['sgst'] ?? 0,
                'igst_amount' => $gstDetails['igst'] ?? 0,
                'payment_status' => 'paid',
                'paid_status' => 'paid', // Add paid_status field
                'payment_id' => $request->razorpay_payment_id, // Use payment_id field
                'booking_date' => $firstBookingDate->format('Y-m-d'),
                'booking_time' => $datetimeSelections[0]['time_slot'] ?? '09:00',
                'month' => $firstBookingDate->format('M'), // Add month field
                'days' => json_encode(array_map(function ($b) {
                    return Carbon::parse($b['date'])->day;
                }, $datetimeSelections)), // Add days field
                'time_slot' => json_encode(array_column($datetimeSelections, 'time_slot')), // Add time_slot field
                'status' => 'pending',
                'created_by' => 'admin',
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
            ]);

            Log::info('Booking created successfully', ['booking_id' => $booking->id]);

            // Create booking time date records
            foreach ($datetimeSelections as $datetime) {
                BookingTimedate::create([
                    'booking_id' => $booking->id,
                    'date' => $datetime['date'],
                    'time_slot' => $datetime['time_slot'],
                    'status' => 'pending',
                ]);
            }

            Log::info('Booking time dates created', ['count' => count($datetimeSelections)]);

            // Clear session data
            session()->forget([
                'admin_booking_customer_id',
                'admin_booking_service_id',
                'admin_booking_sub_service_id', 
                'admin_booking_professional_id',
                'admin_booking_session_id',
                'admin_booking_session_type',
                'admin_booking_amount',
                'admin_booking_datetime_selections',
                'admin_booking_gst_details',
                'admin_booking_razorpay_order_id'
            ]);

            DB::commit();

            $redirectUrl = route('admin.admin-booking.index') . '?booking_created=' . $booking->id;
            Log::info('Payment verification successful, redirecting to', ['url' => $redirectUrl]);
            
            // Force log with file driver
            Log::channel('single')->info('==== ADMIN PAYMENT VERIFICATION COMPLETE ====', [
                'timestamp' => now()->format('Y-m-d H:i:s'),
                'booking_id' => $booking->id,
                'booking_status' => $booking->status,
                'payment_status' => $booking->payment_status,
                'redirect_url' => $redirectUrl,
                'message' => 'Payment verified successfully and booking created'
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment verified and booking confirmed!',
                'booking_id' => $booking->id,
                'redirect' => $redirectUrl
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Admin booking payment verification failed: ' . $e->getMessage(), [
                'payment_id' => $request->razorpay_payment_id ?? null,
                'order_id' => $request->razorpay_order_id ?? null,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'session_data' => [
                    'customer_id' => session('admin_booking_customer_id'),
                    'professional_id' => session('admin_booking_professional_id'),
                    'session_id' => session('admin_booking_session_id'),
                    'service_id' => session('admin_booking_service_id'),
                    'datetime_selections' => session('admin_booking_datetime_selections')
                ]
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get booking details for modal view
     */
    public function getBookingDetails($id)
    {
        try {
            $booking = Booking::with(['user', 'professional', 'timedates', 'service', 'subService'])
                ->findOrFail($id);

            $html = view('admin.admin-booking.partials.booking-details', compact('booking'))->render();

            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load booking details: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mark booking as paid
     */
    public function markAsPaid(Request $request, $id)
    {
        $request->validate([
            'payment_method' => 'nullable|string|max:100',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        try {
            $booking = Booking::findOrFail($id);

            $booking->update([
                'payment_status' => 'paid',
                'paid_status' => 'paid',
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Booking marked as paid successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update payment status: ' . $e->getMessage()
            ], 500);
        }
    }
}
