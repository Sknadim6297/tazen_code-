<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Razorpay\Api\Api;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\McqAnswer;
use App\Models\BookingTimedate;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\BookingSummaryMail;
use App\Mail\PaymentFailureMail;
use App\Models\PaymentFailureLog;
use App\Models\ProfessionalService;
use App\Notifications\PaymentFailureNotification;

class CustomerBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function initiatePayment(Request $request)
    {
        try {
            // Check if user is authenticated
            if (!Auth::guard('user')->check()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authentication failed. Please login to continue.',
                    'redirect' => route('user.login')
                ], 401);
            }

            $request->validate([
                'phone' => 'required|string|min:10|max:10',
            ]);

            $bookingData = session('booking_data');
            if (!$bookingData) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No booking data found. Please start the booking process again.'
                ], 400);
            }

            $user = Auth::guard('user')->user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User authentication failed. Please login again.',
                    'redirect' => route('user.login')
                ], 401);
            }

            // Calculate GST
            $baseAmount = $bookingData['total_amount'];
            $cgst = $baseAmount * 0.09; // 9% CGST
            $sgst = $baseAmount * 0.09; // 9% SGST
            $igst = 0; // 0% IGST
            $totalWithGst = $baseAmount + $cgst + $sgst + $igst;
            
            // Store GST details in session for later use
            session(['booking_gst_details' => [
                'base_amount' => $baseAmount,
                'cgst' => $cgst,
                'sgst' => $sgst,
                'igst' => $igst,
                'total_with_gst' => $totalWithGst
            ]]);

            $amount = $totalWithGst * 100; // Convert to paise for Razorpay
            
            // Check Razorpay credentials
            $razorpayKey = config('services.razorpay.key');
            $razorpaySecret = config('services.razorpay.secret');
            
            if (!$razorpayKey || !$razorpaySecret) {
                Log::error('Razorpay configuration missing', [
                    'key_present' => !empty($razorpayKey),
                    'secret_present' => !empty($razorpaySecret),
                    'user_id' => Auth::guard('user')->id()
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
            session(['razorpay_order_id' => $order->id]);
            session(['customer_phone' => $request->phone]);

            return response()->json([
                'status' => 'success',
                'order_id' => $order->id,
                'amount' => $amount,
                'key' => $razorpayKey,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $request->phone
            ]);
        } catch (\Exception $e) {
            Log::error('Payment initiation failed: ' . $e->getMessage(), [
                'user_id' => Auth::guard('user')->id(),
                'request_data' => $request->all(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Payment initiation failed. Please try again or contact support.'
            ], 500);
        }
    }

    public function verifyPayment(Request $request)
    {
        try {
            Log::info('BOOKING DEBUG: Payment verification started', [
                'request_data' => $request->all(),
                'session_booking_data' => session('booking_data'),
                'session_gst_details' => session('booking_gst_details'),
                'session_phone' => session('customer_phone')
            ]);

            // Check if user is authenticated
            if (!Auth::guard('user')->check()) {
                Log::error('BOOKING DEBUG: User not authenticated');
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authentication failed. Please login to continue.',
                    'redirect' => route('user.login')
                ], 401);
            }

            $user = Auth::guard('user')->user();
            if (!$user) {
                Log::error('BOOKING DEBUG: User object is null');
                return response()->json([
                    'status' => 'error',
                    'message' => 'User authentication failed. Please login again.',
                    'redirect' => route('user.login')
                ], 401);
            }

            Log::info('BOOKING DEBUG: User authenticated', ['user_id' => $user->id, 'user_email' => $user->email]);

            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            Log::info('BOOKING DEBUG: Verifying Razorpay signature', $attributes);
            $api->utility->verifyPaymentSignature($attributes);
            Log::info('BOOKING DEBUG: Razorpay signature verified successfully');

            // Get booking data from session
            $bookingData = session('booking_data');
            $gstDetails = session('booking_gst_details');
            $phone = session('customer_phone');

            Log::info('BOOKING DEBUG: Session data retrieved', [
                'booking_data' => $bookingData,
                'gst_details' => $gstDetails,
                'phone' => $phone
            ]);

            if (!$bookingData) {
                Log::error('BOOKING DEBUG: No booking data in session');
                throw new \Exception('No booking data found in session');
            }

            // Get professional details
            $professional = \App\Models\Professional::with('profile')->find($bookingData['professional_id']);
            if (!$professional) {
                Log::error('BOOKING DEBUG: Professional not found', ['professional_id' => $bookingData['professional_id']]);
                throw new \Exception('Professional not found');
            }

            Log::info('BOOKING DEBUG: Professional found', ['professional_id' => $professional->id, 'professional_name' => $professional->name]);
            
            // Get service name with fallbacks
            $serviceName = session('selected_service_name');
            if (!$serviceName || $serviceName === 'N/A') {
                $professionalService = ProfessionalService::with('service')
                    ->where('professional_id', $professional->id)
                    ->first();
                
                if ($professionalService) {
                    if ($professionalService->service && $professionalService->service->name) {
                        $serviceName = $professionalService->service->name;
                    } elseif ($professionalService->service_name) {
                        $serviceName = $professionalService->service_name;
                    }
                }
            }
            
            Log::info('BOOKING DEBUG: Creating booking record', [
                'service_name' => $serviceName,
                'user_id' => Auth::guard('user')->id(),
                'professional_id' => $bookingData['professional_id']
            ]);

            $booking = new Booking();
            $booking->user_id = Auth::guard('user')->id();
            $booking->professional_id = $bookingData['professional_id'];
            $booking->plan_type = $bookingData['plan_type'];
            $booking->customer_phone = $phone;
            $booking->service_name = $serviceName ?? 'N/A';
            
            // Add sub-service data from booking_data session or request
            if (!empty($bookingData['sub_service_id'])) {
                $booking->sub_service_id = $bookingData['sub_service_id'];
            } elseif ($request->has('sub_service_id') && $request->sub_service_id) {
                $booking->sub_service_id = $request->sub_service_id;
            }
            
            if (!empty($bookingData['sub_service_name'])) {
                $booking->sub_service_name = $bookingData['sub_service_name'];
            } elseif ($request->has('sub_service_name') && $request->sub_service_name) {
                $booking->sub_service_name = $request->sub_service_name;
            }
            
            // If we have sub_service_id but no name, fetch it from database
            if ($booking->sub_service_id && !$booking->sub_service_name) {
                $subService = \App\Models\SubService::find($booking->sub_service_id);
                if ($subService) {
                    $booking->sub_service_name = $subService->name;
                }
            }
            
            $booking->session_type = 'online';
            $booking->customer_name = Auth::guard('user')->user()->name;
            $booking->customer_email = Auth::guard('user')->user()->email;
            
            // Store amounts with GST details
            $booking->amount = $gstDetails['total_with_gst'] ?? $bookingData['total_amount']; // Total amount including GST
            $booking->base_amount = $gstDetails['base_amount'] ?? $bookingData['total_amount']; // Base amount before GST
            $booking->cgst_amount = $gstDetails['cgst'] ?? 0;
            $booking->sgst_amount = $gstDetails['sgst'] ?? 0;
            $booking->igst_amount = $gstDetails['igst'] ?? 0;
            $booking->payment_id = $request->razorpay_payment_id;
            $booking->payment_status = 'paid';

            $firstBookingDate = Carbon::parse($bookingData['bookings'][0]['date']);
            $booking->month = $firstBookingDate->format('M');
            $booking->booking_date = $firstBookingDate->format('Y-m-d');
            $booking->days = json_encode(array_map(function ($b) {
                return Carbon::parse($b['date'])->day;
            }, $bookingData['bookings']));
            $booking->time_slot = json_encode(array_column($bookingData['bookings'], 'time_slot'));
            
            Log::info('BOOKING DEBUG: About to save booking', [
                'booking_data' => [
                    'user_id' => $booking->user_id,
                    'professional_id' => $booking->professional_id,
                    'service_name' => $booking->service_name,
                    'amount' => $booking->amount,
                    'base_amount' => $booking->base_amount,
                    'payment_id' => $booking->payment_id,
                    'payment_status' => $booking->payment_status
                ]
            ]);
            
            $booking->save();
            Log::info('BOOKING DEBUG: Booking saved successfully', ['booking_id' => $booking->id]);

            // Store booking info in session for MCQ modal
            $professionalService = null;
            if (isset($bookingData['professional_id'])) {
                $professionalService = \App\Models\ProfessionalService::where('professional_id', $bookingData['professional_id'])
                    ->with('service')
                    ->first();
            }
            
            if ($professionalService && $professionalService->service_id) {
                session([
                    'booking_success.service_id' => $professionalService->service_id,
                    'booking_success.booking_id' => $booking->id,
                    'booking_success.service_name' => $professionalService->service->name ?? $serviceName
                ]);
            }

            // Create booking time dates
            foreach ($bookingData['bookings'] as $entry) {
                BookingTimedate::create([
                    'booking_id' => $booking->id,
                    'date' => Carbon::parse($entry['date'])->format('Y-m-d'),
                    'time_slot' => $entry['time_slot'],
                    'status' => 'pending'
                ]);
            }

            // Link MCQ answers if any
            $serviceId = session('selected_service_id');
            if ($serviceId) {
                McqAnswer::where('user_id', Auth::guard('user')->id())
                    ->where('service_id', $serviceId)
                    ->whereNull('booking_id')
                    ->update(['booking_id' => $booking->id]);
            }
            
            // Get booking time dates for email
            $bookingTimeDates = BookingTimedate::where('booking_id', $booking->id)->get();
            
            // Send booking summary emails to all parties
            try {
                // 1. Send email to customer
                Mail::to($booking->customer_email)->send(new BookingSummaryMail(
                    $booking,
                    $professional,
                    $bookingTimeDates
                ));
                
                // 2. Send email to professional
                if ($professional && $professional->email) {
                    Mail::to($professional->email)->send(new BookingSummaryMail(
                        $booking,
                        $professional,
                        $bookingTimeDates,
                        'professional' // Email type for professional
                    ));
                }
                
                // 3. Send email to admin
                $adminEmails = \App\Models\Admin::pluck('email')->filter()->toArray();
                if (!empty($adminEmails)) {
                    foreach ($adminEmails as $adminEmail) {
                        Mail::to($adminEmail)->send(new BookingSummaryMail(
                            $booking,
                            $professional,
                            $bookingTimeDates,
                            'admin' // Email type for admin
                        ));
                    }
                }
                
                Log::info('Booking confirmation emails sent successfully', [
                    'booking_id' => $booking->id,
                    'customer_email' => $booking->customer_email,
                    'professional_email' => $professional->email ?? 'N/A',
                    'admin_emails_count' => count($adminEmails)
                ]);
                
            } catch (\Exception $e) {
                // Log email sending failure but continue with the process
                Log::error('Failed to send booking summary emails: ' . $e->getMessage(), [
                    'booking_id' => $booking->id,
                    'error_details' => $e->getTraceAsString()
                ]);
            }
            
            // Get service name with fallbacks
            $serviceName = session('selected_service_name');
            if (!$serviceName || $serviceName === 'N/A') {
                $professionalService = ProfessionalService::with('service')
                    ->where('professional_id', $professional->id)
                    ->first();
                
                if ($professionalService) {
                    if ($professionalService->service && $professionalService->service->name) {
                        $serviceName = $professionalService->service->name;
                    } elseif ($professionalService->service_name) {
                        $serviceName = $professionalService->service_name;
                    }
                }
            }
            
            session([
                'booking_success' => [
                    'professional_id' => $professional->id,
                    'professional_name' => $professional->name,
                    'professional_address' => $professional->profile->address ?? 'Address not available',
                    'service_name' => $serviceName ?? 'N/A',
                    'sub_service_id' => $booking->sub_service_id ?? null,
                    'sub_service_name' => $booking->sub_service_name ?? null,
                    'plan_type' => $bookingData['plan_type'],
                    'base_amount' => $gstDetails['base_amount'] ?? $bookingData['total_amount'],
                    'cgst' => $gstDetails['cgst'] ?? 0,
                    'sgst' => $gstDetails['sgst'] ?? 0,
                    'igst' => $gstDetails['igst'] ?? 0,
                    'amount' => $gstDetails['total_with_gst'] ?? $bookingData['total_amount'],
                    'bookings' => $bookingData['bookings']
                ]
            ]);

            $response = [
                'status' => 'success',
                'message' => 'Payment successful and booking confirmed',
                'redirect_url' => route('user.booking.success'),
                'professional_id' => $bookingData['professional_id'], // Add professional_id for MCQ check
                'booking_id' => $booking->id
            ];

            Log::info('BOOKING DEBUG: Payment verification completed successfully', [
                'booking_id' => $booking->id,
                'professional_id' => $booking->professional_id,
                'response' => $response
            ]);

            // Clear booking session data including GST details
            session()->forget(['booking_data', 'booking_gst_details', 'razorpay_order_id', 'customer_phone']);

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('BOOKING DEBUG: Payment verification failed', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Payment verification failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function success()
    {
        if (!session()->has('booking_success')) {
            return redirect()->route('professionals')->with('error', 'No booking information found');
        }

        return view('customer.booking.success');
    }

    /**
     * Get MCQ questions for a service
     */
    public function getMCQQuestions(Request $request)
    {
        try {
            $professionalId = $request->professional_id;
            
            Log::info('MCQ DEBUG: Getting MCQ questions', ['professional_id' => $professionalId]);
            
            // Get the professional's service
            $professionalService = \App\Models\ProfessionalService::with('service')
                ->where('professional_id', $professionalId)
                ->first();
            
            if (!$professionalService || !$professionalService->service_id) {
                Log::warning('MCQ DEBUG: No service found for professional', ['professional_id' => $professionalId]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'No service found for this professional'
                ]);
            }
            
            $serviceId = $professionalService->service_id;
            Log::info('MCQ DEBUG: Found service', ['service_id' => $serviceId]);
            
            // Get MCQ questions for the service
            $mcqQuestions = \App\Models\ServiceMCQ::getQuestionsForService($serviceId);
            Log::info('MCQ DEBUG: Retrieved MCQ questions', ['questions_count' => $mcqQuestions->count()]);
            
            // Format questions for frontend
            $formattedQuestions = $mcqQuestions->map(function($question) {
                return [
                    'id' => $question->id,
                    'question' => $question->question,
                    'question_type' => $question->question_type,
                    'formatted_options' => $question->formatted_options,
                    'has_other_option' => $question->has_other_option
                ];
            });

            $response = [
                'status' => 'success',
                'mcq_questions' => $formattedQuestions,
                'service_id' => $serviceId
            ];
            
            Log::info('MCQ DEBUG: Returning MCQ response', $response);
            
            return response()->json($response);
            
        } catch (\Exception $e) {
            Log::error('MCQ DEBUG: Error fetching MCQ questions', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch questions'
            ], 500);
        }
    }

    /**
     * Submit MCQ answers
     */
    public function submitMCQAnswers(Request $request)
    {
        try {
            $request->validate([
                'service_id' => 'required|integer',
                'answers' => 'required|array',
                'answers.*.mcq_id' => 'required|integer',
                'answers.*.question' => 'required|string',
                'answers.*.answer' => 'required|string',
                'answers.*.other_answer' => 'nullable|string'
            ]);

            $userId = Auth::guard('user')->id();
            $serviceId = $request->service_id;
            $answers = $request->answers;

            // Save each answer
            foreach ($answers as $answer) {
                $mcqId = $answer['mcq_id'];
                $selectedAnswer = $answer['answer'];
                $otherAnswer = $answer['other_answer'] ?? null;

                // If "Other" was selected and other_answer provided, use that
                if ($selectedAnswer === 'Other' && $otherAnswer) {
                    $selectedAnswer = $otherAnswer;
                }

                // Create or update the answer
                \App\Models\McqAnswer::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'service_mcq_id' => $mcqId,
                        'service_id' => $serviceId
                    ],
                    [
                        'question' => $answer['question'],
                        'selected_answer' => $selectedAnswer,
                        'other_answer' => $otherAnswer
                    ]
                );
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Answers submitted successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error submitting MCQ answers: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit answers'
            ], 500);
        }
    }

    /**
     * Display billing history with filters
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function billing(Request $request)
    {
        $query = Booking::where('user_id', Auth::guard('user')->id())
            ->with('professional')
            ->orderBy('created_at', 'desc');
        
        // Apply date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        } elseif ($request->filled('start_date')) {
            $query->where('created_at', '>=', Carbon::parse($request->start_date)->startOfDay());
        } elseif ($request->filled('end_date')) {
            $query->where('created_at', '<=', Carbon::parse($request->end_date)->endOfDay());
        }
        
        // Apply service filter
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }
        
        // Apply plan type filter
        if ($request->filled('plan_type')) {
            $query->where('plan_type', $request->plan_type);
        }
        
        $bookings = $query->get();
        
        // Get all unique services for dropdown
        $services = Booking::where('user_id', Auth::guard('user')->id())
            ->distinct()
            ->pluck('service_name')
            ->filter()
            ->values();
        
        return view('customer.billing.index', compact('bookings', 'services'));
    }

    public function downloadInvoice($id)
    {
        $booking = Booking::with(['professional.profile', 'customer.customerProfile'])->findOrFail($id);

        if ($booking->user_id !== Auth::guard('user')->id()) {
            abort(403, 'Unauthorized');
        }

        $pdf = PDF::loadView('customer.billing.invoice', [
            'booking' => $booking,
            'invoice_no' => 'INV-' . str_pad($booking->id, 6, '0', STR_PAD_LEFT),
            'invoice_date' => $booking->created_at->format('d M Y'),
        ]);

        return $pdf->download('invoice-' . $booking->id . '.pdf');
    }
    public function eventSuccess()
    {
        return view('customer.booking.event_success');
    }
    /**
     * Export filtered billing transactions as PDF
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function exportAllTransactions(Request $request)
    {
        $user = Auth::guard('user')->user();
        $query = Booking::where('user_id', $user->id)
            ->with('professional')
            ->orderBy('created_at', 'desc');
        
        // Apply date range filter
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->start_date)->startOfDay(),
                Carbon::parse($request->end_date)->endOfDay()
            ]);
        } elseif ($request->filled('start_date')) {
            $query->where('created_at', '>=', Carbon::parse($request->start_date)->startOfDay());
        } elseif ($request->filled('end_date')) {
            $query->where('created_at', '<=', Carbon::parse($request->end_date)->endOfDay());
        }
        
        // Apply service filter
        if ($request->filled('service')) {
            $query->where('service_name', $request->service);
        }
        
        // Apply plan type filter
        if ($request->filled('plan_type')) {
            $query->where('plan_type', $request->plan_type);
        }
        
        $bookings = $query->get();
        
        // Calculate summary data
        $totalTransactions = $bookings->count();
        $totalAmount = $bookings->sum('amount');
        $planTypeSummary = $bookings->groupBy('plan_type')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'amount' => $group->sum('amount')
                ];
            });
        
        // Add filter details to pass to the PDF
        $filterInfo = [
            'start_date' => $request->filled('start_date') ? Carbon::parse($request->start_date)->format('d M Y') : 'All time',
            'end_date' => $request->filled('end_date') ? Carbon::parse($request->end_date)->format('d M Y') : 'Present',
            'service' => $request->filled('service') ? $request->service : 'All services',
            'plan_type' => $request->filled('plan_type') ? ucwords(str_replace('_', ' ', $request->plan_type)) : 'All plans'
        ];
        
        // Generate PDF
        $pdf = PDF::loadView('customer.billing.transactions-pdf', [
            'bookings' => $bookings,
            'user' => $user,
            'totalTransactions' => $totalTransactions,
            'totalAmount' => $totalAmount,
            'planTypeSummary' => $planTypeSummary,
            'filterInfo' => $filterInfo,
            'generatedDate' => now()->format('d M Y H:i:s')
        ]);
        
        $pdf->setPaper('a4', 'portrait');
        
        // Generate filename with date and optional filters
        $filename = 'billing_transactions';
        if ($request->filled('plan_type')) {
            $filename .= '_' . $request->plan_type;
        }
        $filename .= '_' . now()->format('Y_m_d_His') . '.pdf';
        
        // Return download response
        return $pdf->download($filename);
    }

    /**
     * Handle payment failure for appointment bookings
     */
    public function paymentFailed(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::guard('user')->check()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Authentication failed. Please login to continue.',
                'redirect' => route('user.login')
            ], 401);
        }

        $request->validate([
            'razorpay_payment_id' => 'nullable|string',
            'razorpay_order_id' => 'nullable|string',
            'error_code' => 'nullable|string',
            'error_description' => 'nullable|string',
            'error_source' => 'nullable|string',
            'error_step' => 'nullable|string',
            'error_reason' => 'nullable|string',
            'phone' => 'nullable|string',
            'send_notifications' => 'nullable|boolean'
        ]);

        $user = Auth::guard('user')->user();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User authentication failed. Please login again.',
                'redirect' => route('user.login')
            ], 401);
        }
        $bookingData = session('booking_data');
        $gstDetails = session('booking_gst_details');

        if (!$user || !$bookingData) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized or no booking data found'], 403);
        }

        try {
            // Generate a unique reference ID for this failure
            $referenceId = 'APT-FAIL-' . time() . '-' . $user->id;

            // Log the payment failure
            $paymentFailureLog = \App\Models\PaymentFailureLog::create([
                'user_id' => $user->id,
                'professional_id' => $bookingData['professional_id'] ?? null,
                'booking_type' => 'appointment',
                'amount' => ($gstDetails['total_with_gst'] ?? $bookingData['total_amount'] ?? 0) * 100, // Store in paise
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'error_code' => $request->error_code,
                'error_description' => $request->error_description,
                'error_source' => $request->error_source,
                'error_step' => $request->error_step,
                'error_reason' => $request->error_reason,
                'phone' => $request->phone ?? $bookingData['phone'] ?? null,
                'reference_id' => $referenceId,
                'booking_data' => json_encode($bookingData)
            ]);

            $notificationsSent = false;

            // Send notifications if requested
            if ($request->send_notifications) {
                try {
                    $professional = \App\Models\Professional::find($bookingData['professional_id']);
                    $adminEmails = \App\Models\Admin::pluck('email')->filter()->toArray();

                    $paymentData = [
                        'amount' => ($gstDetails['total_with_gst'] ?? $bookingData['total_amount'] ?? 0) * 100,
                        'error_description' => $request->error_description ?? 'Payment failed',
                        'reference_id' => $referenceId,
                        'phone' => $request->phone ?? $bookingData['phone'] ?? null,
                        'booking_type' => 'appointment',
                        'service_name' => session('selected_service_name') ?? 'N/A',
                        'plan_type' => $bookingData['plan_type'] ?? 'N/A'
                    ];

                    $userDetails = [
                        'name' => $user->name,
                        'email' => $user->email
                    ];

                    // 1. Send notification to customer
                    try {
                        Mail::to($user->email)->send(new PaymentFailureMail(
                            $paymentData,
                            $userDetails,
                            'customer'
                        ));
                    } catch (\Exception $e) {
                        Log::error('Failed to send payment failure email to customer: ' . $e->getMessage());
                    }

                    // 2. Send notification to professional
                    if ($professional && $professional->email) {
                        $professional->notify(new \App\Notifications\PaymentFailureNotification(
                            $paymentData,
                            'professional',
                            $userDetails
                        ));
                        
                        // Send email to professional
                        try {
                            Mail::to($professional->email)->send(new PaymentFailureMail(
                                $paymentData,
                                $userDetails,
                                'professional'
                            ));
                        } catch (\Exception $e) {
                            Log::error('Failed to send payment failure email to professional: ' . $e->getMessage());
                        }
                    }

                    // 3. Send notification to all admins
                    if (!empty($adminEmails)) {
                        foreach ($adminEmails as $adminEmail) {
                            try {
                                $admin = \App\Models\Admin::where('email', $adminEmail)->first();
                                if ($admin) {
                                    $admin->notify(new \App\Notifications\PaymentFailureNotification(
                                        $paymentData,
                                        'admin',
                                        $userDetails
                                    ));
                                }
                                
                                // Send email to admin
                                Mail::to($adminEmail)->send(new PaymentFailureMail(
                                    $paymentData,
                                    $userDetails,
                                    'admin'
                                ));
                            } catch (\Exception $e) {
                                Log::error('Failed to send payment failure email to admin: ' . $e->getMessage());
                            }
                        }
                    }

                    $notificationsSent = true;
                    
                    Log::info('Appointment payment failure notifications sent successfully', [
                        'customer_email' => $user->email,
                        'professional_email' => $professional->email ?? 'N/A',
                        'admin_emails_count' => count($adminEmails),
                        'reference_id' => $referenceId
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error('Failed to send payment failure notifications: ' . $e->getMessage());
                }
            }

            return response()->json([
                'status' => 'failed',
                'message' => 'Payment failed. You can retry your booking.',
                'reference_id' => $referenceId,
                'notifications_sent' => $notificationsSent,
                'retry_available' => true
            ]);

        } catch (\Exception $e) {
            Log::error('Error handling appointment payment failure: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing payment failure: ' . $e->getMessage()
            ], 500);
        }
    }
}
