@extends('admin.layouts.layout')

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" />
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
        <form action="{{ route('admin.manage-professional.index') }}" method="GET" class="d-flex align-items-center gap-2 mb-4">
            <div class="col-xl-3">
                <input type="search" name="search" class="form-control form-control-sm" id="autoComplete" placeholder="Search by name or email">
            </div>
            
            <div class="col-xl-3">
                <select id="serviceFilter" name="service_id" class="form-select form-select-sm">
                    <option value="">All Services</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
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
                                        <th scope="col">Margin Percentage</th>
                                        <th scope="col">Status</th>
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
                                            <td style="display: flex; justify-content: center; align-items: center;">
                                                @if($professional->status === 'accepted')
                                                    <form action="{{ route('admin.updateMargin', $professional->id) }}" method="POST" class="d-flex align-items-center gap-2">
                                                        @csrf
                                                        <div class="input-group" style="max-width: 115px;">
                                                            <input class="form-control" type="number" name="margin_percentage" 
                                                                value="{{ $professional->margin }}" min="0" max="100" required>
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </form>
                                                @else
                                                    Not Applicable
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
            
            filterData(startDate, endDate, searchTerm, serviceId);
        });

        // Individual filter change handlers for immediate filtering
        $('#autoComplete').on('keyup', function() {
            if($(this).val().length >= 3 || $(this).val().length === 0) {
                setTimeout(function() {
                    $('form').submit();
                }, 500);
            }
        });

        $('#serviceFilter').on('change', function() {
            $('form').submit();
        });

        $('#start_date, #end_date').on('change', function() {
            // Only trigger if both dates have values
            if($('#start_date').val() && $('#end_date').val()) {
                $('form').submit();
            }
        });

        // Function to fetch data based on filters
        function filterData(startDate = '', endDate = '', searchTerm = '', serviceId = '') {
            // Show loading indicator
            $('#professional-table-body').html('<tr><td colspan="9" class="text-center"><i class="ri-loader-4-line fa-spin me-2"></i> Loading...</td></tr>');
            
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
                    service_id: serviceId
                },
                success: function(response) {
                    let professionalsHtml = '';
                    
                    if (response.professionals.data.length === 0) {
                        professionalsHtml = '<tr><td colspan="9" class="text-center">No professionals found matching your criteria</td></tr>';
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

                            // Generate margin HTML
                            const marginHtml = professional.status === 'accepted' ? 
                                `<form action="/admin/update-margin/${professional.id}" method="POST" class="d-flex align-items-center gap-2">
                                    @csrf
                                    <div class="input-group" style="max-width: 115px;">
                                        <input class="form-control" type="number" name="margin_percentage" 
                                            value="${professional.margin || 0}" min="0" max="100" required>
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </form>` : 
                                'Not Applicable';

                            // Generate status badge
                            const statusBadge = professional.status === 'accepted' ? 
                                '<span class="badge bg-success">Approved</span>' : 
                                professional.status === 'pending' ? 
                                '<span class="badge bg-warning">Pending</span>' : 
                                '<span class="badge bg-danger">Rejected</span>';

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
                                    <td style="display: flex; justify-content: center; align-items: center;">${marginHtml}</td>
                                    <td>${statusBadge}</td>
                                    <td><span class="fw-medium">${formatDate(professional.created_at)}</span></td>
                                    <td>
                                        <a href="/admin/manage-professional/${professional.id}" class="btn btn-success-light btn-icon btn-sm">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                    </td>
                                </tr>
                            `;
                        });
                    }
                    $('#professional-table-body').html(professionalsHtml);
                },
                error: function() {
                    $('#professional-table-body').html('<tr><td colspan="9" class="text-center text-danger">Error loading data. Please try again.</td></tr>');
                }
            });
        }

        function formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return dateString; // Return as is if invalid date
            
            const options = { day: '2-digit', month: 'long', year: 'numeric' };
            return date.toLocaleDateString('en-GB', options);
        }
    });
</script>
@endsection
