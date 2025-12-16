<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\ProfessionalPlanPurchase;
use App\Models\Admin;
use App\Notifications\PlanPurchaseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PlanController extends Controller
{
    /**
     * Display all available plans
     */
    public function index()
    {
        $currentPlan = ProfessionalPlanPurchase::getActivePlanForProfessional(Auth::id());
        
        // Define plan hierarchy (order determines tier level)
        $planHierarchy = ['Bronze' => 1, 'Silver' => 2, 'Gold' => 3, 'Platinum' => 4];
        
        // Get all active plans
        $allPlans = Plan::active()->orderBy('order')->get();
        
        // Filter plans based on current plan
        if ($currentPlan) {
            $currentPlanTier = $planHierarchy[$currentPlan->plan_name] ?? 0;
            
            // Only show plans with higher tier than current plan
            $plans = $allPlans->filter(function($plan) use ($planHierarchy, $currentPlanTier) {
                $planTier = $planHierarchy[$plan->name] ?? 0;
                return $planTier > $currentPlanTier;
            });
        } else {
            // Show all plans if no current plan
            $plans = $allPlans;
        }

        return view('professional.plans.index', compact('plans', 'currentPlan'));
    }

    /**
     * Show purchase confirmation page
     */
    public function purchase($id)
    {
        $plan = Plan::active()->findOrFail($id);
        $professional = Auth::user();

        return view('professional.plans.purchase', compact('plan', 'professional'));
    }

    /**
     * Process the plan purchase
     */
    public function processPurchase(Request $request, $id)
    {
        try {
            $plan = Plan::active()->findOrFail($id);
            $professional = Auth::user();

            $validator = \Validator::make($request->all(), [
                'payment_method' => 'required|in:razorpay,stripe,manual',
                'payment_screenshot' => 'required_if:payment_method,manual|nullable|image|mimes:jpeg,png,jpg|max:5120',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()
                    ], 422);
                }
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Calculate end date if validity is set
        $endDate = null;
        if ($plan->validity_days) {
            $endDate = Carbon::now()->addDays($plan->validity_days);
        }

        // Handle screenshot upload for manual payment
        $screenshotPath = null;
        if ($request->payment_method === 'manual' && $request->hasFile('payment_screenshot')) {
            $screenshotPath = $request->file('payment_screenshot')->store('payment_screenshots', 'public');
        }

        // Create purchase record
        $purchase = ProfessionalPlanPurchase::create([
            'professional_id' => $professional->id,
            'plan_id' => $plan->id,
            'plan_name' => $plan->name,
            'price' => $plan->price,
            'features' => $plan->features,
            'lead_limit' => $plan->lead_limit,
            'leads_used' => 0,
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_screenshot' => $screenshotPath,
            'start_date' => Carbon::now(),
            'end_date' => $endDate,
        ]);

        // Notify all admins about the purchase
        $admins = Admin::all();
        foreach ($admins as $admin) {
            $admin->notify(new PlanPurchaseNotification($purchase));
        }

        // Redirect to payment gateway based on method
        if ($request->payment_method === 'razorpay') {
            return $this->initiateRazorpayPayment($purchase);
        } elseif ($request->payment_method === 'stripe') {
            return $this->initiateStripePayment($purchase);
        } else {
            // Manual payment - wait for admin approval
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('professional.plans.success', $purchase->id),
                    'message' => 'Your purchase request has been submitted. Please wait for admin approval.'
                ]);
            }
            
            return redirect()->route('professional.plans.success', $purchase->id)
                ->with('info', 'Your purchase request has been submitted. Please wait for admin approval.');
        }
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while processing your purchase. Please try again.'
                ], 500);
            }
            return redirect()->back()->with('error', 'An error occurred while processing your purchase. Please try again.');
        }
    }

    /**
     * Initiate Razorpay payment
     */
    private function initiateRazorpayPayment($purchase)
    {
        try {
            // Check Razorpay credentials
            $razorpayKey = config('services.razorpay.key');
            $razorpaySecret = config('services.razorpay.secret');
            
            if (!$razorpayKey || !$razorpaySecret) {
                return redirect()->back()->with('error', 'Payment gateway configuration error. Please contact support.');
            }

            // Razorpay integration
            $api = new \Razorpay\Api\Api($razorpayKey, $razorpaySecret);

            $orderData = [
                'receipt' => 'plan_' . $purchase->id . '_' . time(),
                'amount' => $purchase->price * 100, // Amount in paise
                'currency' => 'INR',
                'notes' => [
                    'purchase_id' => $purchase->id,
                    'plan_name' => $purchase->plan_name,
                    'professional_id' => $purchase->professional_id,
                ]
            ];

            $razorpayOrder = $api->order->create($orderData);
            
            // Razorpay order created successfully (logging removed)
            
            return view('professional.plans.razorpay', [
                'purchase' => $purchase,
                'order' => $razorpayOrder,
                'razorpayKey' => $razorpayKey,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }

    /**
     * Initiate Stripe payment
     */
    private function initiateStripePayment($purchase)
    {
        // Stripe integration - to be implemented
        return redirect()->back()->with('info', 'Stripe payment coming soon!');
    }

    /**
     * Handle Razorpay payment callback
     */
    public function razorpayCallback(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), [
                'razorpay_payment_id' => 'required',
                'razorpay_order_id' => 'required',
                'razorpay_signature' => 'required',
                'purchase_id' => 'required|exists:professional_plan_purchases,id',
            ]);

            if ($validator->fails()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validation failed',
                        'errors' => $validator->errors()
                    ], 422);
                }
                return redirect()->back()->withErrors($validator);
            }

            $purchase = ProfessionalPlanPurchase::findOrFail($request->purchase_id);

            // Verify Razorpay signature
            $api = new \Razorpay\Api\Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            // Payment successful
            $purchase->update([
                'payment_status' => 'success',
                'payment_id' => $request->razorpay_payment_id,
            ]);

            // Razorpay payment verified successfully (logging removed)

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'status' => 'success',
                    'message' => 'Payment successful! Your plan is now active.',
                    'redirect' => route('professional.plans.success', $purchase->id)
                ]);
            }

            return redirect()->route('professional.plans.success', $purchase->id)
                ->with('success', 'Payment successful! Your plan is now active.');

        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            if (isset($purchase)) {
                $purchase->update(['payment_status' => 'failed']);
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment verification failed. Please contact support.'
                ], 400);
            }

            return redirect()->route('professional.plans.failed', $purchase->id ?? 0)
                ->with('error', 'Payment verification failed. Please contact support.');

        } catch (\Exception $e) {
            if (isset($purchase)) {
                $purchase->update(['payment_status' => 'failed']);
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred during payment processing. Please contact support.'
                ], 500);
            }

            return redirect()->route('professional.plans.index')
                ->with('error', 'An error occurred during payment processing. Please contact support.');
        }
    }

    /**
     * Show payment success page
     */
    public function success($id)
    {
        $purchase = ProfessionalPlanPurchase::with('plan')
            ->where('professional_id', Auth::id())
            ->findOrFail($id);

        return view('professional.plans.success', compact('purchase'));
    }

    /**
     * Show payment failed page
     */
    public function failed($id)
    {
        $purchase = ProfessionalPlanPurchase::with('plan')
            ->where('professional_id', Auth::id())
            ->findOrFail($id);

        return view('professional.plans.failed', compact('purchase'));
    }

    /**
     * Show current active plan
     */
    public function myPlan()
    {
        $purchase = ProfessionalPlanPurchase::getActivePlanForProfessional(Auth::id());

        if (!$purchase) {
            return redirect()->route('professional.plans.index')
                ->with('info', 'You do not have an active plan. Please purchase a plan.');
        }

        return view('professional.plans.my-plan', compact('purchase'));
    }
}
