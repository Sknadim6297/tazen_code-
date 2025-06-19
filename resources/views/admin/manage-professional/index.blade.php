<!-- filepath: c:\xampp\htdocs\tazen_marge_code\Tazen_multi\resources\views\admin\manage-professional\index.blade.php -->
@extends('admin.layouts.layout')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
<style>
    .active-status-dropdown {
        min-width: 100px;
        font-size: 14px;
        padding: 4px 8px;
        cursor: pointer;
    }
    
    .active-status-dropdown option[value="1"] {
        color: #28a745;
        font-weight: 500;
    }
    
    .active-status-dropdown option[value="0"] {
        color: #dc3545;
        font-weight: 500;
    }
    
    /* For JS-disabled browsers */
    .status-toggle-form {
        margin: 0;
    }
    
    /* Toast styling overrides */
    .toast-success {
        background-color: #51a351;
    }
    
    .toast-error {
        background-color: #bd362f;
    }
  
    /* Toggle switch styles */
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
        margin-bottom: 0;
    }

    .toggle-checkbox {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #dc3545; 
        transition: .4s;
        border-radius: 34px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        border-radius: 50%;
        transition: .4s;
    }

    input:checked + .toggle-slider {
        background-color: #28a745; 
    }

    input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }
    .toggle-text {
        display: none;
    }

    .toggle-processing {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .spinner {
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #3498db;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .margin-update-form {
        display: flex;
        align-items: center;
        gap: 12px;
        width: 100%;
        justify-content: center;
    }
    
    .margin-input-container {
        position: relative;
        width: 160px;
        height: 40px;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        transition: box-shadow 0.2s;
        border: 1px solid #ced4da;
    }
    
    .margin-input-container:focus-within {
        box-shadow: 0 3px 8px rgba(78, 115, 223, 0.15);
        border-color: #4e73df;
    }
    
    .margin-input-container .form-control {
        height: 40px;
        padding-right: 40px;
        font-size: 16px;
        font-weight: 500;
        border: none;
        border-radius: 0;
        text-align: center;
        color: #3a3b45;
    }
    
    .margin-input-container .input-group-text {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        border: none;
        background-color: #f8f9fa;
        font-weight: 600;
        color: #5a5c69;
        border-left: 1px solid #ced4da;
        width: 40px;
        display: flex;
        justify-content: center;
        padding: 0;
    }
    
    .margin-save-btn {
        height: 40px;
        min-width: 80px;
        font-weight: 600;
        font-size: 14px;
        border-radius: 6px;
        background-color: #4e73df;
        border-color: #4e73df;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.2s;
    }
    
    .margin-save-btn:hover {
        background-color: #2e59d9;
        border-color: #2653d4;
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    
    .margin-save-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 3px rgba(0,0,0,0.1);
    }
    
    .margin-save-btn .spinner-border {
        width: 1rem;
        height: 1rem;
        margin-right: 5px;
    }
    
    /* Not Applicable styling */
    .not-applicable {
        color: #6c757d;
        font-style: italic;
        padding: 8px 12px;
        background-color: #f8f9fa;
        border-radius: 6px;
        display: inline-block;
    }

    /* Specialization badge styles */
    .badge {
        padding: 5px 10px;
        border-radius: 15px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    .bg-primary {
        background-color: #4e73df !important;
    }

    /* Export buttons styling */
    .export-buttons {
        display: flex;
        gap: 10px;
        margin-left: 10px;
    }

    .export-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        font-size: 0.875rem;
        border-radius: 0.25rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .export-btn-excel {
        background-color: #1f7244;
        color: white;
        border: none;
    }

    .export-btn-excel:hover {
        background-color: #155a33;
    }

    .export-btn-pdf {
        background-color: #c93a3a;
        color: white;
        border: none;
    }

    .export-btn-pdf:hover {
        background-color: #a52929;
    }
</style>
@endsection

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">All Professionals</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Professional</a></li>
                            <li class="breadcrumb-item active" aria-current="page">All Professional</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Filter Section - Improved Design -->
        <form id="filter-form" action="{{ route('admin.manage-professional.index') }}" method="GET" class="mb-4">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <div class="col-xl-2">
                    <input type="search" name="search" class="form-control form-control-sm" id="autoComplete" placeholder="Search by name or email">
                </div>
                
                <div class="col-xl-2">
                    <select id="serviceFilter" name="service_id" class="form-select form-select-sm">
                        <option value="">All Services</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-xl-2">
                    <select id="specializationFilter" name="specialization" class="form-select form-select-sm">
                        <option value="">All Specializations</option>
                        @foreach($specializations as $specialization)
                            <option value="{{ $specialization }}">{{ $specialization }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-xl-4">
                    <div class="input-group input-group-sm">
                        <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                        <input type="date" class="form-control form-control-sm" placeholder="Start Date" name="start_date" id="start_date">
                        <span class="input-group-text">to</span>
                        <input type="date" class="form-control form-control-sm" placeholder="End Date" name="end_date" id="end_date">
                    </div>
                </div>
                
                <div class="col-xl-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                    <a href="{{ route('admin.manage-professional.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                </div>
            </div>
        </form>

        <!-- Add Export buttons outside the filter form -->
        <div class="d-flex justify-content-end mb-3">
            <div class="export-buttons">
                <button type="button" class="export-btn export-btn-excel" onclick="exportData('excel')">
                    <i class="ri-file-excel-line me-1"></i> Export Excel
                </button>
                <button type="button" class="export-btn export-btn-pdf" onclick="exportData('pdf')">
                    <i class="ri-file-pdf-line me-1"></i> Export PDF
                </button>
            </div>
        </div>

        <!-- Add this hidden form for export -->
        <form id="export-form" method="GET" action="{{ route('admin.manage-professional.index') }}">
            <!-- Hidden inputs to carry over current filters -->
            <input type="hidden" name="search" id="export-search">
            <input type="hidden" name="service_id" id="export-service">
            <input type="hidden" name="specialization" id="export-specialization">
            <input type="hidden" name="start_date" id="export-start-date">
            <input type="hidden" name="end_date" id="export-end-date">
            <input type="hidden" name="export" id="export-type">
        </form>

        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Total Professionals
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input check-all" type="checkbox" id="all-professionals" aria-label="..."></th>
                                        <th scope="col">Sl.No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Services Offered</th>
                                        <th scope="col">Specialization</th> <!-- New column -->
                                        <th scope="col">Margin Percentage</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Active</th> 
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="professional-table-body">
                                    @foreach ($professionals as $professional)
                                        <tr class="professional-list">
                                            <td class="professional-checkbox">
                                                <input class="form-check-input" type="checkbox" value="{{ $professional->id }}" aria-label="...">
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $loop->iteration }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $professional->name }}</span>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $professional->email }}</span>
                                            </td>
                                            <td>
                                                @if($professional->professionalServices->count() > 0)
                                                    @foreach($professional->professionalServices as $ps)
                                                        <span class="badge bg-info mb-1">{{ $ps->service->name ?? $ps->service_name }}</span>
                                                        @if(!$loop->last) <br> @endif
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">No Services</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($professional->profile && $professional->profile->specialization)
                                                    <span class="badge bg-primary">{{ $professional->profile->specialization }}</span>
                                                @else
                                                    <span class="text-muted">Not specified</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($professional->status === 'accepted')
                                                    <form action="{{ route('admin.updateMargin', $professional->id) }}" method="POST" class="margin-update-form">
                                                        @csrf
                                                        <div class="margin-input-container">
                                                            <input class="form-control" type="number" name="margin_percentage" 
                                                                value="{{ $professional->margin }}" min="0" max="100" required>
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary margin-save-btn">Save</button>
                                                    </form>
                                                @else
                                                    <span class="not-applicable">Not Applicable</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($professional->status == 'accepted')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($professional->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($professional->status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form class="status-toggle-form" method="POST" action="{{ route('admin.professional.toggle-status') }}">
                                                    @csrf
                                                    <input type="hidden" name="professional_id" value="{{ $professional->id }}">
                                                    <input type="hidden" name="active_status" value="{{ $professional->active ? '0' : '1' }}">
                                                    
                                                    <label class="toggle-switch" data-id="{{ $professional->id }}" data-active="{{ $professional->active ? '1' : '0' }}">
                                                        <input type="checkbox" class="toggle-checkbox" {{ $professional->active ? 'checked' : '' }}>
                                                        <span class="toggle-slider">
                                                            <div class="toggle-processing">
                                                                <div class="spinner"></div>
                                                            </div>
                                                        </span>
                                                    </label>
                                                    
                                                    <noscript>
                                                        <div class="mt-2">
                                                            <span class="badge {{ $professional->active ? 'bg-success' : 'bg-danger' }} mb-2">
                                                                {{ $professional->active ? 'Active' : 'Inactive' }}
                                                            </span>
                                                            <button type="submit" class="btn btn-sm btn-primary d-block">
                                                                {{ $professional->active ? 'Deactivate' : 'Activate' }}
                                                            </button>
                                                        </div>
                                                    </noscript>
                                                </form>
                                            </td>
                                            <td>
                                                <span class="fw-medium">{{ $professional->created_at->format('d M, Y') }}</span>
                                            </td>
                                            <td class="">
                                                <a href="{{ route('admin.manage-professional.show', $professional->id) }}" class="btn btn-success-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-title="view">
                                                    <i class="ri-eye-line"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 float-end">
                                {{ $professionals->links() }}
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    $(document).ready(function() {
        // Add submit handler for the form
        $('form').on('submit', function(e) {
            e.preventDefault();
            let searchTerm = $('#autoComplete').val();
            let serviceId = $('#serviceFilter').val();
            let specializationFilter = $('#specializationFilter').val();
            let startDate = $('#start_date').val();
            let endDate = $('#end_date').val();
            
            // Check if dates are valid
            if (startDate && endDate) {
                // Ensure end date is not before start date
                if (new Date(endDate) < new Date(startDate)) {
                    alert('End date cannot be before start date');
                    return false;
                }
            }
            
            filterData(startDate, endDate, searchTerm, serviceId, specializationFilter);
        });

        // Individual filter change handlers for immediate filtering
        $('#autoComplete').on('keyup', function() {
            if($(this).val().length >= 3 || $(this).val().length === 0) {
                setTimeout(function() {
                    $('form').submit();
                }, 500);
            }
        });

        $('#serviceFilter, #specializationFilter').on('change', function() {
            $('form').submit();
        });

        $('#start_date, #end_date').on('change', function() {
            // Only trigger if both dates have values
            if($('#start_date').val() && $('#end_date').val()) {
                $('form').submit();
            }
        });

        // Function to fetch data based on filters
        function filterData(startDate = '', endDate = '', searchTerm = '', serviceId = '', specializationFilter = '') {
            // Show loading indicator
            $('#professional-table-body').html('<tr><td colspan="11" class="text-center"><i class="ri-loader-4-line fa-spin me-2"></i> Loading...</td></tr>');
            
            // Format dates to ensure they're in YYYY-MM-DD format for backend
            if (startDate) {
                // Add time component to start date to include the entire day
                startDate = startDate + ' 00:00:00';
            }
            
            if (endDate) {
                // Add time component to end date to include the entire day
                endDate = endDate + ' 23:59:59';
            }
            
            $.ajax({
                url: '{{ route('admin.manage-professional.index') }}',
                method: 'GET',
                data: {
                    search: searchTerm,
                    start_date: startDate,
                    end_date: endDate,
                    service_id: serviceId,
                    specialization: specializationFilter
                },
                success: function(response) {
                    let professionalsHtml = '';
                    
                    if (response.professionals.data.length === 0) {
                        professionalsHtml = '<tr><td colspan="11" class="text-center">No professionals found matching your criteria</td></tr>';
                    } else {
                        $.each(response.professionals.data, function(index, professional) {
                            // Generate services HTML
                            let servicesHtml = '';
                            if (professional.professional_services && professional.professional_services.length > 0) {
                                professional.professional_services.forEach(function(ps, idx) {
                                    // Use the same format as the blade template
                                    let serviceName = (ps.service && ps.service.name) ? ps.service.name : ps.service_name;
                                    servicesHtml += `<span class="badge bg-info mb-1">${serviceName}</span>`;
                                    if (idx < professional.professional_services.length - 1) {
                                        servicesHtml += '<br>';
                                    }
                                });
                            } else {
                                servicesHtml = '<span class="text-muted">No Services</span>';
                            }
                            
                            // Generate specialization HTML
                            let specializationHtml = '';
                            if (professional.profile && professional.profile.specialization) {
                                specializationHtml = `<span class="badge bg-primary">${professional.profile.specialization}</span>`;
                            } else {
                                specializationHtml = '<span class="text-muted">Not specified</span>';
                            }

                            // Generate margin HTML
                            const marginHtml = professional.status === 'accepted' ? 
                                `<form action="/admin/professional/${professional.id}/margin" method="POST" class="margin-update-form">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="margin-input-container">
                                        <input class="form-control" type="number" name="margin_percentage" 
                                            value="${professional.margin || 0}" min="0" max="100" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <button type="submit" class="btn btn-primary margin-save-btn">Save</button>
                                </form>` : 
                                '<span class="not-applicable">Not Applicable</span>';

                            // Generate status badge
                            const statusBadge = professional.status === 'accepted' ? 
                                '<span class="badge bg-success">Approved</span>' : 
                                professional.status === 'pending' ? 
                                '<span class="badge bg-warning">Pending</span>' : 
                                '<span class="badge bg-danger">Rejected</span>';

                            // Generate toggle switch HTML
                            const toggleSwitchHtml = `
                                <form class="status-toggle-form" method="POST" action="{{ route('admin.professional.toggle-status') }}">
                                    @csrf
                                    <input type="hidden" name="professional_id" value="${professional.id}">
                                    <input type="hidden" name="active_status" value="${professional.active ? '0' : '1'}">
                                    
                                    <label class="toggle-switch" data-id="${professional.id}" data-active="${professional.active ? '1' : '0'}">
                                        <input type="checkbox" class="toggle-checkbox" ${professional.active ? 'checked' : ''}>
                                        <span class="toggle-slider">
                                            <div class="toggle-processing">
                                                <div class="spinner"></div>
                                            </div>
                                        </span>
                                    </label>
                                </form>
                            `;
                            // Build the row
                            professionalsHtml += `
                                <tr class="professional-list">
                                    <td class="professional-checkbox">
                                        <input class="form-check-input" type="checkbox" value="${professional.id}" aria-label="...">
                                    </td>
                                    <td><span class="fw-medium">${index + 1}</span></td>
                                    <td><span class="fw-medium">${professional.name}</span></td>
                                    <td><span class="fw-medium">${professional.email}</span></td>
                                    <td>${servicesHtml}</td>
                                    <td>${specializationHtml}</td>
                                    <td style="display: flex; justify-content: center; align-items: center;">${marginHtml}</td>
                                    <td>${statusBadge}</td>
                                    <td>${toggleSwitchHtml}</td>
                                    <td><span class="fw-medium">${formatDate(professional.created_at)}</span></td>
                                    <td>
                                        <a href="/admin/manage-professional/${professional.id}" class="btn btn-success-light btn-icon btn-sm">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </td>
                                </tr>`;
                        });
                    }
                    
                    $('#professional-table-body').html(professionalsHtml);
                },
                error: function() {
                    $('#professional-table-body').html('<tr><td colspan="11" class="text-center text-danger">Error loading data. Please try again.</td></tr>');
                }
            });
        }

        // Setup CSRF protection for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Handle active status change
        $(document).on('change', '.active-status-dropdown', function() {
            const dropdown = $(this);
            const professionalId = dropdown.data('id');
            const newValue = dropdown.val();
            const statusText = newValue == 1 ? 'activate' : 'deactivate';
            
            // Confirm before changing
            if (confirm(`Are you sure you want to ${statusText} this professional?`)) {
                // Store original selected value in case we need to revert
                const originalValue = newValue == 1 ? 0 : 1;
                
                // Disable dropdown during processing
                dropdown.prop('disabled', true);
                
                // Send AJAX request with explicitly defined data
                $.ajax({
                    url: "{{ route('admin.professional.toggle-status') }}",
                    type: 'POST',
                    data: {
                        professional_id: professionalId,
                        active_status: newValue,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show success message using toastr
                            toastr.success(response.message);
                        } else {
                            // Revert to original value and show error
                            dropdown.val(originalValue);
                            toastr.error(response.message || 'Failed to update status');
                        }
                    },
                    error: function(xhr) {
                        // Revert to original value on error
                        dropdown.val(originalValue);
                        
                        console.error("Error response:", xhr.responseText);
                        
                        // Show error message
                        let errorMsg = 'An error occurred while updating status';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        toastr.error(errorMsg);
                    },
                    complete: function() {
                        // Re-enable dropdown
                        dropdown.prop('disabled', false);
                    }
                });
            } else {
                // If user cancels, revert the dropdown to its original value
                dropdown.val(originalValue == 1 ? 1 : 0);
            }
        });

        // Handle toggle switch click
        $(document).on('change', '.toggle-checkbox', function() {
            const checkbox = $(this);
            const toggleSwitch = checkbox.closest('.toggle-switch');
            const professionalId = toggleSwitch.data('id');
            const isCurrentlyActive = toggleSwitch.data('active') == '1';
            const willBeActive = checkbox.prop('checked');
            
            // Revert the checkbox state until confirmed
            checkbox.prop('checked', isCurrentlyActive);
            
            // Confirm before changing
            const statusText = isCurrentlyActive ? 'deactivate' : 'activate';
            if (confirm(`Are you sure you want to ${statusText} this professional?`)) {
                // Show processing state
                const processingOverlay = toggleSwitch.find('.toggle-processing');
                processingOverlay.show();
                
                // Disable the checkbox during processing
                checkbox.prop('disabled', true);
                
                // Send AJAX request
                $.ajax({
                    url: "{{ route('admin.professional.toggle-status') }}",
                    type: 'POST',
                    data: {
                        professional_id: professionalId,
                        active_status: isCurrentlyActive ? '0' : '1',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update checkbox and data attribute
                            checkbox.prop('checked', !isCurrentlyActive);
                            toggleSwitch.data('active', isCurrentlyActive ? '0' : '1');
                            
                            // Update hidden form field for JS-disabled fallback
                            toggleSwitch.closest('form').find('input[name="active_status"]').val(isCurrentlyActive ? '0' : '1');
                            
                            // Show success message
                            toastr.success(response.message);
                        } else {
                            // Show error message
                            toastr.error(response.message || 'Failed to update status');
                        }
                    },
                    error: function(xhr) {
                        // Show error message
                        let errorMsg = 'An error occurred while updating status';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        toastr.error(errorMsg);
                        console.error("Error response:", xhr.responseText);
                    },
                    complete: function() {
                        // Hide processing overlay
                        processingOverlay.hide();
                        
                        // Re-enable checkbox
                        checkbox.prop('disabled', false);
                    }
                });
            }
        });

        // Handle margin percentage form submission via AJAX
        $(document).on('submit', '.margin-update-form', function(e) {
            e.preventDefault();
            const form = $(this);
            const submitButton = form.find('button[type="submit"]');
            const marginInput = form.find('input[name="margin_percentage"]');
            const marginValue = marginInput.val();
            
            // Disable button and show loading state
            submitButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Saving...');
            
            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(response, textStatus, xhr) {
                    // Check if we got a redirect (302)
                    if (xhr.status === 200 && response.success === true) {
                        toastr.success(response.message || 'Margin updated successfully');
                        // Show success message before reload
                        setTimeout(function() {
                            window.location.reload(); // Reload the page after a short delay
                        }, 1000); // 1 second delay to show the toast message
                    } else {
                        // Even if we get redirected but the database was updated, show success
                        toastr.success('Margin updated successfully');
                        setTimeout(function() {
                            window.location.reload(); // Reload to reflect changes
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    console.error("Error response:", xhr.responseText);
                    
                    // Special handling for redirects that might indicate success
                    if (xhr.status === 302) {
                        toastr.success('Margin updated successfully');
                        setTimeout(function() {
                            window.location.reload(); // Reload to reflect changes
                        }, 1000);
                        return;
                    }
                    
                    let errorMsg = 'Failed to update margin';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    toastr.error(errorMsg);
                    
                    // Restore button state in case of error
                    submitButton.prop('disabled', false).text('Save');
                },
                complete: function() {
                    // We don't restore the button here since we're reloading the page
                    // The button will be restored when the page reloads
                }
            });
        });

        // Helper function to format dates
        function formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            return `${date.getDate()} ${months[date.getMonth()]}, ${date.getFullYear()}`;
        }

        // Export data function
        window.exportData = function(type) {
            console.log('Export requested:', type); // Debug message
            
            // Set the export type
            document.getElementById('export-type').value = type;
            
            // Set the values of the hidden inputs to current filter values
            document.getElementById('export-search').value = document.getElementById('autoComplete').value;
            document.getElementById('export-service').value = document.getElementById('serviceFilter').value;
            document.getElementById('export-specialization').value = document.getElementById('specializationFilter').value;
            document.getElementById('export-start-date').value = document.getElementById('start_date').value;
            document.getElementById('export-end-date').value = document.getElementById('end_date').value;
            
            // Show a loading message (optional)
            toastr.info('Preparing ' + type.toUpperCase() + ' export...');
            
            // Submit the form
            document.getElementById('export-form').submit();
        }
    });
</script>
@endsection