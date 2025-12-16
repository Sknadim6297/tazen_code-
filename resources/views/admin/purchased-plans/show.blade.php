@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Purchase Details</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.purchased-plans.index') }}">Purchased Plans</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="card-title">Purchase Information</div>
                        <div>
                            <a href="{{ route('admin.purchased-plans.edit', $purchase->id) }}" class="btn btn-primary btn-sm">
                                <i class="ri-edit-line me-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.purchased-plans.index') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line me-1"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="mb-3">Professional Details</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Name:</th>
                                        <td>{{ $purchase->professional->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td>{{ $purchase->professional->email ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Phone:</th>
                                        <td>{{ $purchase->professional->phone ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Plan Details</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Plan Name:</th>
                                        <td><strong>{{ $purchase->plan_name }}</strong></td>
                                    </tr>
                                    <tr>
                                        <th>Price:</th>
                                        <td>{{ $purchase->formatted_price }}</td>
                                    </tr>
                                    <tr>
                                        <th>Lead Limit:</th>
                                        <td>{{ $purchase->lead_limit }} leads</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="mb-3">Payment & Status</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="20%">Payment Status:</th>
                                        <td>
                                            <span class="badge bg-{{ $purchase->payment_status === 'success' ? 'success' : ($purchase->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($purchase->payment_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Payment Method:</th>
                                        <td>{{ ucfirst($purchase->payment_method ?? 'N/A') }}</td>
                                    </tr>
                                    @if($purchase->payment_id)
                                        <tr>
                                            <th>Payment ID:</th>
                                            <td><code>{{ $purchase->payment_id }}</code></td>
                                        </tr>
                                    @endif
                                    @if($purchase->payment_screenshot)
                                        <tr>
                                            <th>Payment Screenshot:</th>
                                            <td>
                                                <a href="{{ asset('storage/' . $purchase->payment_screenshot) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-image me-1"></i> View Screenshot
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-info" onclick="showScreenshotModal('{{ asset('storage/' . $purchase->payment_screenshot) }}')">
                                                    <i class="fas fa-search-plus me-1"></i> Preview
                                                </button>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th>Leads Used:</th>
                                        <td>
                                            <strong>{{ $purchase->leads_used }}/{{ $purchase->lead_limit }}</strong>
                                            <span class="text-muted">({{ $purchase->remaining_leads }} remaining)</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Purchase Date:</th>
                                        <td>{{ $purchase->created_at->format('d M, Y h:i A') }}</td>
                                    </tr>
                                    @if($purchase->start_date)
                                        <tr>
                                            <th>Start Date:</th>
                                            <td>{{ $purchase->start_date->format('d M, Y') }}</td>
                                        </tr>
                                    @endif
                                    @if($purchase->end_date)
                                        <tr>
                                            <th>End Date:</th>
                                            <td>
                                                {{ $purchase->end_date->format('d M, Y') }}
                                                @if($purchase->isExpired())
                                                    <span class="badge bg-danger">Expired</span>
                                                @else
                                                    <span class="badge bg-success">Active</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>

                        @if($purchase->features && is_array($purchase->features))
                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Plan Features</h5>
                                    <ul class="list-group">
                                        @foreach($purchase->features as $feature)
                                            <li class="list-group-item">
                                                <i class="ri-check-line text-success me-2"></i>{{ $feature }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if($purchase->admin_notes)
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="mb-3">Admin Notes</h5>
                                    <div class="alert alert-info">
                                        {{ $purchase->admin_notes }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Screenshot Preview Modal -->
<div class="modal fade" id="screenshotPreviewModal" tabindex="-1" aria-labelledby="screenshotPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="screenshotPreviewModalLabel">Payment Screenshot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="screenshotPreviewImage" src="" alt="Payment Screenshot" class="img-fluid" style="max-height: 70vh; border-radius: 8px;">
            </div>
        </div>
    </div>
</div>

<script>
function showScreenshotModal(imageUrl) {
    document.getElementById('screenshotPreviewImage').src = imageUrl;
    var modal = new bootstrap.Modal(document.getElementById('screenshotPreviewModal'));
    modal.show();
}
</script>
@endsection
