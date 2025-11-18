<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BankAccountController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ManageProfessionalController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\WhychooseController;
use App\Http\Controllers\Admin\ContactBannerController;
use App\Http\Controllers\Admin\ContactDetailController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\BlogBannerController;
use App\Http\Controllers\Admin\EventDetailsController;
use App\Http\Controllers\Admin\AboutExperienceController;
use App\Http\Controllers\Admin\AboutHowWeWorkController;
use App\Http\Controllers\Admin\AboutFAQController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\ServiceDetailsController;
use App\Http\Controllers\Admin\EventFAQController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\MCQController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\AllEventController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ManageCustomerController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\ServiceMCQController;
use App\Http\Controllers\Admin\McqAnswerController;
use App\Http\Controllers\Admin\ProfessionalRequestedController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\AdminMenuController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProfessionalEventController;
use App\Http\Controllers\Admin\CategoryBoxController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\HeaderController;
use App\Http\Controllers\frontend\HomeController;

Route::get('/run-migrate-seed', function () {
    Artisan::call('migrate', ['--force' => true]);
    Artisan::call('db:seed', ['--force' => true]);
    return '✅ Migration and Seeder executed successfully!';
});

Route::middleware(['auth:admin', 'admin.menu'])->group(function () {
    Route::get('/dashboard', function () {
        $admin = Auth::guard('admin')->user();

        // Clean up notifications older than 30 days
        $thirtyDaysAgo = \Carbon\Carbon::now()->subDays(30);
        DB::table('notifications')
            ->where('notifiable_type', 'App\Models\Admin')
            ->where('notifiable_id', $admin->id)
            ->where('created_at', '<', $thirtyDaysAgo)
            ->delete();

        // Get unread notifications (after cleanup)
        $notifications = $admin->unreadNotifications;
        $rescheduleNotifications = $notifications->where('type', 'App\Notifications\AppointmentRescheduled');

        return view('admin.index', compact('rescheduleNotifications'));
    })->name('dashboard');

    Route::resource('sub-service', \App\Http\Controllers\Admin\SubServiceController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('contactbanner', ContactBannerController::class);
    Route::resource('contactdetails', ContactDetailController::class);
    Route::resource('blogposts', BlogPostController::class);
    Route::resource('blogbanners', BlogBannerController::class);
    Route::resource('eventdetails', EventDetailsController::class);
    Route::resource('aboutexperiences', AboutExperienceController::class);
    Route::resource('abouthowweworks', AboutHowWeWorkController::class);
    Route::resource('aboutfaq', AboutFAQController::class);
    Route::resource('service-details', ServiceDetailsController::class);
    Route::resource('eventfaq', EventFAQController::class);
    Route::resource('logo', LogoController::class);
    Route::resource('manage_admins', ManageAdminController::class);
    Route::resource('admin_menus', AdminMenuController::class);
    Route::resource('categorybox', CategoryBoxController::class);
    Route::get('/get-sub-services/{serviceId}', [\App\Http\Controllers\Admin\CategoryBoxController::class, 'getSubServices'])->name('get.sub.services');
    Route::resource('faq', FAQController::class);
    Route::resource('header', HeaderController::class);
    Route::resource('whychoose', WhychooseController::class);
    Route::get('/admin/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');

        Route::resource('sub-service', \App\Http\Controllers\Admin\SubServiceController::class);

    Route::get('/admin/banner', [BannerController::class, 'index'])->name('banner.index');
    // Admin permissions routes
    Route::get('manage_admins/{admin}/permissions', [ManageAdminController::class, 'showPermissions'])->name('manage_admins.permissions');
    Route::post('manage_admins/{admin}/permissions', [ManageAdminController::class, 'updatePermissions'])->name('manage_admins.update_permissions');

    // Menu sync route
    Route::post('admin_menus/sync', [AdminMenuController::class, 'syncFromSidebar'])->name('admin_menus.sync');

    Route::resource('blogs', BlogController::class);
    Route::resource('allevents', AllEventController::class);

    // All Events Approve/Reject Routes
    Route::post('allevents/{allevent}/approve', [AllEventController::class, 'approve'])->name('allevents.approve');
    Route::post('allevents/{allevent}/reject', [AllEventController::class, 'reject'])->name('allevents.reject');
    Route::post('allevents/{allevent}/meet-link', [AllEventController::class, 'updateMeetLink'])->name('allevents.update-meet-link');
    Route::post('allevents/{allevent}/toggle-homepage', [AllEventController::class, 'toggleHomepage'])->name('allevents.toggle-homepage');

    // All Events Export Routes
    Route::get('allevents-export/excel', [AllEventController::class, 'exportExcel'])->name('allevents.export.excel');
    Route::get('allevents-export/pdf', [AllEventController::class, 'exportPdf'])->name('allevents.export.pdf');

    // Professional Events Management Routes (MERGED INTO ALL EVENTS - Keeping routes for backward compatibility)
    // Route::prefix('professional-events')->name('professional-events.')->group(function () {
    //     Route::get('/', [ProfessionalEventController::class, 'index'])->name('index');
    //     Route::get('/{event}', [ProfessionalEventController::class, 'show'])->name('show');
    //     Route::get('/{event}/edit', [ProfessionalEventController::class, 'edit'])->name('edit');
    //     Route::put('/{event}', [ProfessionalEventController::class, 'update'])->name('update');
    //     Route::delete('/{event}', [ProfessionalEventController::class, 'destroy'])->name('destroy');
    //     Route::post('/{event}/approve', [ProfessionalEventController::class, 'approve'])->name('approve');
    //     Route::post('/{event}/reject', [ProfessionalEventController::class, 'reject'])->name('reject');
    //     Route::post('/{event}/meet-link', [ProfessionalEventController::class, 'updateMeetLink'])->name('update-meet-link');
    //     Route::post('/bulk-action', [ProfessionalEventController::class, 'bulkAction'])->name('bulk-action');
    // });

    Route::prefix('admin')->name('')->group(function () {
        Route::get('whychoose', [WhychooseController::class, 'index'])->name('whychoose.index');
        Route::post('whychoose', [WhychooseController::class, 'store'])->name('whychoose.store');
        Route::get('whychoose/{id}/edit', [WhychooseController::class, 'edit'])->name('whychoose.edit');
        Route::put('whychoose/{id}', [WhychooseController::class, 'update'])->name('whychoose.update');
    });

    Route::resource('testimonials', TestimonialController::class);
    Route::resource('careers', \App\Http\Controllers\Admin\CareerController::class);
    Route::resource('job-applications', \App\Http\Controllers\Admin\JobApplicationController::class)->only(['index', 'show', 'destroy']);
    Route::put('job-applications/{id}/update-status', [\App\Http\Controllers\Admin\JobApplicationController::class, 'updateStatus'])->name('job-applications.update-status');
    Route::resource('servicemcq', ServiceMCQController::class);

    Route::resource('banner', BannerController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('manage-professional', ManageProfessionalController::class);

    // Additional routes for professional management
    Route::post('manage-professional/{id}/update-commission', [ManageProfessionalController::class, 'updateCommission'])->name('manage-professional.update-commission');

    // Send email to customers or professionals
    Route::post('send-email', [ManageProfessionalController::class, 'sendEmail'])->name('send-email');
    
    // Preview email template (for testing)
    Route::get('preview-email-template', [ManageProfessionalController::class, 'previewEmailTemplate'])->name('preview-email-template');

    // Professional bank details and payment routes
    Route::get('/professional/bank-details/export', [ManageProfessionalController::class, 'exportBankDetails'])->name('professional.bank-details.export');

    // Bank Accounts Management
    Route::prefix('bank-accounts')->name('bank-accounts.')->group(function () {
        Route::get('/', [BankAccountController::class, 'index'])->name('index');
        Route::get('/{id}', [BankAccountController::class, 'show'])->name('show');
        Route::post('/{id}/verify', [BankAccountController::class, 'verify'])->name('verify');
        Route::get('/export/pdf', [BankAccountController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel', [BankAccountController::class, 'exportExcel'])->name('export.excel');
    });

    // User Management
    Route::prefix('user-management')->name('user-management.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/{id}', [UserManagementController::class, 'show'])->name('show');
        Route::delete('/{id}', [UserManagementController::class, 'destroy'])->name('destroy');
        Route::post('/{id}/force-complete', [UserManagementController::class, 'forceComplete'])->name('force-complete');
        Route::post('/{id}/send-reminder', [UserManagementController::class, 'sendReminder'])->name('send-reminder');
        Route::get('/export/pdf', [UserManagementController::class, 'exportPdf'])->name('export.pdf');
        Route::get('/export/excel', [UserManagementController::class, 'exportExcel'])->name('export.excel');
    });

    Route::resource('mcq', MCQController::class);

    // MCQ Answers routes
    Route::get('/mcq-answers', [McqAnswerController::class, 'index'])->name('mcq-answers.index');
    Route::get('/mcq-answers/export', [McqAnswerController::class, 'export'])->name('mcq-answers.export');

    Route::get('/professional-requests', [ProfessionalRequestedController::class, 'index'])->name('professional.requests');
    Route::post('/professional-requests/{id}/approve', [ProfessionalRequestedController::class, 'approve'])->name('professional.requests.approve');
    Route::get('/professional-requests/{id}/reject', [ProfessionalRequestedController::class, 'reject'])->name('professional.requests.reject');
    Route::get('/professional-requests/{id}/show', [ProfessionalRequestedController::class, 'show'])->name('professional.requests.show');

    Route::get('/get-availability-slots', [HomeController::class, 'getAvailabilitySlots'])->name('get.availability.slots');
    Route::get('/booking/onetime', [BookingController::class, 'oneTimeBooking'])->name('onetime');
    Route::get('/booking/freehand', [BookingController::class, 'freeHandBooking'])->name('freehand');
    Route::get('/booking/monthly', [BookingController::class, 'monthlyBooking'])->name('monthly');
    Route::get('/booking/quaterly', [BookingController::class, 'quaterlyBooking'])->name('quaterly');
    Route::post('/booking/add-link', [App\Http\Controllers\Admin\BookingController::class, 'addMeetingLink'])->name('add-link');


    Route::post('/professional/reject/{id}', [ProfessionalRequestedController::class, 'reject'])->name('professional.requests.reject');

    Route::get('booking/details/{id}', [BookingController::class, 'show'])->name('booking.details');

    Route::resource('manage-customer', ManageCustomerController::class);
    Route::get('manage-customer-export/excel', [ManageCustomerController::class, 'exportExcel'])->name('manage-customer.export.excel');
    Route::get('manage-customer-export/pdf', [ManageCustomerController::class, 'exportPdf'])->name('manage-customer.export.pdf');
    Route::get('manage-customer-export/test-excel', [ManageCustomerController::class, 'testExcelExport'])->name('manage-customer.test-excel');
    Route::post('manage-customer/{id}/reset-onboarding', [ManageCustomerController::class, 'resetOnboarding'])->name('manage-customer.reset-onboarding');
    Route::resource('eventpage', EventController::class);
    Route::post('booking/{id}/add-remarks', [BookingController::class, 'addRemarks'])->name('add-remarks');
    Route::post('booking/{id}/update-gmeet-link', [EventController::class, 'updateGmeetLink'])->name('event.updateGmeetLink');
    Route::post('/professional/{id}/margin', [ManageProfessionalController::class, 'updateMargin'])->name('updateMargin');

    Route::post('bookings/{id}/add-remarks', [BookingController::class, 'addProfessionalRemarks'])->name('professional-add-remarks');

    Route::get('professional-billing', [App\Http\Controllers\Admin\BillingController::class, 'professionalBilling'])->name('professional.billing');
    Route::get('customer-billing', [App\Http\Controllers\Admin\CustomerBillingController::class, 'index'])->name('customer.billing');
    Route::get('customer/billing/export', [BillingController::class, 'exportCustomerBillingToPdf'])->name('customer.billing.export');
    Route::get('customer/billing/export-excel', [BillingController::class, 'exportCustomerBillingToExcel'])->name('customer.billing.export.excel');

    Route::post('/admin/professionals/toggle-status', [ManageProfessionalController::class, 'toggleStatus'])->name('professional.toggle-status');
    Route::get('professional/billing/export', [BillingController::class, 'exportBillingToPdf'])->name('professional.billing.export');
    Route::get('billing/professional/export-excel', [App\Http\Controllers\Admin\BillingController::class, 'exportBillingToExcel'])
        ->name('professional.billing.export.excel');

    // Admin invoice routes
    Route::get('customer/invoice/{id}', [BillingController::class, 'viewCustomerInvoice'])->name('customer.invoice.view');
    Route::get('customer/invoice/{id}/download', [BillingController::class, 'downloadCustomerInvoice'])->name('customer.invoice.download');
    Route::get('professional/invoice/{id}', [BillingController::class, 'viewProfessionalInvoice'])->name('professional.invoice.view');
    Route::get('professional/invoice/{id}/excel', [BillingController::class, 'downloadProfessionalInvoiceExcel'])->name('professional.invoice.excel');
    Route::get('customer/invoice/{id}/excel', [BillingController::class, 'downloadCustomerInvoiceExcel'])->name('customer.invoice.excel');
    Route::get('professional/invoice/{id}/download', [BillingController::class, 'downloadProfessionalInvoice'])->name('professional.invoice.download');;


    Route::get('event/export', [App\Http\Controllers\Admin\EventController::class, 'export'])
        ->name('event.export');
    
    // Admin Reviews Management Routes
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
        Route::post('/{review}/approve', [ReviewController::class, 'approve'])->name('approve');
        Route::post('/{review}/reject', [ReviewController::class, 'reject'])->name('reject');
        Route::get('/export-pdf', [ReviewController::class, 'exportReviewsToPdf'])->name('export-pdf');
        Route::get('/export-excel', [ReviewController::class, 'exportReviewsToExcel'])->name('export-excel');
    });
    
    Route::get('reviews/export', [App\Http\Controllers\Admin\ReviewController::class, 'export'])
        ->name('reviews.export');

    // Add these alias routes for backwards compatibility
    Route::get('booking/monthly/export', [App\Http\Controllers\Admin\BookingController::class, 'exportMonthlyBookingsToPdf'])
        ->name('booking.monthly.export');

    Route::get('booking/quarterly/export', [App\Http\Controllers\Admin\BookingController::class, 'exportQuarterlyBookingsToPdf'])
        ->name('booking.quarterly.export');

    Route::get('booking/freehand/export', [App\Http\Controllers\Admin\BookingController::class, 'exportFreeHandBookingsToPdf'])
        ->name('booking.freehand.export');

    Route::get('booking/onetime/export', [App\Http\Controllers\Admin\BookingController::class, 'exportOneTimeBookingsToPdf'])
        ->name('booking.onetime.export');

    // Also add these routes for Excel exports if needed with the  prefix
    Route::get('booking/monthly/export-excel', [App\Http\Controllers\Admin\BookingController::class, 'exportMonthlyToExcel'])
        ->name('booking.monthly.export-excel');

    Route::get('booking/quarterly/export-excel', [App\Http\Controllers\Admin\BookingController::class, 'exportQuarterlyToExcel'])
        ->name('booking.quarterly.export-excel');

    Route::get('booking/freehand/export-excel', [App\Http\Controllers\Admin\BookingController::class, 'exportFreeHandToExcel'])
        ->name('booking.freehand.export-excel');

    Route::get('booking/onetime/export-excel', [App\Http\Controllers\Admin\BookingController::class, 'exportOnetimeToExcel'])
        ->name('booking.onetime.export-excel');

    // Report routes
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('booking-summary', [ReportController::class, 'bookingSummaryReport'])
            ->name('booking-summary');
        Route::get('booking-summary/excel', [ReportController::class, 'exportBookingSummaryExcel'])
            ->name('booking-summary.excel');
        Route::get('booking-summary/pdf', [ReportController::class, 'exportBookingSummaryPdf'])
            ->name('booking-summary.pdf');
        Route::get('professionals', [ReportController::class, 'getProfessionals'])
            ->name('professionals');
    });

    // Notification routes
    Route::post('/notifications/{notification}/mark-as-read', function ($notificationId) {
        $admin = Auth::guard('admin')->user();

        // Use DB query to find and update notification
        $updated = DB::table('notifications')
            ->where('id', $notificationId)
            ->where('notifiable_type', 'App\Models\Admin')
            ->where('notifiable_id', $admin->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        if ($updated) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    })->name('notifications.mark-as-read');

    Route::post('/notifications/mark-all-as-read', function () {
        $admin = Auth::guard('admin')->user();

        // Mark all unread notifications as read
        $updated = DB::table('notifications')
            ->where('notifiable_type', 'App\Models\Admin')
            ->where('notifiable_id', $admin->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return response()->json(['success' => true, 'updated' => $updated]);
    })->name('notifications.mark-all-as-read');

    // Admin routes for managing professional services, rates, and availability
    Route::get('/professional/{professional}/services', [ManageProfessionalController::class, 'manageServices'])->name('professional.services');
    Route::get('/professional/{professional}/rates', [ManageProfessionalController::class, 'manageRates'])->name('professional.rates');
    Route::get('/professional/{professional}/availability', [ManageProfessionalController::class, 'manageAvailability'])->name('professional.availability');

    // Admin CRUD routes for professional services
    Route::post('/professional/{professional}/services', [ManageProfessionalController::class, 'storeService'])->name('professional.services.store');
    Route::put('/professional/{professional}/services/{service}', [ManageProfessionalController::class, 'updateService'])->name('professional.services.update');
    Route::delete('/professional/{professional}/services/{service}', [ManageProfessionalController::class, 'deleteService'])->name('professional.services.delete');

    // Admin CRUD routes for professional rates
    Route::post('/professional/{professional}/rates', [ManageProfessionalController::class, 'storeRate'])->name('professional.rates.store');
    Route::put('/professional/{professional}/rates/{rate}', [ManageProfessionalController::class, 'updateRate'])->name('professional.rates.update');
    Route::delete('/professional/{professional}/rates/{rate}', [ManageProfessionalController::class, 'deleteRate'])->name('professional.rates.delete');

    // Admin CRUD routes for professional availability
    Route::post('/professional/{professional}/availability', [ManageProfessionalController::class, 'storeAvailability'])->name('professional.availability.store');
    Route::put('/professional/{professional}/availability/{availability}', [ManageProfessionalController::class, 'updateAvailability'])->name('professional.availability.update');
    Route::delete('/professional/{professional}/availability/{availability}', [ManageProfessionalController::class, 'deleteAvailability'])->name('professional.availability.delete');

    // Admin Booking Routes
    Route::prefix('admin-booking')->name('admin-booking.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminBookingController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\AdminBookingController::class, 'create'])->name('create');
        Route::post('/select-customer', [App\Http\Controllers\Admin\AdminBookingController::class, 'selectCustomer'])->name('select-customer');
        Route::get('/select-service', [App\Http\Controllers\Admin\AdminBookingController::class, 'selectService'])->name('select-service');
        Route::get('/get-sub-services', [App\Http\Controllers\Admin\AdminBookingController::class, 'getSubServices'])->name('get-sub-services');
        Route::post('/store-service-selection', [App\Http\Controllers\Admin\AdminBookingController::class, 'storeServiceSelection'])->name('store-service-selection');
        Route::get('/select-professional', [App\Http\Controllers\Admin\AdminBookingController::class, 'selectProfessional'])->name('select-professional');
        Route::post('/store-professional-selection', [App\Http\Controllers\Admin\AdminBookingController::class, 'storeProfessionalSelection'])->name('store-professional-selection');
        Route::get('/select-session', [App\Http\Controllers\Admin\AdminBookingController::class, 'selectSession'])->name('select-session');
        Route::post('/store-session-selection', [App\Http\Controllers\Admin\AdminBookingController::class, 'storeSessionSelection'])->name('store-session-selection');
        Route::get('/select-datetime', [App\Http\Controllers\Admin\AdminBookingController::class, 'selectDateTime'])->name('select-datetime');
        Route::get('/get-available-slots', [App\Http\Controllers\Admin\AdminBookingController::class, 'getAvailableSlots'])->name('get-available-slots');
        Route::post('/store-datetime-selection', [App\Http\Controllers\Admin\AdminBookingController::class, 'storeDateTimeSelection'])->name('store-datetime-selection');
        Route::get('/confirm', [App\Http\Controllers\Admin\AdminBookingController::class, 'confirm'])->name('confirm');
        Route::post('/process-booking', [App\Http\Controllers\Admin\AdminBookingController::class, 'processBooking'])->name('process-booking');
        Route::post('/initiate-payment', [App\Http\Controllers\Admin\AdminBookingController::class, 'initiatePayment'])->name('initiate-payment');
        Route::post('/verify-payment', [App\Http\Controllers\Admin\AdminBookingController::class, 'verifyPayment'])->name('verify-payment');
        Route::get('/{id}/details', [App\Http\Controllers\Admin\AdminBookingController::class, 'getBookingDetails'])->name('details');
        Route::post('/{id}/mark-paid', [App\Http\Controllers\Admin\AdminBookingController::class, 'markAsPaid'])->name('mark-paid');
    });
        Route::get('/debug-payment', function () {
            return response()->json([
                'route_exists' => true,
                'session_data' => [
                    'customer_id' => session('admin_booking_customer_id'),
                    'professional_id' => session('admin_booking_professional_id'),
                    'session_id' => session('admin_booking_session_id'),
                    'service_id' => session('admin_booking_service_id'),
                    'datetime_selections' => session('admin_booking_datetime_selections')
                ],
                'all_session_keys' => array_keys(session()->all())
            ]);
        })->name('debug-payment');

        // Add test verification endpoint to debug payment flow
        Route::post('/test-verify-payment', function (Request $request) {
            Log::info('TEST VERIFY ENDPOINT CALLED', [
                'request_data' => $request->all(),
                'headers' => $request->headers->all(),
                'session_id' => session()->getId(),
                'timestamp' => now()->format('Y-m-d H:i:s')
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Test verification endpoint reached successfully',
                'request_data' => $request->all(),
                'session_id' => session()->getId(),
                'booking_id' => 12345,
                'redirect' => route('admin.admin-booking.index') . '?test_booking=12345'
            ]);
        })->name('test-verify-payment');
        Route::get('/success/{booking}', [App\Http\Controllers\Admin\AdminBookingController::class, 'success'])->name('success');
        Route::get('/search-customers', [App\Http\Controllers\Admin\AdminBookingController::class, 'searchCustomers'])->name('search-customers');
        Route::get('/search-professionals', [App\Http\Controllers\Admin\AdminBookingController::class, 'searchProfessionals'])->name('search-professionals');

        // OTP Routes for new customer creation
        Route::post('/send-otp', [App\Http\Controllers\Admin\AdminBookingController::class, 'sendOtp'])->name('send-otp');
        Route::post('/verify-otp', [App\Http\Controllers\Admin\AdminBookingController::class, 'verifyOtp'])->name('verify-otp');
        Route::post('/set-password', [App\Http\Controllers\Admin\AdminBookingController::class, 'setPassword'])->name('set-password');
    });

    // Additional Services Management Routes
    Route::prefix('additional-services')->name('additional-services.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'index'])->name('index');
        Route::get('/statistics/data', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'getStatistics'])->name('statistics');
        Route::get('/{id}', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'reject'])->name('reject');
        Route::post('/{id}/modify-price', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'modifyPrice'])->name('modify-price');
        Route::post('/{id}/respond-negotiation', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'respondToNegotiation'])->name('respond-negotiation');
        Route::post('/{id}/update-delivery-date', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'updateDeliveryDate'])->name('update-delivery-date');
        Route::post('/{id}/release-payment', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'releasePayment'])->name('release-payment');
        Route::post('/{id}/mark-completed', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'markAsCompleted'])->name('mark-completed');
        // Admin price editing with history
        Route::post('/{id}/update-service-price', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'updateServicePrice'])->name('update-service-price');
        Route::get('/{id}/price-history', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'getPriceHistory'])->name('price-history');
        
        // Invoice Generation Routes
        Route::get('/{id}/invoice', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'generateInvoice'])->name('invoice');
        Route::get('/{id}/invoice/pdf', [App\Http\Controllers\Admin\AdditionalServiceController::class, 'generatePdfInvoice'])->name('invoice.pdf');
    });

    // Chat Management - Admin to Professional Communication
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::post('/get-or-create', [App\Http\Controllers\Admin\ChatController::class, 'getOrCreateChat'])->name('get-or-create');
        Route::post('/send-message', [App\Http\Controllers\Admin\ChatController::class, 'sendMessage'])->name('send-message');
        Route::get('/messages', [App\Http\Controllers\Admin\ChatController::class, 'getMessages'])->name('messages');
        Route::get('/summary', [App\Http\Controllers\Admin\ChatController::class, 'getChatSummary'])->name('summary');
        Route::get('/attachment/{id}/download', [App\Http\Controllers\Admin\ChatController::class, 'downloadAttachment'])->name('attachment.download');
    });

    // Chat Management - Admin to Customer Communication
    Route::prefix('customer-chat')->name('customer-chat.')->group(function () {
        Route::post('/get-or-create', [App\Http\Controllers\Admin\CustomerChatController::class, 'getOrCreateChat'])->name('get-or-create');
        Route::post('/send-message', [App\Http\Controllers\Admin\CustomerChatController::class, 'sendMessage'])->name('send-message');
        Route::get('/messages/{chatId}', [App\Http\Controllers\Admin\CustomerChatController::class, 'getMessages'])->name('messages');
        Route::get('/chats', [App\Http\Controllers\Admin\CustomerChatController::class, 'getChats'])->name('chats');
        Route::post('/mark-as-read/{chatId}', [App\Http\Controllers\Admin\CustomerChatController::class, 'markAsRead'])->name('mark-as-read');
        Route::get('/attachment/{id}/download', [App\Http\Controllers\Admin\CustomerChatController::class, 'downloadAttachment'])->name('attachment.download');
    });
