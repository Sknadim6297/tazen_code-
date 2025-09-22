<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\EventBooking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventBookingSummaryMail;
use App\Mail\PaymentFailureMail;
use Razorpay\Api\Api;
use App\Models\PaymentFailureLog;
use App\Notifications\PaymentFailureNotification;
use Carbon\Carbon;

class BookingController extends Controller
{

    public function checkLogin(Request $request)
    {
        // First check if user is logged in
        if (!Auth::guard('user')->check()) {
            return response()->json([
                'logged_in' => false,
                'message' => 'Please login to continue.'
            ], 401);
        }

        // If this is just a login check (no booking data), return success
        if ($request->has('check') && $request->input('check') === true) {
            return response()->json([
                'logged_in' => true,
                'message' => 'User is logged in.'
            ]);
        }

        // If we have booking data, process it
        try {
            $eventId = $request->input('event_id');
            $eventName = $request->input('event_name', '');
            // Check if the event ID exists in all_events table
            $allEvent = \App\Models\AllEvent::find($eventId);

            // If not found by ID and we have a name, try to find by heading only
            // since 'name' column doesn't exist in all_events table
            if (!$allEvent && !empty($eventName)) {
                $allEvent = \App\Models\AllEvent::where('heading', 'LIKE', "%{$eventName}%")
                    ->first(); // Remove the query for 'name' column

                if ($allEvent) {
                    $eventId = $allEvent->id;
                }
            }

            // If still not found, check if it exists in the events table
            if (!$allEvent && $eventId) {
                $regularEvent = \App\Models\Event::find($eventId);

                if ($regularEvent) {
                    // Create a new entry in all_events table
                    $allEvent = new \App\Models\AllEvent();
                    $allEvent->heading = $regularEvent->name ?? $eventName ?? 'Event'; // Use heading instead of name
                    $allEvent->city = $regularEvent->city ?? $request->input('location') ?? 'Kolkata';
                    $allEvent->status = 'active';
                    $allEvent->save();
                    $eventId = $allEvent->id;
                }
            }

            // Store booking data in session with the correct event_id
            session([
                'event_booking_data' => [
                    'event_id' => $allEvent ? $allEvent->id : null,
                    'event_name' => $allEvent ? $allEvent->heading : $eventName, // Use heading since name doesn't exist
                    'location' => $request->input('location') ?? 'Kolkata',
                    'type' => $request->input('type') ?? 'offline',
                    'event_date' => $request->input('event_date'),
                    'price' => $request->input('amount'),
                    'total_price' => $request->input('total_price'),
                    'phone' => $request->input('phone'),
                    'persons' => $request->input('persons'),
                    'additional_info' => $request->input('additional_info')
                ]
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Booking data saved successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }



    public function bookingSummary()
    {
        $bookingData = session('event_booking_data');

        if (!$bookingData) {
            return redirect()->route('home')->with('error', 'No booking information found.');
        }

        // Try to find the event details
        $event = null;
        if (!empty($bookingData['event_id'])) {
            $event = \App\Models\AllEvent::find($bookingData['event_id']);
        }

        // Get the authenticated user
        $user = Auth::guard('user')->user();

        return view('customer.booking.summary', compact('bookingData', 'event', 'user'));
    }
    public function initPayment()
    {
        $booking = session('event_booking_data');
        $user = Auth::guard('user')->user();

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $amount = ($booking['total_price'] ?? 500) * 100;

        $order = $api->order->create([
            'receipt' => uniqid(),
            'amount' => $amount,
            'currency' => 'INR',
        ]);

        return response()->json([
            'key' => env('RAZORPAY_KEY'),
            'order_id' => $order->id,
            'amount' => $amount,
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $user = Auth::guard('user')->user();
        $bookingData = session('event_booking_data');

        if (!$user || !$bookingData) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized or no booking data found'], 403);
        }

        try {
            // Verify Razorpay signature
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];
            
            try {
                $api->utility->verifyPaymentSignature($attributes);
            } catch (\Exception $e) {
                Log::error('Payment signature verification failed', [
                    'error' => $e->getMessage(),
                    'payment_id' => $request->razorpay_payment_id,
                    'order_id' => $request->razorpay_order_id,
                    'user_id' => $user->id
                ]);
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Payment verification failed. Please contact support if amount was deducted.'
                ], 400);
            }

            // Verify the event exists in all_events table
            $eventId = $bookingData['event_id'] ?? null;
            $event = null;

            if ($eventId) {
                $event = \App\Models\AllEvent::find($eventId);

                // If not found and we have an event name, try to find by heading only
                if (!$event && !empty($bookingData['event_name'])) {
                    $event = \App\Models\AllEvent::where('heading', 'LIKE', "%{$bookingData['event_name']}%")
                        ->first();
                }
            }

            // Create booking record - with null event_id if necessary
            $booking = new \App\Models\EventBooking();
            $booking->user_id = $user->id;
            $booking->event_id = $event ? $event->id : null;
            $booking->event_name = $bookingData['event_name'] ?? '';
            
            // Fix date format - convert from dd-mm-yyyy to yyyy-mm-dd
            $eventDate = $bookingData['event_date'] ?? now()->format('Y-m-d');
            $originalDate = $eventDate;
            
            Log::info('Date conversion process started', [
                'original_date' => $originalDate,
                'user_id' => $user->id
            ]);
            
            if ($eventDate && preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $eventDate, $matches)) {
                // Convert dd-mm-yyyy to yyyy-mm-dd
                $eventDate = $matches[3] . '-' . $matches[2] . '-' . $matches[1];
                Log::info('Date converted using regex', [
                    'original' => $originalDate,
                    'converted' => $eventDate,
                    'user_id' => $user->id
                ]);
            } elseif ($eventDate && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $eventDate)) {
                // If it's not in proper format, try to parse and convert
                try {
                    $eventDate = \Carbon\Carbon::createFromFormat('d-m-Y', $eventDate)->format('Y-m-d');
                    Log::info('Date converted using Carbon', [
                        'original' => $originalDate,
                        'converted' => $eventDate,
                        'user_id' => $user->id
                    ]);
                } catch (\Exception $e) {
                    // Fallback to current date if parsing fails
                    $eventDate = now()->format('Y-m-d');
                    Log::warning('Invalid event date format, using current date', [
                        'original_date' => $originalDate,
                        'error' => $e->getMessage(),
                        'user_id' => $user->id
                    ]);
                }
            } else {
                Log::info('Date already in correct format', [
                    'date' => $eventDate,
                    'user_id' => $user->id
                ]);
            }
            
            $booking->event_date = $eventDate;
            $booking->location = $bookingData['location'] ?? '';
            $booking->type = $bookingData['type'] ?? '';
            $booking->persons = $bookingData['persons'] ?? 1;
            $booking->phone = $bookingData['phone'] ?? '';
            $booking->price = $bookingData['price'] ?? 0;
            $booking->total_price = $bookingData['total_price'] ?? 0;
            $booking->payment_status = 'success';
            $booking->order_id = $request->razorpay_order_id;
            $booking->razorpay_payment_id = $request->razorpay_payment_id;
            $booking->razorpay_signature = $request->razorpay_signature;
            
            Log::info('About to save booking with converted date', [
                'converted_event_date' => $eventDate,
                'original_date_from_session' => $bookingData['event_date'] ?? null,
                'booking_event_date_property' => $booking->event_date,
                'user_id' => $user->id
            ]);
            
            if (!$booking->save()) {
                Log::error('Failed to save event booking', [
                    'user_id' => $user->id,
                    'booking_data' => $bookingData,
                    'payment_id' => $request->razorpay_payment_id
                ]);
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Failed to save booking. Please contact support.'
                ], 500);
            }

            Log::info('Event booking created successfully', [
                'booking_id' => $booking->id,
                'user_id' => $user->id,
                'payment_id' => $request->razorpay_payment_id,
                'amount' => $booking->total_price
            ]);

            // Send event booking summary emails to all parties
            try {
                $bookingDetails = [
                    'booking_id' => $booking->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'event_name' => $booking->event_name,
                    'event_date' => $booking->event_date,
                    'location' => $booking->location,
                    'type' => $booking->type,
                    'persons' => $booking->persons,
                    'phone' => $booking->phone,
                    'total_price' => $booking->total_price,
                    'payment_id' => $booking->razorpay_payment_id,
                    'created_at' => $booking->created_at
                ];
                
                // 1. Send email to customer
                \Illuminate\Support\Facades\Mail::to($user->email)
                    ->send(new \App\Mail\EventBookingSummaryMail($bookingDetails, $event, 'customer'));
                
                // 2. Send email to admin
                $adminEmails = \App\Models\Admin::pluck('email')->filter()->toArray();
                if (!empty($adminEmails)) {
                    foreach ($adminEmails as $adminEmail) {
                        \Illuminate\Support\Facades\Mail::to($adminEmail)
                            ->send(new \App\Mail\EventBookingSummaryMail($bookingDetails, $event, 'admin'));
                    }
                }
                
                Log::info('Event booking confirmation emails sent successfully', [
                    'booking_id' => $booking->id,
                    'customer_email' => $user->email,
                    'admin_emails_count' => count($adminEmails)
                ]);
                
            } catch (\Exception $e) {
                // Log email sending failure but continue with the process
                \Illuminate\Support\Facades\Log::error('Failed to send event booking summary emails: ' . $e->getMessage(), [
                    'booking_id' => $booking->id,
                    'error_details' => $e->getTraceAsString()
                ]);
            }
            
            // Clear session data
            session()->forget('event_booking_data');

            return response()->json([
                'status' => 'success', 
                'message' => 'Booking confirmed successfully!',
                'booking_id' => $booking->id
            ]);
        } catch (\Exception $e) {
            Log::error('Payment verification error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payment_id' => $request->razorpay_payment_id ?? null,
                'order_id' => $request->razorpay_order_id ?? null,
                'user_id' => $user->id ?? null
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Payment verification failed. Please contact support if amount was deducted.',
                'error_details' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }
    public function paymentFailed(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'nullable|string',
            'razorpay_order_id' => 'nullable|string',
            'error_code' => 'nullable|string',
            'error_description' => 'nullable|string',
            'error_source' => 'nullable|string',
            'error_step' => 'nullable|string',
            'error_reason' => 'nullable|string',
            'send_notifications' => 'nullable|boolean'
        ]);

        $user = Auth::guard('user')->user();
        $bookingData = session('event_booking_data');

        if (!$user || !$bookingData) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized or no booking data found'], 403);
        }

        try {
            // Generate a unique reference ID for this failure
            $referenceId = 'EVT-FAIL-' . time() . '-' . $user->id;

            // Log the payment failure
            $paymentFailureLog = \App\Models\PaymentFailureLog::create([
                'user_id' => $user->id,
                'professional_id' => null, // Events don't have professionals
                'booking_type' => 'event',
                'amount' => ($bookingData['total_price'] ?? 0) * 100, // Store in paise
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id' => $request->razorpay_order_id,
                'error_code' => $request->error_code,
                'error_description' => $request->error_description,
                'error_source' => $request->error_source,
                'error_step' => $request->error_step,
                'error_reason' => $request->error_reason,
                'phone' => $bookingData['phone'] ?? null,
                'reference_id' => $referenceId,
                'booking_data' => json_encode($bookingData)
            ]);

            // Create failed booking record for retry functionality
            $booking = new EventBooking();
            $booking->user_id = $user->id;
            $booking->event_id = $bookingData['event_id'];
            $booking->event_name = $bookingData['event_name'] ?? '';
            $booking->event_date = $bookingData['event_date'];
            $booking->location = $bookingData['location'] ?? null;
            $booking->type = $bookingData['type'] ?? null;
            $booking->persons = $bookingData['persons'] ?? null;
            $booking->phone = $bookingData['phone'] ?? null;
            $booking->price = $bookingData['price'] ?? null;
            $booking->total_price = $bookingData['total_price'] ?? 0;
            $booking->payment_status = 'failed';
            $booking->order_id = $request->razorpay_order_id ?? null;
            $booking->razorpay_payment_id = $request->razorpay_payment_id ?? null;
            $booking->payment_failure_reason = $request->error_description ?? 'Unknown error';
            $booking->save();

            $notificationsSent = false;

            // Send notifications if requested
            if ($request->send_notifications) {
                try {
                    $adminEmails = \App\Models\Admin::pluck('email')->filter()->toArray();

                    $paymentData = [
                        'amount' => ($bookingData['total_price'] ?? 0) * 100,
                        'error_description' => $request->error_description ?? 'Payment failed',
                        'reference_id' => $referenceId,
                        'phone' => $bookingData['phone'] ?? null,
                        'booking_type' => 'event',
                        'event_name' => $bookingData['event_name'] ?? 'N/A',
                        'event_date' => $bookingData['event_date'] ?? 'N/A',
                        'location' => $bookingData['location'] ?? 'N/A'
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
                        Log::error('Failed to send payment failure email to customer for event: ' . $e->getMessage());
                    }

                    // 2. Send notification to all admins
                    if (!empty($adminEmails)) {
                        foreach ($adminEmails as $adminEmail) {
                            try {
                                // Send notification
                                $admin = \App\Models\Admin::where('email', $adminEmail)->first();
                                if ($admin) {
                                    $admin->notify(new \App\Notifications\PaymentFailureNotification(
                                        $paymentData,
                                        'admin',
                                        $userDetails
                                    ));
                                }
                                
                                // Send email
                                Mail::to($adminEmail)->send(new PaymentFailureMail(
                                    $paymentData,
                                    $userDetails,
                                    'admin'
                                ));
                            } catch (\Exception $e) {
                                Log::error('Failed to send payment failure email to admin for event: ' . $e->getMessage());
                            }
                        }
                    }

                    $notificationsSent = true;
                    
                    Log::info('Event payment failure notifications sent successfully', [
                        'booking_id' => $booking->id,
                        'customer_email' => $user->email,
                        'admin_emails_count' => count($adminEmails),
                        'reference_id' => $referenceId
                    ]);
                    
                } catch (\Exception $e) {
                    Log::error('Failed to send event payment failure notifications: ' . $e->getMessage());
                }
            }

            // Store failed booking data for retry (don't clear session immediately)
            session([
                'failed_booking_data' => $bookingData,
                'failed_booking_id' => $booking->id
            ]);

            return response()->json([
                'status' => 'failed',
                'message' => 'Payment failed. You can retry your booking.',
                'booking_id' => $booking->id,
                'reference_id' => $referenceId,
                'notifications_sent' => $notificationsSent,
                'retry_url' => route('user.booking.retry', ['booking_id' => $booking->id])
            ]);
        } catch (\Exception $e) {
            Log::error('Error handling event payment failure: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while processing failed payment: ' . $e->getMessage()
            ], 500);
        }
    }

    public function retryBooking($bookingId)
    {
        $user = Auth::guard('user')->user();
        $failedBookingData = session('failed_booking_data');
        $failedBookingId = session('failed_booking_id');

        if (!$user || !$failedBookingData || $failedBookingId != $bookingId) {
            return redirect()->route('home')->with('error', 'No failed booking found to retry.');
        }

        // Restore the booking data to session for retry
        session([
            'event_booking_data' => $failedBookingData
        ]);

        // Clear failed booking data
        session()->forget(['failed_booking_data', 'failed_booking_id']);

        return redirect()->route('user.booking.summary')->with('success', 'Your booking has been restored. You can now retry your payment.');
    }

    public function successPage()
    {
        $user = Auth::guard('user')->user();
        $mcqQuestions = collect();
        $serviceId = null;
        $bookingId = null;

        // Check if we have MCQ questions to show
        if (session('booking_success.service_id')) {
            $serviceId = session('booking_success.service_id');
            $bookingId = session('booking_success.booking_id');
            
            // Get MCQ questions for this service
            $mcqQuestions = \App\Models\ServiceMCQ::getQuestionsForService($serviceId);
        }

        return view('customer.booking.success', compact('mcqQuestions', 'serviceId', 'bookingId'));
    }

    public function bookingSuccessPage()
    {
        $user = Auth::guard('user')->user();
        $mcqQuestions = collect();
        $serviceId = null;
        $bookingId = null;

        // Check if we have MCQ questions to show
        if (session('booking_success.service_id')) {
            $serviceId = session('booking_success.service_id');
            $bookingId = session('booking_success.booking_id');
            
            // Get MCQ questions for this service
            $mcqQuestions = \App\Models\ServiceMCQ::getQuestionsForService($serviceId);
        }

        return view('customer.booking.success', compact('mcqQuestions', 'serviceId', 'bookingId'));
    }

    /**
     * Store MCQ answers from the user after successful booking
     */
    public function storeMCQAnswers(Request $request)
    {
        $user = Auth::guard('user')->user();
        
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'booking_id' => 'nullable|integer',
            'answers' => 'required|array',
            'answers.*.mcq_id' => 'required|integer|exists:service_m_c_q_s,id',
            'answers.*.question' => 'required|string',
            'answers.*.selected_answer' => 'required|string',
            'answers.*.other_answer' => 'nullable|string'
        ]);

        try {
            foreach ($request->answers as $answer) {
                \App\Models\UserMCQAnswer::create([
                    'user_id' => $user->id,
                    'service_id' => $request->service_id,
                    'service_mcq_id' => $answer['mcq_id'],
                    'booking_id' => $request->booking_id,
                    'question' => $answer['question'],
                    'selected_answer' => $answer['selected_answer'],
                    'other_answer' => $answer['other_answer'] ?? null
                ]);
            }

            // Clear the MCQ session data
            session()->forget(['booking_success.service_id', 'booking_success.booking_id']);

            return response()->json([
                'status' => 'success',
                'message' => 'Thank you for completing the questionnaire! Your answers have been saved.'
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to save MCQ answers: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'service_id' => $request->service_id,
                'error' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to save your answers. Please try again.'
            ], 500);
        }
    }

    public function resetBooking()
    {
        // Store previous URL before clearing session
        $previousUrl = url()->previous();

        // Extract service_id and professional_id from session if they exist
        $serviceId = session()->has('booking_data') ? session('booking_data.service_id') : null;
        $professionalId = session()->has('booking_data') ? session('booking_data.professional_id') : null;

        session()->forget('booking_data');

        session()->flash('success', 'Your booking has been reset. You can start fresh now.');

        // Check if the previous URL was a professional details page
        if (preg_match('/professionals\/details\/(\d+)/', $previousUrl, $matches)) {
            $professionalId = $matches[1];
            
            // Get professional name for SEO-friendly URL
            $professional = \App\Models\Profile::where('professional_id', $professionalId)->first();
            $professionalName = $professional ? $professional->name : 'Professional';
            $seoFriendlyName = \Illuminate\Support\Str::slug($professionalName);
            
            // Use the correct route name for professional details
            return redirect()->route('user.professionals.details', ['id' => $professionalId]);
        }

        // If we have a professional ID in the session, redirect to that professional's page
        if ($professionalId) {
            // Get professional name for SEO-friendly URL
            $professional = \App\Models\Profile::where('professional_id', $professionalId)->first();
            $professionalName = $professional ? $professional->name : 'Professional';
            $seoFriendlyName = \Illuminate\Support\Str::slug($professionalName);
            
            return redirect()->route('professionals.details', ['id' => $professionalId, 'professional_name' => $seoFriendlyName]);
        }
    }

    /**
     * Test method to set MCQ session data for testing
     */
    public function setMCQTestSession(Request $request)
    {
        $serviceId = $request->input('service_id', 1);
        $bookingId = $request->input('booking_id', 1);
        
        // Set session data that would normally be set after successful payment
        session([
            'booking_success.service_id' => $serviceId,
            'booking_success.booking_id' => $bookingId,
            'booking_success.service_name' => 'Test Service'
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'MCQ session data set successfully'
        ]);
    }

    /**
     * Test page to simulate MCQ functionality
     */
    public function mcqTestPage()
    {
        return view('test.mcq-test');
    }
}
