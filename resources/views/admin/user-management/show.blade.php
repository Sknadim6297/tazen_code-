{{-- This is the content that will be loaded into the modal --}}
<div class="row g-3">
    <div class="col-md-6">
        <div class="d-flex align-items-center mb-3">
            <div class="user-avatar me-3" style="background-color: {{ sprintf('#%06X', mt_rand(0, 0xFFFFFF)) }}; width: 60px; height: 60px; font-size: 24px;">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-0">User ID: {{ $user->id }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="text-end">
            @if($user->registration_completed)
                <span class="badge bg-success fs-6">Registration Completed</span>
            @else
                <span class="badge bg-warning fs-6">Registration Incomplete</span>
            @endif
        </div>
    </div>
</div>

<hr>

<div class="row g-4">
    <div class="col-md-6">
        <h6 class="mb-3">Contact Information</h6>
        <div class="mb-3">
            <label class="form-label text-muted">Email Address</label>
            <div class="d-flex align-items-center">
                <span class="me-2">{{ $user->email }}</span>
                @if($user->email_verified)
                    <span class="badge bg-success">
                        <i class="ri-check-line me-1"></i>Verified
                    </span>
                @else
                    <span class="badge bg-danger">
                        <i class="ri-close-line me-1"></i>Not Verified
                    </span>
                @endif
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label text-muted">Phone Number</label>
            <div>{{ $user->phone ?? 'Not provided' }}</div>
        </div>
    </div>
    
    <div class="col-md-6">
        <h6 class="mb-3">Registration Status</h6>
        <div class="mb-3">
            <label class="form-label text-muted">Password Status</label>
            <div>
                @if($user->password)
                    <span class="badge bg-success">
                        <i class="ri-check-line me-1"></i>Password Set
                    </span>
                @else
                    <span class="badge bg-warning">
                        <i class="ri-time-line me-1"></i>Password Pending
                    </span>
                @endif
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label text-muted">Registration Completed</label>
            <div>
                @if($user->registration_completed)
                    <span class="badge bg-success">
                        <i class="ri-check-line me-1"></i>Yes
                    </span>
                @else
                    <span class="badge bg-warning">
                        <i class="ri-time-line me-1"></i>No
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row g-4">
    <div class="col-md-6">
        <h6 class="mb-3">Important Dates</h6>
        <div class="mb-3">
            <label class="form-label text-muted">Registration Started</label>
            <div>{{ $user->created_at ? $user->created_at->format('M d, Y \a\t h:i A') : 'N/A' }}</div>
        </div>
        <div class="mb-3">
            <label class="form-label text-muted">Email Verified At</label>
            <div>{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y \a\t h:i A') : 'Not verified' }}</div>
        </div>
        <div class="mb-3">
            <label class="form-label text-muted">Password Set At</label>
            <div>{{ $user->password_set_at ? $user->password_set_at->format('M d, Y \a\t h:i A') : 'Not set' }}</div>
        </div>
    </div>
    
    <div class="col-md-6">
        <h6 class="mb-3">Registration Progress</h6>
        <div class="progress mb-3" style="height: 20px;">
            @php
                $progress = 0;
                if($user->email_verified) $progress += 50;
                if($user->password && $user->registration_completed) $progress += 50;
            @endphp
            <div class="progress-bar {{ $progress == 100 ? 'bg-success' : ($progress == 50 ? 'bg-warning' : 'bg-danger') }}" 
                 role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $progress }}" 
                 aria-valuemin="0" aria-valuemax="100">
                {{ $progress }}%
            </div>
        </div>
        
        <div class="d-flex flex-column gap-2">
            <div class="d-flex align-items-center">
                @if($user->email_verified)
                    <i class="ri-check-circle-fill text-success me-2"></i>
                @else
                    <i class="ri-close-circle-fill text-danger me-2"></i>
                @endif
                <span>Email Verification</span>
            </div>
            <div class="d-flex align-items-center">
                @if($user->password && $user->registration_completed)
                    <i class="ri-check-circle-fill text-success me-2"></i>
                @else
                    <i class="ri-close-circle-fill text-danger me-2"></i>
                @endif
                <span>Password & Registration Complete</span>
            </div>
        </div>
    </div>
</div>

@if(!$user->registration_completed)
<hr>
<div class="row">
    <div class="col-12">
        <h6 class="mb-3">Admin Actions</h6>
        <div class="d-flex gap-2 flex-wrap">
            <button class="btn btn-success" onclick="forceComplete({{ $user->id }}); $('#userDetailsModal').modal('hide');">
                <i class="ri-check-line me-1"></i> Force Complete Registration
            </button>
            <button class="btn btn-info" onclick="sendReminder({{ $user->id }}); $('#userDetailsModal').modal('hide');">
                <i class="ri-mail-send-line me-1"></i> Send Reminder Email
            </button>
            <button class="btn btn-danger" onclick="deleteUser({{ $user->id }}); $('#userDetailsModal').modal('hide');">
                <i class="ri-delete-bin-line me-1"></i> Delete Incomplete Registration
            </button>
        </div>
    </div>
</div>
@endif