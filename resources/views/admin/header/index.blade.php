@extends('admin.layouts.layout')
@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Header Management</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Admin</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Headers</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Page Header Close -->

        <!-- Start::row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Header List
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-primary btn-wave waves-light" data-bs-toggle="modal" data-bs-target="#create-header">
                                <i class="ri-add-line fw-medium align-middle me-1"></i> Add New Header
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tagline</th>
                                        <th>Status</th>
                                        <th>Features</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($headers as $index => $header)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $header->tagline }}</td>
                                        <td>
                                            <span class="badge bg-{{ $header->status === 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($header->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $header->features->count() }} Features</span>
                                        </td>
                                        <td>{{ $header->created_at->format('d M Y') }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#edit-header-{{ $header->id }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.header.destroy', $header->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure you want to delete this header?')" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="edit-header-{{ $header->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <form action="{{ route('admin.header.update', $header->id) }}" method="POST" id="edit-form-{{ $header->id }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h6 class="modal-title">Edit Header</h6>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body px-4">
                                                        <div class="row gy-3">
                                                            <div class="col-xl-12">
                                                                <label for="tagline" class="form-label">Tagline <span class="text-danger">*</span></label>
                                                                <input type="text" class="form-control" id="tagline" name="tagline" value="{{ $header->tagline }}" required>
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                                                <select class="form-select" id="status" name="status" required>
                                                                    <option value="active" {{ $header->status == 'active' ? 'selected' : '' }}>Active</option>
                                                                    <option value="inactive" {{ $header->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                                </select>
                                                            </div>

                                                            <!-- Feature Sections -->
                                                            <div class="col-xl-12">
                                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                                    <label class="form-label mb-0">Features <span class="text-danger">*</span></label>
                                                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addFeatureEdit('{{ $header->id }}')">
                                                                        <i class="ri-add-line me-1"></i> Add Feature
                                                                    </button>
                                                                </div>
                                                                <div id="features-container-{{ $header->id }}">
                                                                    @foreach($header->features as $featureIndex => $feature)
                                                                    <div class="feature-item mb-3 p-3 border rounded">
                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                            <strong>Feature {{ $featureIndex + 1 }}</strong>
                                                                            <button type="button" class="btn btn-sm btn-danger" onclick="removeFeatureEdit(this)">
                                                                                <i class="ri-delete-bin-line"></i> Remove
                                                                            </button>
                                                                        </div>
                                                                        <div class="mb-2">
                                                                            <label class="form-label">Feature Heading <span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" name="features[{{ $featureIndex }}][feature_heading]" value="{{ $feature->feature_heading }}" required>
                                                                        </div>
                                                                        <div>
                                                                            <label class="form-label">Services <span class="text-danger">*</span></label>
                                                                            <select class="form-select" name="features[{{ $featureIndex }}][services][]" multiple required>
                                                                                @foreach($services as $service)
                                                                                    <option value="{{ $service->id }}" {{ $feature->services->contains($service->id) ? 'selected' : '' }}>
                                                                                        {{ $service->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                            <small class="text-muted">Hold Ctrl/Cmd to select multiple services</small>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Header</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">No headers found. Click "Add New Header" to create one.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="create-header" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form action="{{ route('admin.header.store') }}" method="POST" id="create-form">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Add New Header</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="row gy-3">
                        <div class="col-xl-12">
                            <label for="tagline" class="form-label">Tagline <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="tagline" name="tagline" required>
                        </div>
                        <div class="col-xl-12">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Feature Sections -->
                        <div class="col-xl-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="form-label mb-0">Features <span class="text-danger">*</span></label>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addFeature()">
                                    <i class="ri-add-line me-1"></i> Add Feature
                                </button>
                            </div>
                            <div id="features-container">
                                <!-- Features will be added here dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Header</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
let featureIndex = 0;

function addFeature() {
    const container = document.getElementById('features-container');
    const featureHtml = `
        <div class="feature-item mb-3 p-3 border rounded">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>Feature ${featureIndex + 1}</strong>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeFeature(this)">
                    <i class="ri-delete-bin-line"></i> Remove
                </button>
            </div>
            <div class="mb-2">
                <label class="form-label">Feature Heading <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="features[${featureIndex}][feature_heading]" required>
            </div>
            <div>
                <label class="form-label">Services <span class="text-danger">*</span></label>
                <select class="form-select" name="features[${featureIndex}][services][]" multiple required>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Hold Ctrl/Cmd to select multiple services</small>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', featureHtml);
    featureIndex++;
}

function removeFeature(button) {
    button.closest('.feature-item').remove();
    // Update feature indices
    const container = document.getElementById('features-container');
    const features = container.querySelectorAll('.feature-item');
    features.forEach((feature, index) => {
        feature.querySelector('strong').textContent = `Feature ${index + 1}`;
        // Update form field names
        const inputs = feature.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/features\[\d+\]/, `features[${index}]`);
            }
        });
    });
    featureIndex = features.length;
}

function addFeatureEdit(headerId) {
    const container = document.getElementById(`features-container-${headerId}`);
    const existingFeatures = container.querySelectorAll('.feature-item');
    const newIndex = existingFeatures.length;
    
    const featureHtml = `
        <div class="feature-item mb-3 p-3 border rounded">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>Feature ${newIndex + 1}</strong>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeFeatureEdit(this)">
                    <i class="ri-delete-bin-line"></i> Remove
                </button>
            </div>
            <div class="mb-2">
                <label class="form-label">Feature Heading <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="features[${newIndex}][feature_heading]" required>
            </div>
            <div>
                <label class="form-label">Services <span class="text-danger">*</span></label>
                <select class="form-select" name="features[${newIndex}][services][]" multiple required>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Hold Ctrl/Cmd to select multiple services</small>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', featureHtml);
}

function removeFeatureEdit(button) {
    const container = button.closest('[id^="features-container-"]');
    if (!container) return;
    
    const featureItem = button.closest('.feature-item');
    featureItem.remove();
    
    // Update feature indices
    const features = container.querySelectorAll('.feature-item');
    features.forEach((feature, index) => {
        feature.querySelector('strong').textContent = `Feature ${index + 1}`;
        // Update form field names
        const inputs = feature.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/features\[\d+\]/, `features[${index}]`);
            }
        });
    });
}

// Add initial feature when modal opens
document.getElementById('create-header').addEventListener('shown.bs.modal', function() {
    if (document.getElementById('features-container').children.length === 0) {
        addFeature();
    }
});
</script>
@endsection
