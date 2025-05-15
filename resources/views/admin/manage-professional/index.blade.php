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
            <form action="" class="d-flex gap-2">
           
            <div class="col-xl-4">
                <input type="search" class="form-control" id="autoComplete" placeholder="Search by name or email" spellcheck="false" autocomplete="off" autocapitalize="off">
            </div>
             <div class="col-xl-6">
            <div class="">
                <div class="card-body">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-text text-muted"> <i class="ri-calendar-line"></i> </div>
                            <input type="text" class="form-control" id="daterange" placeholder="Choose dates">
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                                <a href="{{ route('admin.manage-professional.edit', $professional->id) }}" class="btn btn-primary-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-title="Edit">
                                                    <i class="ri-edit-line"></i>
                                                </a>
                                                <a href="{{ route('admin.manage-professional.destroy', $professional->id) }}" class="btn btn-danger-light btn-icon btn-sm" data-bs-toggle="tooltip" data-bs-title="Delete">
                                                    <i class="ri-delete-bin-5-line"></i>
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
                                <!-- Pagination goes here (if needed) -->
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
            $('#daterange').flatpickr({
                mode: "range", 
                  defaultDate: null,
                dateFormat: "Y-m-d", 
                onClose: function(selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2) {
                        let startDate = selectedDates[0].toISOString().split('T')[0];
                        let endDate = selectedDates[1].toISOString().split('T')[0];
                        filterData(startDate, endDate);
                    }
                }
            });
            $('#autoComplete').on('keyup', function() {
                let searchTerm = $(this).val();
                let startDate = $('#daterange').data('startDate');
                let endDate = $('#daterange').data('endDate');
                filterData(startDate, endDate, searchTerm);
            });

            // Function to fetch data based on filters
            function filterData(startDate = '', endDate = '', searchTerm = '') {
                $.ajax({
                    url: '{{ route('admin.manage-professional.index') }}',
                    method: 'GET',
                    data: {
                        search: searchTerm,
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        let professionalsHtml = '';
                        $.each(response.professionals.data, function(index, professional) {
                            professionalsHtml += `
                                <tr class="professional-list">
                                    <td class="professional-checkbox">
                                        <input class="form-check-input" type="checkbox" value="${professional.id}" aria-label="...">
                                    </td>
                                    <td><span class="fw-medium">${index + 1}</span></td>
                                    <td><span class="fw-medium">${professional.name}</span></td>
                                    <td><span class="fw-medium">${professional.email}</span></td>
                                    <td><span class="badge bg-${professional.status === 'accepted' ? 'success' : professional.status === 'pending' ? 'warning' : 'danger'}">${professional.status.charAt(0).toUpperCase() + professional.status.slice(1)}</span></td>
                                    <td><span class="fw-medium">${formatDate(professional.created_at)}</span></td>
                                    <td>
                                        <a href="/admin/manage-professional/${professional.id}" class="btn btn-success-light btn-icon btn-sm"><i class="ri-eye-line"></i></a>
                                        <a href="/admin/manage-professional/${professional.id}/edit" class="btn btn-primary-light btn-icon btn-sm"><i class="ri-edit-line"></i></a>
                                        <a href="/admin/manage-professional/${professional.id}/destroy" class="btn btn-danger-light btn-icon btn-sm"><i class="ri-delete-bin-5-line"></i></a>
                                    </td>
                                </tr>
                            `;
                        });
                        $('#professional-table-body').html(professionalsHtml);
                    }
                });
            }
        });
        function formatDate(dateString) {
    const date = new Date(dateString);
    const options = { day: '2-digit', month: 'long', year: 'numeric' };
    return date.toLocaleDateString('en-GB', options);
}
    </script>
@endsection
