@if($account)
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-user me-2"></i>Professional Information
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    @if($account->professional->profile_picture)
                        <img src="{{ asset('storage/' . $account->professional->profile_picture) }}" 
                             alt="Profile" class="rounded-circle me-3" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" 
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-user text-white fa-lg"></i>
                        </div>
                    @endif
                    <div>
                        <h6 class="mb-1">{{ $account->professional->name }}</h6>
                        <small class="text-muted">{{ $account->professional->email }}</small>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Phone:</small>
                        <div>{{ $account->professional->phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Status:</small>
                        <div>
                            <span class="badge status-{{ $account->professional->status }}">
                                {{ ucfirst($account->professional->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($account->professional->address)
                <div class="mt-2">
                    <small class="text-muted">Address:</small>
                    <div>{{ $account->professional->address }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-university me-2"></i>Bank Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-4">
                        <small class="text-muted">Bank Name:</small>
                    </div>
                    <div class="col-8">
                        <strong>{{ $account->bank_name }}</strong>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-4">
                        <small class="text-muted">Branch:</small>
                    </div>
                    <div class="col-8">
                        {{ $account->branch_name }}
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-4">
                        <small class="text-muted">Account Holder:</small>
                    </div>
                    <div class="col-8">
                        {{ $account->account_holder_name }}
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-4">
                        <small class="text-muted">Account Number:</small>
                    </div>
                    <div class="col-8">
                        <span class="account-details">{{ $account->account_number }}</span>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-4">
                        <small class="text-muted">IFSC Code:</small>
                    </div>
                    <div class="col-8">
                        <span class="ifsc-code">{{ $account->ifsc_code }}</span>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-4">
                        <small class="text-muted">Account Type:</small>
                    </div>
                    <div class="col-8">
                        <span class="badge account-type-{{ $account->account_type }}">
                            {{ ucfirst($account->account_type) }}
                        </span>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-4">
                        <small class="text-muted">Verification:</small>
                    </div>
                    <div class="col-8">
                        <span class="badge verification-{{ $account->verification_status ?? 'pending' }}">
                            {{ ucfirst($account->verification_status ?? 'pending') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-clock me-2"></i>Timeline Information
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <small class="text-muted">Account Created:</small>
                        <div>{{ $account->created_at->format('M d, Y h:i A') }}</div>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">Last Updated:</small>
                        <div>{{ $account->updated_at->format('M d, Y h:i A') }}</div>
                    </div>
                    <div class="col-md-4">
                        <small class="text-muted">Professional Joined:</small>
                        <div>{{ $account->professional->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
                
                @if($account->verification_status === 'verified')
                <div class="row mt-3">
                    <div class="col-md-4">
                        <small class="text-muted">Verified On:</small>
                        <div>{{ $account->verified_at ? $account->verified_at->format('M d, Y h:i A') : 'N/A' }}</div>
                    </div>
                    @if($account->verified_by)
                    <div class="col-md-4">
                        <small class="text-muted">Verified By:</small>
                        <div>Admin</div>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($account->verification_status !== 'verified')
<div class="mt-3 text-center">
    <button type="button" class="btn btn-success" onclick="verifyAccountFromModal({{ $account->id }})">
        <i class="fas fa-check me-2"></i>Verify This Account
    </button>
</div>
@endif

<script>
function verifyAccountFromModal(accountId) {
    Swal.fire({
        title: 'Verify Bank Account?',
        text: 'Are you sure you want to verify this bank account?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Verify',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/bank-accounts/${accountId}/verify`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $('#viewAccountModal').modal('hide');
                        location.reload();
                    } else {
                        toastr.error(response.message || 'Failed to verify account');
                    }
                },
                error: function() {
                    toastr.error('Failed to verify account');
                }
            });
        }
    });
}
</script>

@else
<div class="text-center py-4">
    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
    <h5>Account Not Found</h5>
    <p class="text-muted">The requested bank account could not be found.</p>
</div>
@endif