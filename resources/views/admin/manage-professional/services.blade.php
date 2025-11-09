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
    <div class="modal-dialog" role="document" style="max-width:640px;margin:2.5rem auto;">
        <div class="modal-content" style="border-radius:18px;overflow:hidden;border:none;box-shadow:0 18px 45px rgba(15,23,42,0.2);">
            <div class="modal-header" style="padding:22px 26px;border-bottom:1px solid #e5e7eb;background:#f9fafb;align-items:center;">
                <h5 class="modal-title" id="addServiceModalLabel" style="margin:0;font-size:1.1rem;font-weight:600;color:#111827;">Add New Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background:none;border:none;font-size:1.5rem;color:#6b7280;opacity:0.7;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.professional.services.store', $professional->id) }}" method="POST" style="margin:0;">
                @csrf
                <div class="modal-body" style="padding:26px 28px;background:#ffffff;">
                    <div class="form-group" style="margin-bottom:18px;">
                        <label for="service_id" style="font-weight:600;color:#1f2937;margin-bottom:8px;display:block;">Service Category</label>
                        <select class="form-control" id="service_id" name="service_id" required onchange="updateServiceFeatures('add'); loadSubServices(this.value, 'add');" style="width:100%;border-radius:12px;padding:12px 14px;border:1px solid #d1d5db;box-shadow:none;">
                            <option value="">Select a service</option>
                            @foreach(\App\Models\Service::all() as $service)
                                <option value="{{ $service->id }}" data-features='@json($service->features ?? [])'>{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted" style="color:#6b7280;display:block;margin-top:6px;">Choose a service category to see relevant features</small>
                    </div>
                    <div class="form-group" style="margin-bottom:18px;">
                        <label style="font-weight:600;color:#1f2937;margin-bottom:8px;display:block;">Service Features</label>
                        <div class="checkbox-group" id="addFeaturesContainer" style="display:flex;flex-wrap:wrap;gap:0.75rem;padding:10px;border:1px dashed #d1d5db;border-radius:12px;background:#f9fafb;">
                            <div class="text-muted" style="color:#6b7280;">Please select a service category first</div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:18px;">
                        <label style="font-weight:600;color:#1f2937;margin-bottom:8px;display:block;">Sub-Services</label>
                        <div id="addSubServiceContainer" style="max-height:220px;overflow-y:auto;border:1px solid #d1d5db;padding:12px 14px;border-radius:12px;background-color:#f9fafb;">
                            <p class="text-muted" style="margin:0;color:#6b7280;">Please select a service category first to see available sub-services.</p>
                        </div>
                        <small class="text-muted" style="color:#6b7280;display:block;margin-top:6px;">Select one or more sub-services for this professional. You can select multiple sub-services.</small>
                    </div>
                    <div class="form-group" style="margin-bottom:18px;">
                        <label for="description" style="font-weight:600;color:#1f2937;margin-bottom:8px;display:block;">Service Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Describe this service in detail" style="width:100%;border-radius:12px;padding:12px 14px;border:1px solid #d1d5db;resize:vertical;"></textarea>
                    </div>
                    <div class="form-group" style="margin-bottom:18px;">
                        <label for="tags" style="font-weight:600;color:#1f2937;margin-bottom:8px;display:block;">Tags</label>
                        <input type="text" class="form-control" id="tags" name="tags" placeholder="Add tags separated by commas" style="width:100%;border-radius:12px;padding:12px 14px;border:1px solid #d1d5db;">
                        <small class="text-muted" style="color:#6b7280;display:block;margin-top:6px;">Example: coaching, business, career</small>
                    </div>
                    <div class="form-group" style="margin-bottom:10px;">
                        <label for="requirements" style="font-weight:600;color:#1f2937;margin-bottom:8px;display:block;">Client Requirements</label>
                        <textarea class="form-control" id="requirements" name="requirements" rows="3" placeholder="List any requirements clients should know before booking" style="width:100%;border-radius:12px;padding:12px 14px;border:1px solid #d1d5db;resize:vertical;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="padding:18px 26px;border-top:1px solid #e5e7eb;background:#f9fafb;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding:10px 18px;border-radius:10px;border:none;background:#e5e7eb;color:#374151;font-weight:500;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="padding:10px 20px;border-radius:10px;border:none;background:linear-gradient(135deg,#4f46e5,#4338ca);color:#fff;font-weight:600;">Add Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width:640px;margin:2.5rem auto;">
        <div class="modal-content" style="border-radius:18px;overflow:hidden;border:none;box-shadow:0 18px 45px rgba(15,23,42,0.2);">
            <div class="modal-header" style="padding:22px 26px;border-bottom:1px solid #e5e7eb;background:#f9fafb;align-items:center;">
                <h5 class="modal-title" id="editServiceModalLabel" style="margin:0;font-size:1.1rem;font-weight:600;color:#111827;">Edit Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background:none;border:none;font-size:1.5rem;color:#6b7280;opacity:0.7;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editServiceForm" method="POST" style="margin:0;">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding:26px 28px;background:#ffffff;">
                    <div class="form-group" style="margin-bottom:18px;">
                        <label for="edit_service_id" style="font-weight:600;color:#1f2937;margin-bottom:8px;display:block;">Service Category *</label>
                        <select class="form-control" id="edit_service_id" name="service_id" required onchange="updateServiceFeatures('edit'); loadSubServices(this.value, 'edit');" style="width:100%;border-radius:12px;padding:12px 14px;border:1px solid #d1d5db;box-shadow:none;">
                            <option value="">Select a service</option>
                            @foreach(\App\Models\Service::all() as $service)
                                <option value="{{ $service->id }}" data-features='@json($service->features ?? [])'>{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted" style="color:#6b7280;display:block;margin-top:6px;">Choose a service category to see relevant features and sub-services</small>
                    </div>
                    
                    <!-- Sub-Service Selection -->
                    <div class="form-group" style="margin-bottom:18px;">
                        <label for="edit_subServices" style="font-weight:600;color:#1f2937;margin-bottom:8px;display:block;">Sub-Services (Optional)</label>
                        <div id="editSubServiceContainer" class="checkbox-group" style="border:1px solid #d1d5db;border-radius:12px;padding:15px;background-color:#f9fafb;min-height:60px;display:flex;flex-wrap:wrap;gap:0.75rem;">
                            <div class="text-muted" style="color:#6b7280;">Loading sub-services...</div>
                        </div>
                        <small class="text-muted" style="color:#6b7280;display:block;margin-top:6px;">Select the specific sub-services you offer within your service category.</small>
                    </div>

                    <div class="form-group" style="margin-bottom:18px;">
                        <label for="edit_description" style="font-weight:600;color:#1f2937;margin-bottom:8px;display:block;">Service Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" placeholder="Describe this service in detail" style="width:100%;border-radius:12px;padding:12px 14px;border:1px solid #d1d5db;resize:vertical;"></textarea>
                    </div>
                    <div class="form-group" style="margin-bottom:18px;">
                        <label for="edit_tags" style="font-weight:600;color:#1f2937;margin-bottom:8px;display:block;">Tags</label>
                        <input type="text" class="form-control" id="edit_tags" name="tags" placeholder="Add tags separated by commas" style="width:100%;border-radius:12px;padding:12px 14px;border:1px solid #d1d5db;">
                        <small class="text-muted" style="color:#6b7280;display:block;margin-top:6px;">Example: coaching, business, career</small>
                    </div>
                    <div class="form-group" style="margin-bottom:10px;">
                        <label for="edit_requirements" style="font-weight:600;color:#1f2937;margin-bottom:8px;display:block;">Client Requirements</label>
                        <textarea class="form-control" id="edit_requirements" name="requirements" rows="3" placeholder="List any requirements clients should know before booking" style="width:100%;border-radius:12px;padding:12px 14px;border:1px solid #d1d5db;resize:vertical;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="padding:18px 26px;border-top:1px solid #e5e7eb;background:#f9fafb;">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="padding:10px 18px;border-radius:10px;border:none;background:#e5e7eb;color:#374151;font-weight:500;">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="padding:10px 20px;border-radius:10px;border:none;background:linear-gradient(135deg,#4f46e5,#4338ca);color:#fff;font-weight:600;">Update Service</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Service features mapping based on categories
const serviceFeatureTemplates = {
    'coaching': ['online_sessions', 'offline_sessions', 'consultation', 'follow_up', 'goal_setting', 'progress_tracking', 'assessment', 'certification'],
    'counseling': ['online_sessions', 'offline_sessions', 'consultation', 'follow_up', 'confidential', 'assessment', 'individual', 'group_therapy'],
    'therapy': ['online_sessions', 'offline_sessions', 'consultation', 'follow_up', 'individual', 'group_therapy', 'assessment', 'confidential'],
    'training': ['online_sessions', 'offline_sessions', 'certification', 'materials', 'hands_on', 'group_training', 'assessment', 'follow_up'],
    'consultation': ['online_sessions', 'offline_sessions', 'expert_advice', 'report', 'follow_up', 'analysis', 'assessment', 'consultation'],
    'astrology': ['online_sessions', 'offline_sessions', 'consultation', 'horoscope', 'birth_chart', 'prediction', 'follow_up', 'analysis'],
    'numerology': ['online_sessions', 'offline_sessions', 'consultation', 'life_path', 'name_analysis', 'prediction', 'follow_up', 'report'],
    'vastu': ['online_sessions', 'offline_sessions', 'consultation', 'site_visit', 'analysis', 'recommendations', 'follow_up', 'report'],
    'default': ['online_sessions', 'offline_sessions', 'consultation', 'follow_up', 'assessment', 'expert_advice', 'certification', 'materials', 'analysis', 'report']
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
    'analysis': 'Analysis & Review',
    'horoscope': 'Horoscope Reading',
    'birth_chart': 'Birth Chart Analysis',
    'prediction': 'Future Prediction',
    'life_path': 'Life Path Analysis',
    'name_analysis': 'Name Analysis',
    'site_visit': 'Site Visit',
    'recommendations': 'Recommendations'
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
    
    // For add modal, only show "Online Sessions" feature
    if (modalType === 'add') {
        const html = `
            <label class="checkbox-item">
                <input type="checkbox" name="features[]" value="online_sessions" checked>
                <span>Online Sessions</span>
            </label>
        `;
        container.innerHTML = html;
        return;
    }
    
    // For edit modal, show existing logic for flexibility
    // Get features from data attribute first
    let features = [];
    try {
        const dataFeatures = selectedOption.getAttribute('data-features');
        if (dataFeatures && dataFeatures !== 'null' && dataFeatures !== '[]') {
            const parsedFeatures = JSON.parse(dataFeatures);
            if (Array.isArray(parsedFeatures) && parsedFeatures.length > 0) {
                features = parsedFeatures;
            }
        }
    } catch (e) {
        console.log('Could not parse features from data attribute:', e);
    }
    
    // If no features from data attribute, use service name to determine features
    if (!features || features.length === 0) {
        const serviceName = selectedOption.textContent.toLowerCase().trim();
        console.log('Using service name for features:', serviceName);
        
        // Match service name with templates (more flexible matching)
        let foundTemplate = null;
        for (const [key, templateFeatures] of Object.entries(serviceFeatureTemplates)) {
            if (serviceName.includes(key)) {
                foundTemplate = templateFeatures;
                break;
            }
        }
        
        // If no specific match found, use all default features
        features = foundTemplate || serviceFeatureTemplates['default'];
    }
    
    console.log('Final features for', selectedOption.textContent, ':', features);
    
    // Always show a comprehensive set of features for edit
    if (!features || features.length <= 2) {
        // If we only have very few features, show a more comprehensive default set
        features = [
            'online_sessions', 
            'offline_sessions', 
            'consultation', 
            'follow_up', 
            'assessment', 
            'certification',
            'materials',
            'expert_advice',
            'report',
            'analysis'
        ];
    }
    
    // Generate checkboxes for edit modal
    let html = '';
    features.forEach((feature, index) => {
        const featureKey = feature.toLowerCase().replace(/\s+/g, '_');
        const featureLabel = featureLabels[featureKey] || feature.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
        
        // Auto-check "online_sessions" by default
        const isDefaultChecked = featureKey === 'online_sessions' ? 'checked' : '';
        
        html += `
            <label class="checkbox-item">
                <input type="checkbox" name="features[]" value="${featureKey}" ${isDefaultChecked}>
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
        // Set service dropdown (now editable in admin panel)
        $('#edit_service_id').val(service.service_id || '');
        
        // Load sub-services first
        const subServiceIds = service.sub_services ? service.sub_services.map(s => s.id) : [];
        loadSubServices(service.service_id, 'edit', subServiceIds);
        
        // Update features based on selected service
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
                // Always check "online_sessions" by default
                if (checkbox.value === 'online_sessions') {
                    checkbox.checked = true;
                }
                // Check other features from service data
                else if (serviceFeatures.includes(checkbox.value)) {
                    checkbox.checked = true;
                }
            });
        }, 200);
        
        // Set form field values
        $('#edit_description').val(service.description || '');
        $('#edit_tags').val(service.tags || '');
        $('#edit_requirements').val(service.requirements || '');
        
        // Set form action
        $('#editServiceForm').attr('action', '{{ route('admin.professional.services.update', ['professional' => $professional->id, 'service' => '__SERVICE_ID__']) }}'.replace('__SERVICE_ID__', serviceId));
        $('#editServiceModal').modal('show');
    }
}

function loadSubServices(serviceId, modalType = 'edit', selectedSubServices = []) {
    const containerId = modalType === 'edit' ? 'editSubServiceContainer' : 'addSubServiceContainer';
    const container = $('#' + containerId);
    
    console.log('loadSubServices called with serviceId:', serviceId, 'modalType:', modalType, 'selectedSubServices:', selectedSubServices);
    
    if (!serviceId) {
        container.html('<p class="text-muted">Please select a service category first to see available sub-services.</p>');
        return;
    }
    
    container.html('<div class="text-muted">Loading sub-services...</div>');
    
    $.ajax({
        url: "{{ route('admin.get.sub.services', ['serviceId' => '__SERVICE_ID__']) }}".replace('__SERVICE_ID__', serviceId),
        type: "GET",
        success: function(response) {
            console.log('AJAX response:', response);
            if (response.success && response.subServices && response.subServices.length > 0) {
                let html = '';
                response.subServices.forEach(function(subService) {
                    const isSelected = selectedSubServices.includes(subService.id);
                    html += `
                        <label class="checkbox-item" style="display: flex; align-items: center; margin-bottom: 10px; padding: 8px; background-color: white; border-radius: 5px; border: 1px solid #dee2e6; cursor: pointer;">
                            <input type="checkbox" name="subServices[]" value="${subService.id}" id="subService${subService.id}_${modalType}" ${isSelected ? 'checked' : ''} style="margin-right: 10px; transform: scale(1.2);">
                            <span style="cursor: pointer; font-weight: 500;">${subService.name}</span>
                        </label>
                    `;
                });
                container.html(html);
            } else {
                container.html('<p class="text-muted">No sub-services available for this category.</p>');
            }
        },
        error: function(xhr) {
            console.error('AJAX error:', xhr);
            container.html('<p class="text-danger">Error loading sub-services. Please try again.</p>');
        }
    });
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