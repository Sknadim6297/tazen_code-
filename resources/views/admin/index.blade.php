@extends('admin.layouts.layout')
@section('styles')
<style>
    .notifications-container {
        margin-bottom: 30px;
        padding: 20px;
    }
    
    .alert {
        padding: 20px;
        margin-bottom: 15px;
        position: relative;
        transition: all 0.3s ease;
        animation: fadeIn 0.5s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .alert-dismissible .btn-close {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 20px;
        font-weight: 700;
        line-height: 1;
        color: inherit;
        background: transparent;
        border: 0;
        opacity: 0.5;
        cursor: pointer;
    }
    
    .alert-dismissible .btn-close:hover {
        opacity: 1;
    }
    
    .alert-info {
        background-color: #d1ecf1 !important;
        border-left: 4px solid #17a2b8 !important;
        color: #0c5460 !important;
    }
    
    .dashboard-welcome {
        border-radius: 15px;
        padding: 40px;
        color: white;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
</style>
@endsection
@section('content')
 <div class="main-content app-content">
    <div class="container-fluid">
        <!-- Dashboard Content -->
        <div class="dashboard-welcome">
            <h1 style="font-size: 48px; font-weight: bold; margin-bottom: 20px;">
                Welcome to Admin Dashboard
            </h1>
            <p style="font-size: 18px; opacity: 0.9; margin: 0;">
                Manage your platform with ease and efficiency
            </p>
        </div>

        <!-- Notifications Section -->
        @if(isset($rescheduleNotifications) && $rescheduleNotifications->count() > 0)
            <div class="notifications-container">
                @foreach($rescheduleNotifications as $notification)
                    @php
                        $data = $notification->data;
                        $customerName = $data['customer_name'] ?? 'Customer';
                        $professionalName = $data['professional_name'] ?? 'Professional';
                        $serviceName = $data['service_name'] ?? 'Service';
                        $oldDate = $data['old_date'] ?? '';
                        $oldTime = $data['old_time'] ?? '';
                        $newDate = $data['new_date'] ?? '';
                        $newTime = $data['new_time'] ?? '';
                        $rescheduledAt = $notification->created_at->format('M d, Y \a\t g:i A');
                    @endphp
                    <div class="alert alert-info alert-dismissible fade show" role="alert" style="border-left: 4px solid #17a2b8; background-color: #d1ecf1; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                        <div style="display: flex; align-items: start;">
                            <i class="fas fa-calendar-alt" style="font-size: 20px; margin-right: 12px; color: #17a2b8; margin-top: 2px;"></i>
                            <div style="flex: 1;">
                                <h5 style="margin: 0 0 8px 0; color: #0c5460; font-weight: 600;">Appointment Rescheduled</h5>
                                <p style="margin: 0 0 4px 0; color: #0c5460;">
                                    <strong>{{ $customerName }}</strong> has rescheduled their {{ $serviceName }} appointment with <strong>{{ $professionalName }}</strong>.
                                </p>
                                <div style="margin: 8px 0; padding: 8px; background-color: #b8daff; border-radius: 4px; font-size: 14px;">
                                    <div style="margin-bottom: 4px; color: #0c5460;">
                                        <strong>Previous:</strong> {{ \Carbon\Carbon::parse($oldDate)->format('M d, Y') }} at {{ $oldTime }}
                                    </div>
                                    <div style="color: #0c5460;">
                                        <strong>New:</strong> {{ \Carbon\Carbon::parse($newDate)->format('M d, Y') }} at {{ $newTime }}
                                    </div>
                                </div>
                                <small style="color: #6c757d;">{{ $rescheduledAt }}</small>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" 
                                onclick="markNotificationAsRead('{{ $notification->id }}')"></button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
 </div>
    
@endsection
@section('scripts')
<script>
    // Function to mark notification as read
    function markNotificationAsRead(notificationId) {
        fetch('/admin/notifications/' + notificationId + '/mark-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Notification marked as read');
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    }
</script>
@endsection