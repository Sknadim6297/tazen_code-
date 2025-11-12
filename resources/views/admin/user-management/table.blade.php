@foreach($users as $user)
    <tr>
        <td>
            <div class="d-flex align-items-center">
                <div class="user-avatar" style="background-color: {{ sprintf('#%06X', mt_rand(0, 0xFFFFFF)) }}">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <div>
                    <div class="fw-semibold">{{ $user->name }}</div>
                    <div class="text-muted fs-12">ID: {{ $user->id }}</div>
                </div>
            </div>
        </td>
        <td>
            <div>{{ $user->email }}</div>
            <div class="text-muted fs-12">{{ $user->phone ?? 'No phone' }}</div>
        </td>
        <td>
            @if($user->registration_completed)
                <span class="badge bg-success">Completed</span>
            @else
                <span class="badge bg-warning">Incomplete</span>
            @endif
        </td>
        <td>
            @if($user->email_verified)
                <span class="badge bg-info">
                    <i class="ri-mail-check-line me-1"></i>Verified
                </span>
            @else
                <span class="badge bg-danger">
                    <i class="ri-mail-close-line me-1"></i>Not Verified
                </span>
            @endif
        </td>
        <td>
            <div>{{ $user->created_at->format('M d, Y') }}</div>
            <div class="text-muted fs-12">{{ $user->created_at->format('h:i A') }}</div>
        </td>
        <td class="text-center">
            <div class="action-buttons">
                <button class="btn btn-outline-primary btn-sm me-1" 
                        onclick="viewUser({{ $user->id }})" 
                        data-bs-toggle="tooltip" 
                        title="View Details">
                    <i class="ri-eye-line"></i>
                </button>
                <button class="btn btn-outline-danger btn-sm" 
                        onclick="deleteUser({{ $user->id }})"
                        data-bs-toggle="tooltip" 
                        title="Delete User">
                    <i class="ri-delete-bin-line"></i>
                </button>
            </div>
        </td>
    </tr>
@endforeach