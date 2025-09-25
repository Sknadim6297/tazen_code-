<?php

use App\Http\Controllers\Admin\BannerController;
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
use App\Http\Controllers\frontend\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

    // Admin permissions routes
    Route::get('manage_admins/{admin}/permissions', [ManageAdminController::class, 'showPermissions'])->name('manage_admins.permissions');
    Route::post('manage_admins/{admin}/permissions', [ManageAdminController::class, 'updatePermissions'])->name('manage_admins.update_permissions');

    // Menu sync route
    Route::post('admin_menus/sync', [AdminMenuController::class, 'syncFromSidebar'])->name('admin_menus.sync');

    Route::resource('blogs', BlogController::class);
    Route::resource('allevents', AllEventController::class);

    Route::get('/admin/banner', [BannerController::class, 'index'])->name('banner.index');

    Route::prefix('admin')->name('')->group(function () {
        Route::get('whychoose', [WhychooseController::class, 'index'])->name('whychoose.index');
        Route::post('whychoose', [WhychooseController::class, 'store'])->name('whychoose.store');
        Route::get('whychoose/{id}/edit', [WhychooseController::class, 'edit'])->name('whychoose.edit');
        Route::put('whychoose/{id}', [WhychooseController::class, 'update'])->name('whychoose.update');
    });

    Route::resource('whychoose', WhychooseController::class);

    Route::resource('testimonials', TestimonialController::class);
    Route::get('/admin/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::resource('servicemcq', ServiceMCQController::class);



    Route::resource('banner', BannerController::class);
    Route::resource('service', ServiceController::class);
    Route::resource('manage-professional', ManageProfessionalController::class);
    
    // Professional bank details and payment routes
    Route::get('/professional/bank-details/export', [ManageProfessionalController::class, 'exportBankDetails'])->name('professional.bank-details.export');

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
    Route::get('professional/invoice/{id}/download', [BillingController::class, 'downloadProfessionalInvoice'])->name('professional.invoice.download');
;

   
    Route::get('event/export', [App\Http\Controllers\Admin\EventController::class, 'export'])
        ->name('event.export');
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

    // Chat Routes for Admin
    Route::post('/chat/initialize', [App\Http\Controllers\ChatController::class, 'initializeChat'])->name('admin.chat.initialize');
    Route::get('/chat/{chatId}/messages', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('admin.chat.messages');
    Route::post('/chat/{chatId}/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('admin.chat.send');
    Route::get('/chat/list', [App\Http\Controllers\ChatController::class, 'getChatList'])->name('admin.chat.list');
    Route::post('/chat/update-activity', [App\Http\Controllers\ChatController::class, 'updateActivity'])->name('admin.chat.activity');
    Route::get('/chat/unread-count', [App\Http\Controllers\ChatController::class, 'getUnreadCount'])->name('admin.chat.unread');
});