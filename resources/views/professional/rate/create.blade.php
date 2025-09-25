@extends('professional.layout.layout')

@section('style')
<!-- Add your custom styles here -->
@endsection

@section('content')
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <h3>Add Rate</h3>
            </div>
            <ul class="breadcrumb">
                <li>Home</li>
                <li class="active">Add Rate</li>
            </ul>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <form id="rateForm">
                @csrf
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Session Type</th>
                                <th>No. of Sessions</th>
                                <th>Rate Per Session (₹)</th>
                                <th>Final Rate (₹)</th>
                                <th>Features</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Initially empty -->
                        </tbody>
                    </table>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" id="addRateBtn">
                        <i class="fas fa-plus"></i> Add New Rate
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Rates
                    </button>
                </div>
            </form>
        </div>
    </div>
    
<style>
    @media screen and (max-width: 767px) {
    /* Fix header to prevent horizontal scrolling */
    .page-header {
        position: sticky;
        top: 0;
        z-index: 10;
        background-color: #f8f9fa;
        padding-top: 10px;
        padding-bottom: 10px;
        width: 100%;
        max-width: 100vw;
        overflow-x: hidden;
    }
    
    /* Make table container scrollable horizontally */
    .table-wrapper {
        overflow-x: auto;
        max-width: 100%;
        -webkit-overflow-scrolling: touch; /* Better scrolling on iOS */
    }
    
    /* Ensure the table takes full width of container */
    .data-table {
        width: 100%;
        table-layout: auto;
    }
    
    /* Fix the search container from overflowing */
    .search-container {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure content wrapper doesn't cause horizontal scroll */
    .content-wrapper {
        overflow-x: hidden;
        width: 100%;
        max-width: 100vw;
        padding: 20px 10px;
    }
    
    /* Fix card width */
    .card {
        width: 100%;
        overflow-x: hidden;
    }
    
    /* Ensure the card body doesn't cause overflow */
    .card-body {
        padding: 10px 5px;
    }
    
    /* Optional: Make some table columns width-responsive */
    .data-table th,
    .data-table td {
        white-space: nowrap;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sessionTypes = ['One Time', 'Monthly', 'Quarterly', 'Free Hand']; 
    let selectedSessionTypes = [];
    
    // Fetch existing session types first to prevent duplicates
    function fetchExistingSessionTypes() {
        return new Promise((resolve, reject) => {
            // Make an AJAX call to get existing session types for this professional
            $.ajax({
                url: "{{ route('professional.rate.get-session-types') }}",
                type: "GET",
                success: function(response) {
                    if (response.status === 'success') {
                        selectedSessionTypes = response.session_types || [];
                        resolve(selectedSessionTypes);
                    } else {
                        toastr.error("Failed to load existing session types.");
                        reject([]);
                    }
                },
                error: function() {
                    toastr.error("Error checking existing session types. Please refresh the page.");
                    reject([]);
                }
            });
        });
    }
    
    // Improved function to update dropdown options
    function updateDropdownOptions() {
        // Get currently selected session types from all dropdowns
        const currentSelections = [];
        document.querySelectorAll('.session-type').forEach(select => {
            const value = select.value;
            if (value && !currentSelections.includes(value)) {
                currentSelections.push(value);
            }
        });
        
        // Update all dropdowns to disable already selected options
        document.querySelectorAll('.session-type').forEach(select => {
            const currentValue = select.value;
            
            // Reset all options first
            select.querySelectorAll('option').forEach(option => {
                if (option.value) { // Skip the empty/placeholder option
                    const isSelected = currentSelections.includes(option.value);
                    const isExisting = selectedSessionTypes.includes(option.value);
                    
                    // Disable if selected elsewhere or already exists in database
                    option.disabled = (isSelected && option.value !== currentValue) || isExisting;
                    
                    if (isExisting && option.value !== currentValue) {
                        option.textContent = `${option.value} (Already Added)`;
                        option.style.color = '#999';
                    }
                }
            });
        });
    }

    function calculateFinalRate(row) {
        const numSessions = parseInt(row.querySelector('td:nth-child(2) input').value) || 0;
        const ratePerSession = parseInt(row.querySelector('td:nth-child(3) input').value) || 0;
        const finalRateInput = row.querySelector('td:nth-child(4) input');
        finalRateInput.value = numSessions * ratePerSession;
    }

    // Fetch existing types before initializing the form
    fetchExistingSessionTypes().then(() => {
        // Check if all types are already used
        const availableTypes = sessionTypes.filter(type => !selectedSessionTypes.includes(type));
        if (availableTypes.length === 0) {
            document.getElementById('addRateBtn').disabled = true;
            document.getElementById('addRateBtn').innerHTML = 'All session types already added';
            toastr.info('You have already added all available session types.');
        } else {
            // Enable adding new rates
            document.getElementById('addRateBtn').addEventListener('click', function() {
                // Check if all 4 session types are already used
                if (selectedSessionTypes.length >= 4) {
                    toastr.error('You can only add up to 4 different session types.');
                    return;
                }
                
                // Check if there are any session types left to add
                const currentSelections = Array.from(document.querySelectorAll('.session-type'))
                    .map(select => select.value)
                    .filter(value => value);
                    
                const availableTypes = sessionTypes.filter(type => 
                    !selectedSessionTypes.includes(type) && !currentSelections.includes(type));
                    
                if (availableTypes.length === 0) {
                    toastr.error('All session types have already been added or selected.');
                    return;
                }

                const tbody = document.querySelector('.table tbody');
                const newRow = document.createElement('tr');
                
                // Create dropdown with properly disabled options
                let optionsHTML = '<option value="">Select Session Type</option>';
                sessionTypes.forEach(type => {
                    const isDisabled = selectedSessionTypes.includes(type) || currentSelections.includes(type);
                    const disabledAttr = isDisabled ? 'disabled' : '';
                    const label = selectedSessionTypes.includes(type) ? 
                        `${type} (Already Added)` : type;
                    const style = selectedSessionTypes.includes(type) ? 
                        'style="color: #999;"' : '';
                    
                    optionsHTML += `<option value="${type}" ${disabledAttr} ${style}>${label}</option>`;
                });
                
                newRow.innerHTML = `
                    <td>
                        <select class="form-control session-type" required>
                            ${optionsHTML}
                        </select>
                    </td>
                    <td><input type="number" class="form-control" value="1" min="1" required></td>
                    <td><input type="number" class="form-control" value="0" min="0" step="100" required></td>
                    <td><input type="number" class="form-control final-rate" name="final_rate[]" readonly></td>
                    <td>
                        <div class="features-container">
                            <div class="feature-item d-flex align-items-center mb-2">
                                <input type="text" class="form-control feature-input me-2" placeholder="Enter feature" style="margin-right: 8px;">
                                <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 32px;">×</button>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-primary add-feature" onclick="addFeature(this)">+ Add Feature</button>
                        </div>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(newRow);

                const numSessionsInput = newRow.querySelector('td:nth-child(2) input');
                const ratePerSessionInput = newRow.querySelector('td:nth-child(3) input');
                const sessionTypeSelect = newRow.querySelector('.session-type');
                
                // Add event listeners to calculate final rate when inputs change
                numSessionsInput.addEventListener('input', function() {
                    calculateFinalRate(newRow);
                });
                ratePerSessionInput.addEventListener('input', function() {
                    calculateFinalRate(newRow);
                });

                // Handle session type change
                sessionTypeSelect.addEventListener('change', function() {
                    updateDropdownOptions();
                    calculateFinalRate(newRow);
                });

                // Initialize final rate calculation
                calculateFinalRate(newRow);
                updateDropdownOptions();
            });
        }
    });

    // Row deletion with improved handling of selected session types
    document.querySelector('.table tbody').addEventListener('click', function(e) {
        if (e.target && (e.target.classList.contains('delete-row') || e.target.closest('.delete-row') || e.target.closest('.action-btn'))) {
            const rowToDelete = e.target.closest('tr');
            rowToDelete.remove();
            
            // Update dropdown options after deletion
            updateDropdownOptions();
        }
    });

    // Submit form via AJAX with validation
    document.getElementById('rateForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Check if at least one rate has been added
        const rows = document.querySelectorAll('.table tbody tr');
        if (rows.length === 0) {
            toastr.error('Please add at least one rate.');
            return;
        }
        
        // Validate all inputs before submission
        let isValid = true;
        rows.forEach(row => {
            const sessionType = row.querySelector('.session-type').value;
            const numSessions = row.querySelector('td:nth-child(2) input').value;
            const ratePerSession = row.querySelector('td:nth-child(3) input').value;
            
            if (!sessionType || !numSessions || !ratePerSession) {
                isValid = false;
            }
        });
        
        if (!isValid) {
            toastr.error('Please fill in all required fields.');
            return;
        }

        let rateData = [];
        rows.forEach(row => {
            let sessionType = row.querySelector('td:nth-child(1) select').value;
            let numSessions = parseInt(row.querySelector('td:nth-child(2) input').value) || 0;
            let ratePerSession = parseInt(row.querySelector('td:nth-child(3) input').value) || 0;
            let finalRate = parseFloat(row.querySelector('td:nth-child(4) input').value) || 0;
            
            // Collect features
            let features = [];
            const featureInputs = row.querySelectorAll('.feature-input');
            featureInputs.forEach(input => {
                if (input.value.trim()) {
                    features.push(input.value.trim());
                }
            });

            rateData.push({
                session_type: sessionType,
                num_sessions: numSessions,
                rate_per_session: ratePerSession,
                final_rate: finalRate,
                features: features,
            });
        });

        // Check for duplicate session types before submission
        const sessionTypeSet = new Set(rateData.map(item => item.session_type));
        if (sessionTypeSet.size !== rateData.length) {
            toastr.error('Duplicate session types are not allowed.');
            return;
        }
        
        // Check for session types that already exist in the database
        const submittedTypes = rateData.map(item => item.session_type);
        const alreadyExisting = submittedTypes.filter(type => selectedSessionTypes.includes(type));
        
        if (alreadyExisting.length > 0) {
            toastr.error('You already have rates for: ' + alreadyExisting.join(', '));
            return;
        }

        let postData = {
            professional_id: "{{ Auth::guard('professional')->id() }}", 
            rateData: rateData, 
            _token: $('meta[name="csrf-token"]').attr('content') 
        };

        // Show loading indicator
        const submitBtn = document.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

        // AJAX request
        $.ajax({
            url: "{{ route('professional.rate.store') }}",
            type: "POST",
            data: postData,
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = "{{ route('professional.rate.index') }}";
                    }, 1500);
                } else {
                    toastr.error(response.message || "Something went wrong");
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                }
            },
            error: function(xhr) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
                
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (xhr.responseJSON.message) {
                        toastr.error(xhr.responseJSON.message);
                    } else {
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]);
                        });
                    }
                } else {
                    toastr.error(xhr.responseJSON?.message || "An unexpected error occurred");
                }
            }
        });
    });

    // Feature management functions
    function addFeature(button) {
        const container = button.closest('.features-container');
        const newFeature = document.createElement('div');
        newFeature.className = 'feature-item d-flex align-items-center mb-2';
        newFeature.innerHTML = `
            <input type="text" class="form-control feature-input me-2" placeholder="Enter feature" style="margin-right: 8px;">
            <button type="button" class="btn btn-sm btn-outline-danger remove-feature" onclick="removeFeature(this)" style="min-width: 32px;">×</button>
        `;
        container.insertBefore(newFeature, button);
    }

    function removeFeature(button) {
        const featureItem = button.closest('.feature-item');
        const container = featureItem.closest('.features-container');
        const featureItems = container.querySelectorAll('.feature-item');
        
        // Don't allow removing the last feature input
        if (featureItems.length > 1) {
            featureItem.remove();
        } else {
            // Just clear the input instead of removing it
            featureItem.querySelector('.feature-input').value = '';
        }
    }
    
    // Only add an initial row if there are available session types
    if (sessionTypes.length > selectedSessionTypes.length) {
        setTimeout(() => {
            document.getElementById('addRateBtn').click();
        }, 200);
    }
});
</script>
@endsection
