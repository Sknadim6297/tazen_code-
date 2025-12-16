@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Purchased Plans</h1>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Purchased Plans</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Page Header Close -->

        <div class="row">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">All Purchased Plans</div>
                    </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filters -->
                    <form method="GET" action="{{ route('admin.purchased-plans.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search by professional name/email..." 
                                       value="{{ request('search') }}">
                            </div>
                            <div class="col-md-3">
                                <select name="payment_status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="success" {{ request('payment_status') === 'success' ? 'selected' : '' }}>Success</option>
                                    <option value="failed" {{ request('payment_status') === 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.purchased-plans.index') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-redo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Professional</th>
                                    <th>Plan Name</th>
                                    <th>Price</th>
                                    <th>Payment Method</th>
                                    <th>Leads</th>
                                    <th>Payment Status</th>
                                    <th>Purchase Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($purchases as $purchase)
                                    <tr>
                                        <td>{{ $purchase->id }}</td>
                                        <td>
                                            <strong>{{ $purchase->professional->name ?? 'N/A' }}</strong><br>
                                            <small class="text-muted">{{ $purchase->professional->email ?? '' }}</small>
                                        </td>
                                        <td>{{ $purchase->plan_name }}</td>
                                        <td>{{ $purchase->formatted_price }}</td>
                                        <td>
                                            {{ ucfirst($purchase->payment_method ?? 'N/A') }}
                                            @if($purchase->payment_screenshot)
                                                <br>
                                                <button type="button" class="btn btn-xs btn-outline-primary mt-1" onclick="showScreenshotModal('{{ asset('storage/' . $purchase->payment_screenshot) }}')">
                                                    <i class="fas fa-image"></i> View
                                                </button>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $purchase->leads_used }}/{{ $purchase->lead_limit }}
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                Remaining: {{ $purchase->remaining_leads }}
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $purchase->payment_status === 'success' ? 'success' : ($purchase->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($purchase->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $purchase->created_at->format('d M, Y') }}<br>
                                            <small class="text-muted">{{ $purchase->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.purchased-plans.show', $purchase->id) }}" 
                                                   class="btn btn-sm btn-info" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.purchased-plans.edit', $purchase->id) }}" 
                                                   class="btn btn-sm btn-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            No purchased plans found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $purchases->links() }}
                    </div>
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
