@foreach($users as $user)
    <div class="mobile-card">
        <div class="d-flex align-items-start justify-content-between mb-3">
            <div class="d-flex align-items-center">
                <div class="user-avatar" style="background-color: {{ sprintf('#%06X', mt_rand(0, 0xFFFFFF)) }}">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <div class="fw-semibold">{{ $user->name }}</div>
                    <div class="text-muted fs-12">ID: {{ $user->id }}</div>
                </div>
            </div>
            <div class="text-end">
                @if($user->registration_completed)
                    <span class="badge bg-success">Completed</span>
                @else
                    <span class="badge bg-warning">Incomplete</span>
                @endif
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-6">
                <div class="text-muted fs-12">Email</div>
                <div class="fs-13">{{ $user->email }}</div>
            </div>
            <div class="col-6">
                <div class="text-muted fs-12">Phone</div>
                <div class="fs-13">{{ $user->phone ?? 'No phone' }}</div>
            </div>
        </div>

        <div class="row g-2 mb-3">
            <div class="col-6">
                <div class="text-muted fs-12">Email Status</div>
                <div>
                    @if($user->email_verified)
                        <span class="badge bg-info">
                            <i class="ri-mail-check-line me-1"></i>Verified
                        </span>
                    @else
                        <span class="badge bg-danger">
                            <i class="ri-mail-close-line me-1"></i>Not Verified
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-6">
                <div class="text-muted fs-12">Registration Date</div>
                <div class="fs-13">{{ $user->created_at->format('M d, Y') }}</div>
            </div>
        </div>

        <div class="action-buttons">
            <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $user->id }})">
                <i class="ri-delete-bin-line"></i> Delete
            </button>
        </div>
    </div>
@endforeach