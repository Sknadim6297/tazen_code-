@extends('admin.layouts.layout')

@section('styles')
<style>
    .management-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .management-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .management-subtitle {
        opacity: 0.9;
        margin: 0;
    }

    .service-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .service-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .service-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .service-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .service-meta {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .service-badge {
        background: #e3f2fd;
        color: #1976d2;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }

    .service-badge.feature-badge {
        background: #f3e5f5;
        color: #7b1fa2;
        margin: 0.25rem 0.25rem 0.25rem 0;
    }

    .service-badge.duration-badge {
        background: #e8f5e8;
        color: #2e7d32;
    }

    .service-badge.price-badge {
        background: #fff3e0;
        color: #f57c00;
        font-weight: 600;
    }

    .btn-group {
        display: flex;
        gap: 0.5rem;
    }

    .btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background: #4f46e5;
        color: white;
    }

    .btn-primary:hover {
        background: #4338ca;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6b7280;
    }

    .empty-state i {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
    }

    .checkbox-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .checkbox-item {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem;
        transition: all 0.2s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 14px;
        min-width: 180px;
    }

    .checkbox-item:hover {
        background: #e3f2fd;
        border-color: #2196f3;
        transform: translateY(-1px);
    }

    .checkbox-item:has(input[type="checkbox"]:checked) {
        background: #e3f2fd !important;
        border-color: #2196f3 !important;
        color: #1976d2 !important;
        font-weight: 500 !important;
    }
    
    .checkbox-item input[type="checkbox"]:checked ~ span {
        color: #1976d2;
        font-weight: 500;
    }

    .checkbox-item input[type="checkbox"] {
        margin: 0;
        margin-right: 8px;
        transform: scale(1.2);
        cursor: pointer;
    }
    
    .checkbox-item span {
        cursor: pointer;
        user-select: none;
    }

    .service-description {
        color: #666;
        font-size: 0.95rem;
        margin: 0.5rem 0;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 3px solid #4f46e5;
    }

    .service-features, .service-tags {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .modal-body .form-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.75rem;
        display: block;
    }

    .modal-body .text-muted {
        font-style: italic;
        text-align: center;
        padding: 1.5rem;
        background: #f8f9fa;
        border-radius: 8px;
        border: 2px dashed #d1d5db;
        color: #6b7280;
    }

    .service-limit-warning {
        background: #fef3cd;
        border: 1px solid #fecf47;
        color: #8a5c0f;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .service-limit-warning i {
        color: #f59e0b;
    }

    .checkbox-item:hover {
        background: #e3f2fd;
        border-color: #2196f3;
    }

    .checkbox-item input[type="checkbox"]:checked + label,
    .checkbox-item:has(input[type="checkbox"]:checked) {
        background: #e3f2fd;
        border-color: #2196f3;
        color: #1976d2;
    }

    .service-description {
        color: #666;
        font-size: 0.95rem;
        margin: 0.5rem 0;
        padding: 0.75rem;
        background: #f8f9fa;
        border-radius: 6px;
        border-left: 3px solid #4f46e5;
    }

    .service-features, .service-tags {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e5e7eb;
    }

    .modal-body .form-group label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .modal-body .text-muted {
        font-style: italic;
        text-align: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 6px;
        border: 2px dashed #d1d5db;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="management-header">
            <h1 class="management-title">Manage Services</h1>
            <p class="management-subtitle">Professional: {{ $professional->name }} ({{ $professional->email }})</p>
        </div>

        <!-- Services List -->
        <div class="row">
            <div class="col-12">
                @if($services->count() > 0)
                    @foreach($services as $service)
                        <div class="service-card">
                            <div class="service-header">
                                <div>
                                    <h3 class="service-name">{{ $service->service->name ?? $service->service_name }}</h3>
                                    <div class="service-meta">
                                        <span class="service-badge">{{ $service->service->name ?? 'General' }}</span>
                                        @if($service->duration)
                                            <span class="service-badge duration-badge">{{ $service->duration }} mins</span>
                                        @endif
                                        @if($service->price)
                                            <span class="service-badge price-badge">₹{{ number_format($service->price, 2) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <button onclick="editService({{ $service->id }})" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button onclick="deleteService({{ $service->id }})" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                            
                            @if($service->description)
                                <p class="service-description"><strong>Description:</strong> {{ $service->description }}</p>
                            @endif
                            
                            @if($service->requirements)
                                <p class="service-description"><strong>Requirements:</strong> {{ $service->requirements }}</p>
                            @endif
                            
                            @php
                                $serviceFeatures = $service->features;
                                if (is_string($serviceFeatures)) {
                                    $decoded = json_decode($serviceFeatures, true);
                                    $serviceFeatures = is_array($decoded) ? $decoded : [];
                                }
                                if (!is_array($serviceFeatures)) {
                                    $serviceFeatures = [];
                                }
                            @endphp

                            @if(count($serviceFeatures) > 0)
                                <div class="service-features mt-2">
                                    <strong>Features:</strong><br>
                                    @foreach($serviceFeatures as $feature)
                                        <span class="service-badge feature-badge">{{ ucfirst(str_replace(['_', '-'], ' ', $feature)) }}</span>
                                    @endforeach
                                </div>
                            @endif
                            
                            @if($service->tags)
                                <div class="service-tags mt-2">
                                    <strong>Tags:</strong> {{ $service->tags }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-concierge-bell"></i>
                        <h3>No Services Found</h3>
                        <p>This professional hasn't added any services yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="actions">
            @if($services->count() == 0)
                <button onclick="showAddServiceModal()" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add Service
                </button>
            @else
                <div class="service-limit-warning">
                    <i class="fas fa-info-circle"></i>
                    <span>This professional already has a service. Only one service is allowed per professional.</span>
                </div>
            @endif
            <a href="{{ route('admin.manage-professional.show', $professional->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Professional Details
            </a>
        </div>
    </div>
</div>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Add New Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.professional.services.store', $professional->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="service_id">Service Category</label>
                        <select class="form-control" id="service_id" name="service_id" required onchange="updateServiceFeatures('add')">
                            <option value="">Select a service</option>
                            @foreach(\App\Models\Service::all() as $service)
                                <option value="{{ $service->id }}" data-features='@json($service->features ?? [])'>{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Choose a service category to see relevant features</small>
                    </div>
                    <div class="form-group">
                        <label>Service Features</label>
                        <div class="checkbox-group" id="addFeaturesContainer">
                            <div class="text-muted">Please select a service category first</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Service Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe this service in detail"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <input type="text" class="form-control" id="tags" name="tags" placeholder="Add tags separated by commas">
                        <small class="text-muted">Example: coaching, business, career</small>
                    </div>
                    <div class="form-group">
                        <label for="requirements">Client Requirements</label>
                        <textarea class="form-control" id="requirements" name="requirements" rows="3" placeholder="List any requirements clients should know before booking"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editServiceForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_service_id">Service Category</label>
                        <select class="form-control" id="edit_service_id" name="service_id" required onchange="updateServiceFeatures('edit')">
                            <option value="">Select a service</option>
                            @foreach(\App\Models\Service::all() as $service)
                                <option value="{{ $service->id }}" data-features='@json($service->features ?? [])'>{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Choose a service category to see relevant features</small>
                    </div>
                    <div class="form-group">
                        <label>Service Features</label>
                        <div class="checkbox-group" id="editFeaturesContainer">
                            <div class="text-muted">Please select a service category first</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Service Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" placeholder="Describe this service in detail"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_tags">Tags</label>
                        <input type="text" class="form-control" id="edit_tags" name="tags" placeholder="Add tags separated by commas">
                        <small class="text-muted">Example: coaching, business, career</small>
                    </div>
                    <div class="form-group">
                        <label for="edit_requirements">Client Requirements</label>
                        <textarea class="form-control" id="edit_requirements" name="requirements" rows="3" placeholder="List any requirements clients should know before booking"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Service features mapping based on categories
const serviceFeatureTemplates = {
    'coaching': ['online_sessions', 'offline_sessions', 'consultation', 'follow_up', 'goal_setting', 'progress_tracking'],
    'counseling': ['online_sessions', 'offline_sessions', 'consultation', 'follow_up', 'confidential', 'assessment'],
    'therapy': ['online_sessions', 'offline_sessions', 'consultation', 'follow_up', 'individual', 'group_therapy'],
    'training': ['online_sessions', 'offline_sessions', 'certification', 'materials', 'hands_on', 'group_training'],
    'consultation': ['online_sessions', 'offline_sessions', 'expert_advice', 'report', 'follow_up', 'analysis'],
    'default': ['online_sessions', 'offline_sessions', 'consultation', 'follow_up']
};

// Feature display names
const featureLabels = {
    'online_sessions': 'Online Sessions',
    'offline_sessions': 'Offline Sessions',
    'consultation': 'Consultation',
    'follow_up': 'Follow-up Support',
    'goal_setting': 'Goal Setting',
    'progress_tracking': 'Progress Tracking',
    'confidential': 'Confidential Sessions',
    'assessment': 'Assessment & Evaluation',
    'individual': 'Individual Sessions',
    'group_therapy': 'Group Therapy',
    'certification': 'Certification Provided',
    'materials': 'Course Materials',
    'hands_on': 'Hands-on Training',
    'group_training': 'Group Training',
    'expert_advice': 'Expert Advice',
    'report': 'Detailed Report',
    'analysis': 'Analysis & Review'
};

function updateServiceFeatures(modalType) {
    const selectId = modalType === 'add' ? 'service_id' : 'edit_service_id';
    const containerId = modalType === 'add' ? 'addFeaturesContainer' : 'editFeaturesContainer';
    
    const select = document.getElementById(selectId);
    const container = document.getElementById(containerId);
    
    if (!select || !container) return;
    
    const selectedOption = select.options[select.selectedIndex];
    
    if (!selectedOption || !selectedOption.value) {
        container.innerHTML = '<div class="text-muted">Please select a service category first</div>';
        return;
    }
    
    // Get features from data attribute or use service name to determine features
    let features = [];
    try {
        const dataFeatures = selectedOption.getAttribute('data-features');
        if (dataFeatures) {
            features = JSON.parse(dataFeatures);
        }
    } catch (e) {
        console.log('Could not parse features from data attribute');
    }
    
    // If no features from data, use service name to determine features
    if (!features || features.length === 0) {
        const serviceName = selectedOption.textContent.toLowerCase();
        features = serviceFeatureTemplates[serviceName] || serviceFeatureTemplates['default'];
    }
    
    // Generate checkboxes
    let html = '';
    features.forEach((feature, index) => {
        const featureKey = feature.toLowerCase().replace(/\s+/g, '_');
        const featureLabel = featureLabels[featureKey] || feature.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        const checked = index === 0 ? 'checked' : ''; // Check first option by default
        
        html += `
            <label class="checkbox-item">
                <input type="checkbox" name="features[]" value="${featureKey}" ${checked}>
                <span>${featureLabel}</span>
            </label>
        `;
    });
    
    container.innerHTML = html;
}

// Ensure Bootstrap modal functionality
$(document).ready(function() {
    // Handle modal close events
    $('.modal').on('hidden.bs.modal', function() {
        const modalId = $(this).attr('id');
        $(this).find('form')[0].reset();
        $(this).find('.checkbox-group input[type="checkbox"]').prop('checked', false);
        
        // Reset features containers
        if (modalId === 'addServiceModal') {
            document.getElementById('addFeaturesContainer').innerHTML = '<div class="text-muted">Please select a service category first</div>';
        } else if (modalId === 'editServiceModal') {
            document.getElementById('editFeaturesContainer').innerHTML = '<div class="text-muted">Please select a service category first</div>';
        }
    });
    
    // Handle close button clicks
    $('.modal .close, .modal [data-dismiss="modal"]').on('click', function() {
        $(this).closest('.modal').modal('hide');
    });
    
    // Make checkbox items clickable
    $(document).on('click', '.checkbox-item', function(e) {
        if (e.target.type !== 'checkbox') {
            const checkbox = $(this).find('input[type="checkbox"]');
            checkbox.prop('checked', !checkbox.prop('checked'));
        }
    });
});

function showAddServiceModal() {
    @if($services->count() > 0)
        alert('This professional already has a service. Only one service is allowed per professional.');
        return;
    @endif
    $('#addServiceModal').modal('show');
}

function editService(serviceId) {
    console.log('EditService called with ID:', serviceId);
    
    // Find the service data
    const services = @json($services);
    const service = services.find(s => s.id === serviceId);
    
    console.log('Found service:', service);
    
    if (service) {
        // Set service dropdown and trigger feature update
        $('#edit_service_id').val(service.service_id || '');
        updateServiceFeatures('edit');
        
        // Handle features checkboxes - decode if string
        let serviceFeatures = service.features;
        if (typeof serviceFeatures === 'string') {
            try {
                serviceFeatures = JSON.parse(serviceFeatures);
            } catch (e) {
                serviceFeatures = [];
            }
        }
        if (!Array.isArray(serviceFeatures)) {
            serviceFeatures = [];
        }
        
        // Wait a bit for features to be generated, then check the appropriate ones
        setTimeout(() => {
            const featuresCheckboxes = document.querySelectorAll('#editFeaturesContainer input[type="checkbox"]');
            featuresCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
                if (serviceFeatures.includes(checkbox.value)) {
                    checkbox.checked = true;
                }
            });
        }, 100);
        
        // Set form field values
        $('#edit_description').val(service.description || '');
        $('#edit_tags').val(service.tags || '');
        $('#edit_requirements').val(service.requirements || '');
        
        // Set form action
        $('#editServiceForm').attr('action', '{{ route('admin.professional.services.update', ['professional' => $professional->id, 'service' => '__SERVICE_ID__']) }}'.replace('__SERVICE_ID__', serviceId));
        $('#editServiceModal').modal('show');
    }
}

function deleteService(serviceId) {
    if (confirm('Are you sure you want to delete this service?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('admin.professional.services.delete', ['professional' => $professional->id, 'service' => '__SERVICE_ID__']) }}'.replace('__SERVICE_ID__', serviceId);
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);
        
        const tokenInput = document.createElement('input');
        tokenInput.type = 'hidden';
        tokenInput.name = '_token';
        tokenInput.value = '{{ csrf_token() }}';
        form.appendChild(tokenInput);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection