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

    .rate-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .rate-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
    }

    .rate-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .rate-type {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin: 0;
    }

    .rate-amount {
        font-size: 2rem;
        font-weight: 700;
        color: #4f46e5;
        margin: 0;
    }

    .rate-details {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .rate-badge {
        background: #f3f4f6;
        color: #374151;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 500;
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

    .features-list {
        margin-top: 1rem;
    }

    .feature-tag {
        display: inline-block;
        background: #e0e7ff;
        color: #4338ca;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        margin: 0.25rem 0.25rem 0.25rem 0;
    }

    .rate-per-session {
        font-size: 0.9rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .feature-item {
        margin-bottom: 0.75rem;
    }

    .feature-input {
        flex: 1;
    }

    .remove-feature {
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .add-feature, .add-edit-feature {
        margin-top: 0.5rem;
    }

    .modal-body .form-group {
        margin-bottom: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid mt-4">
        <!-- Header -->
        <div class="management-header">
            <h1 class="management-title">Manage Pricing Plans</h1>
            <p class="management-subtitle">Professional: {{ $professional->name }} ({{ $professional->email }})</p>
        </div>
        <!-- Rates List -->
        <div class="row">
            <div class="col-12">
                @if($rates->count() > 0)
                    @foreach($rates as $rate)
                        <div class="rate-card">
                            <div class="rate-header">
                                <div>
                                    <h3 class="rate-type">{{ $rate->session_type }}</h3>
                                    <div class="rate-details">
                                        <span class="rate-badge">{{ $rate->num_sessions }} sessions</span>
                                        <span class="rate-badge">₹{{ number_format($rate->rate_per_session) }}/session</span>
                                    </div>
                                    <div class="rate-per-session">
                                        {{ $rate->num_sessions }} × ₹{{ number_format($rate->rate_per_session) }} = ₹{{ number_format($rate->final_rate) }}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="text-end me-3">
                                        <div class="rate-amount">₹{{ number_format($rate->final_rate) }}</div>
                                        <small class="text-muted">Total Amount</small>
                                    </div>
                                    <div class="btn-group">
                                        <button onclick="editRate({{ $rate->id }})" class="btn btn-primary">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button onclick="deleteRate({{ $rate->id }})" class="btn btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            @if($rate->features && count($rate->features) > 0)
                                <div class="features-list">
                                    <strong>Features:</strong>
                                    <div class="mt-2">
                                        @foreach($rate->features as $feature)
                                            @if(trim($feature))
                                                <span class="feature-tag">{{ $feature }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="fas fa-money-bill-wave"></i>
                        <h3>No Pricing Plans Found</h3>
                        <p>This professional hasn't set up any pricing plans yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="actions">
            <button onclick="showAddRateModal()" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Add New Rate
            </button>
            <a href="{{ route('admin.manage-professional.show', $professional->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back to Professional Details
            </a>
        </div>
    </div>
</div>

<!-- Add Rate Modal -->
<div class="modal fade" id="addRateModal" tabindex="-1" role="dialog" aria-labelledby="addRateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRateModalLabel">Add New Rate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.professional.rates.store', $professional->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="session_type">Session Type</label>
                        <select class="form-control" id="session_type" name="session_type" required>
                            <option value="">Select session type</option>
                            <option value="One Time">One Time</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Quarterly">Quarterly</option>
                            <option value="Free Hand">Free Hand</option>
                        </select>
                        <small id="sessionWarning" class="text-danger" style="display:none;">A rate with this session type already exists. Please choose another type or edit the existing rate.</small>
                    </div>
                    <div class="form-group">
                        <label for="num_sessions">Number of Sessions</label>
                        <input type="number" class="form-control" id="num_sessions" name="num_sessions" required min="1" value="1" onchange="calculateFinalRate('')" oninput="calculateFinalRate('')">
                    </div>
                    <div class="form-group">
                        <label for="rate_per_session">Rate Per Session (₹)</label>
                        <input type="number" class="form-control" id="rate_per_session" name="rate_per_session" required min="0" step="100" onchange="calculateFinalRate('')" oninput="calculateFinalRate('')">
                    </div>
                    <div class="form-group">
                        <label for="final_rate">Final Rate (₹)</label>
                        <input type="number" class="form-control" id="final_rate" name="final_rate" readonly style="background-color: #f8f9fa;">
                        <small class="form-text text-muted">Automatically calculated: Number of Sessions × Rate Per Session</small>
                    </div>
                    <div class="form-group">
                        <label>Features</label>
                        <div id="featuresContainer">
                            <div class="feature-item d-flex align-items-center mb-2">
                                <input type="text" name="features[]" class="form-control feature-input me-2" placeholder="Enter feature" style="margin-right: 8px;">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 32px;">×</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary add-feature" onclick="addFeature()">+ Add Feature</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="addRateSubmitBtn" class="btn btn-primary">Add Rate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Rate Modal -->
<div class="modal fade" id="editRateModal" tabindex="-1" role="dialog" aria-labelledby="editRateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRateModalLabel">Edit Rate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editRateForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_session_type">Session Type</label>
                        <select class="form-control" id="edit_session_type" name="session_type" required>
                            <option value="One Time">One Time</option>
                            <option value="Monthly">Monthly</option>
                            <option value="Quarterly">Quarterly</option>
                            <option value="Free Hand">Free Hand</option>
                        </select>
                        <small id="edit_sessionWarning" class="text-danger" style="display:none;">A rate with this session type already exists. Please choose another type or edit the existing rate.</small>
                    </div>
                    <div class="form-group">
                        <label for="edit_num_sessions">Number of Sessions</label>
                        <input type="number" class="form-control" id="edit_num_sessions" name="num_sessions" required min="1" onchange="calculateFinalRate('edit_')" oninput="calculateFinalRate('edit_')">
                    </div>
                    <div class="form-group">
                        <label for="edit_rate_per_session">Rate Per Session (₹)</label>
                        <input type="number" class="form-control" id="edit_rate_per_session" name="rate_per_session" required min="0" step="100" onchange="calculateFinalRate('edit_')" oninput="calculateFinalRate('edit_')">
                    </div>
                    <div class="form-group">
                        <label for="edit_final_rate">Final Rate (₹)</label>
                        <input type="number" class="form-control" id="edit_final_rate" name="final_rate" readonly style="background-color: #f8f9fa;">
                        <small class="form-text text-muted">Automatically calculated: Number of Sessions × Rate Per Session</small>
                    </div>
                    <div class="form-group">
                        <label>Features</label>
                        <div id="editFeaturesContainer">
                            <!-- Dynamic features will be inserted here -->
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary add-edit-feature" onclick="addEditFeature()">+ Add Feature</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" id="editRateSubmitBtn" class="btn btn-primary">Update Rate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Feature management functions
function addFeature() {
    const container = document.getElementById('featuresContainer');
    const newFeature = document.createElement('div');
    newFeature.className = 'feature-item d-flex align-items-center mb-2';
    newFeature.innerHTML = `
        <input type="text" name="features[]" class="form-control feature-input me-2" placeholder="Enter feature" style="margin-right: 8px;">
        <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 36px; height: 36px;">×</button>
    `;
    container.insertBefore(newFeature, container.querySelector('.add-feature'));
}

function addEditFeature() {
    const container = document.getElementById('editFeaturesContainer');
    const newFeature = document.createElement('div');
    newFeature.className = 'feature-item d-flex align-items-center mb-2';
    newFeature.innerHTML = `
        <input type="text" name="features[]" class="form-control feature-input me-2" placeholder="Enter feature" style="margin-right: 8px;">
        <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 36px; height: 36px;">×</button>
    `;
    container.appendChild(newFeature);
}

function removeFeature(button) {
    const featureItem = button.closest('.feature-item');
    const container = featureItem.closest('div');
    const featureItems = container.querySelectorAll('.feature-item');
    
    // Don't allow removing the last feature input
    if (featureItems.length > 1) {
        featureItem.remove();
    } else {
        // Just clear the input instead of removing it
        featureItem.querySelector('.feature-input').value = '';
    }
}

// Calculate final rate
function calculateFinalRate(formPrefix = '') {
    const numSessionsEl = document.getElementById(formPrefix + 'num_sessions');
    const ratePerSessionEl = document.getElementById(formPrefix + 'rate_per_session');
    const finalRateEl = document.getElementById(formPrefix + 'final_rate');
    
    if (numSessionsEl && ratePerSessionEl && finalRateEl) {
        const numSessions = parseInt(numSessionsEl.value || 0);
        const ratePerSession = parseInt(ratePerSessionEl.value || 0);
        finalRateEl.value = numSessions * ratePerSession;
    }
}

function showAddRateModal() {
    // Reset form
    document.getElementById('addRateModal').querySelector('form').reset();
    document.getElementById('num_sessions').value = '1';
    calculateFinalRate('');
    
    // Reset features
    const featuresContainer = document.getElementById('featuresContainer');
    featuresContainer.innerHTML = `
        <div class="feature-item d-flex align-items-center mb-2">
            <input type="text" name="features[]" class="form-control feature-input me-2" placeholder="Enter feature" style="margin-right: 8px;">
            <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 36px; height: 36px;">×</button>
        </div>
    `;
    
    $('#addRateModal').modal('show');
    // validate initial session type state
    setTimeout(validateAddSessionType, 10);
}

function editRate(rateId) {
    // Find the rate data
    const rates = @json($rates);
    const rate = rates.find(r => r.id === rateId);
    
    if (rate) {
        // Set form values with correct field names
        $('#edit_session_type').val(rate.session_type || '');
        $('#edit_num_sessions').val(rate.num_sessions || 1);
        $('#edit_rate_per_session').val(rate.rate_per_session || '');
        $('#edit_final_rate').val(rate.final_rate || '');
        
    // Calculate final rate to ensure it's displayed correctly
    calculateFinalRate('edit_');
        
        // Clear existing features
        const editFeaturesContainer = document.getElementById('editFeaturesContainer');
        editFeaturesContainer.innerHTML = '';
        
        // Add existing features
        if (rate.features && rate.features.length > 0) {
            rate.features.forEach(feature => {
                if (feature && feature.trim()) {
                    const featureDiv = document.createElement('div');
                    featureDiv.className = 'feature-item d-flex align-items-center mb-2';
                    featureDiv.innerHTML = `
                        <input type="text" name="features[]" class="form-control feature-input me-2" placeholder="Enter feature" value="${feature.trim()}" style="margin-right: 8px;">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 36px; height: 36px;">×</button>
                    `;
                    editFeaturesContainer.appendChild(featureDiv);
                }
            });
        }
        
        // Add empty feature if none exist
        if (editFeaturesContainer.children.length === 0) {
            addEditFeature();
        }
        
        // Set form action
        $('#editRateForm').attr('action', '{{ route('admin.professional.rates.update', ['professional' => $professional->id, 'rate' => '__RATE_ID__']) }}'.replace('__RATE_ID__', rateId));
        // mark the edit session select with excluding id so validation allows current type
        const editSel = document.getElementById('edit_session_type');
        if (editSel) {
            editSel.setAttribute('data-excluding-id', rateId);
        }
        validateEditSessionType(rateId);
        $('#editRateModal').modal('show');
    }
}

function deleteRate(rateId) {
    if (confirm('Are you sure you want to delete this rate?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('admin.professional.rates.delete', ['professional' => $professional->id, 'rate' => '__RATE_ID__']) }}'.replace('__RATE_ID__', rateId);
        
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

// Prevent duplicate session types
function sessionTypeExists(sessionType, excludingRateId = null) {
    if (!sessionType) return false;
    const rates = @json($rates);
    return rates.some(r => {
        if (!r.session_type) return false;
        if (excludingRateId && r.id === excludingRateId) return false;
        return r.session_type.toString().toLowerCase() === sessionType.toString().toLowerCase();
    });
}

function validateAddSessionType() {
    const sel = document.getElementById('session_type');
    const warning = document.getElementById('sessionWarning');
    const submitBtn = document.getElementById('addRateSubmitBtn');
    if (!sel || !warning || !submitBtn) return;
    const val = sel.value;
    if (sessionTypeExists(val)) {
        warning.style.display = 'block';
        submitBtn.disabled = true;
    } else {
        warning.style.display = 'none';
        submitBtn.disabled = false;
    }
}

function validateEditSessionType(excludingRateId) {
    const sel = document.getElementById('edit_session_type');
    const warning = document.getElementById('edit_sessionWarning');
    const submitBtn = document.getElementById('editRateSubmitBtn');
    if (!sel || !warning || !submitBtn) return;
    const val = sel.value;
    if (sessionTypeExists(val, excludingRateId)) {
        warning.style.display = 'block';
        submitBtn.disabled = true;
    } else {
        warning.style.display = 'none';
        submitBtn.disabled = false;
    }
}

// Add event listeners for calculation
document.addEventListener('DOMContentLoaded', function() {
    // Initial calculation on page load
    calculateFinalRate('');
    calculateFinalRate('edit_');
    
    // Handle modal close events
    $('.modal').on('hidden.bs.modal', function() {
        const modalId = $(this).attr('id');
        
        if (modalId === 'addRateModal') {
            // Reset add form
            $(this).find('form')[0].reset();
            document.getElementById('num_sessions').value = '1';
            calculateFinalRate('');
            
            // Reset features container
            const featuresContainer = document.getElementById('featuresContainer');
            featuresContainer.innerHTML = `
                <div class="feature-item d-flex align-items-center mb-2">
                    <input type="text" name="features[]" class="form-control feature-input me-2" placeholder="Enter feature" style="margin-right: 8px;">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 36px; height: 36px;">×</button>
                </div>
            `;
            // Clear any session warnings and re-enable submit
            const addWarn = document.getElementById('sessionWarning');
            const addBtn = document.getElementById('addRateSubmitBtn');
            if (addWarn) addWarn.style.display = 'none';
            if (addBtn) addBtn.disabled = false;
        } else if (modalId === 'editRateModal') {
            // Reset edit form
            $(this).find('form')[0].reset();
            calculateFinalRate('edit_');
            
            // Reset edit features container
            const editFeaturesContainer = document.getElementById('editFeaturesContainer');
            editFeaturesContainer.innerHTML = `
                <div class="feature-item d-flex align-items-center mb-2">
                    <input type="text" name="features[]" class="form-control feature-input me-2" placeholder="Enter feature" style="margin-right: 8px;">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 36px; height: 36px;">×</button>
                </div>
            `;
            // Clear any edit session warnings and re-enable submit
            const editWarn = document.getElementById('edit_sessionWarning');
            const editBtn = document.getElementById('editRateSubmitBtn');
            if (editWarn) editWarn.style.display = 'none';
            if (editBtn) editBtn.disabled = false;
        }
    });
    
    // Handle close button clicks - prevent event bubbling
    $('.modal .close, .modal [data-dismiss="modal"], .modal .btn-secondary').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).closest('.modal').modal('hide');
    });

    // Handle modal backdrop clicks
    $('.modal').on('click', function(e) {
        if (e.target === this) {
            $(this).modal('hide');
        }
    });

    // Prevent modal from closing when clicking inside modal content
    $('.modal-content').on('click', function(e) {
        e.stopPropagation();
    });

    // Hook validation for add modal session type
    const addSessionSel = document.getElementById('session_type');
    if (addSessionSel) {
        addSessionSel.addEventListener('change', validateAddSessionType);
        addSessionSel.addEventListener('input', validateAddSessionType);
    }

    // Hook validation for edit modal; note edit modal calls validate in editRate()
    const editSessionSel = document.getElementById('edit_session_type');
    if (editSessionSel) {
        editSessionSel.addEventListener('change', function() {
            // excluding id will be set when edit modal opens (data attribute)
            const excluding = parseInt(editSessionSel.getAttribute('data-excluding-id')) || null;
            validateEditSessionType(excluding);
        });
        editSessionSel.addEventListener('input', function() {
            const excluding = parseInt(editSessionSel.getAttribute('data-excluding-id')) || null;
            validateEditSessionType(excluding);
        });
    }
});
</script>
@endsection