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
                <h1 class="page-title fw-medium fs-18 mb-2">All  Professionals</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                     
                            <li class="breadcrumb-item"><a href="javascript:void(0);"> Professional</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Professionals</li>
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
                            Total  Professionals
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th><input class="form-check-input check-all" type="checkbox" id="all-professionals" aria-label="..."></th>
                                        <th scope="col">Sl.No</th>
                                        <th scope="col">Professional Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @forelse ($requestedProfessionals as $professional)
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
                                                <span class="fw-medium">{{ $professional->created_at }}</span>
                                            </td>
                                            <td>
                                                @if($professional->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($professional->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($professional->status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2 items-center">
                                                    <button class="btn btn-success btn-sm approve-btn" data-id="{{ $professional->id }}" data-url="{{ route('admin.professional.requests.approve', $professional->id) }}" data-bs-toggle="tooltip" title="Accept">
                                                        <i class="fas fa-check"></i> Accept
                                                    </button>
                                                    <a href="{{ route('admin.manage-professional.destroy', $professional->id) }}" 
                                                       class="btn btn-danger btn-sm" 
                                                       data-bs-toggle="tooltip" 
                                                       title="Reject"
                                                       onclick="return confirm('Are you sure you want to reject this professional?');">
                                                        <i class="fas fa-times"></i> Reject
                                                    </a>
                                                    <a href="{{ route('admin.manage-professional.show', $professional->id) }}" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-title="view">
                                                        <i class="fas fa-eye"></i> View

                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">
                                                <div class="py-4">
                                                    <h5 class="mb-0 text-muted">No Pending Professionals Found.</h5>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                
                                
                            </table>
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-0 float-end">
                                <li class="page-item disabled">
                                    <a class="page-link">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">1</a></li>
                                <li class="page-item active" aria-current="page">
                                    <a class="page-link" href="javascript:void(0);">2</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0);">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-2 -->


    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).on('click', '.approve-btn', function(e) {
    e.preventDefault();

    var button = $(this);
    var url = button.data('url');
    var id = button.data('id'); 

    $.ajax({
        type: 'POST',
        url: url,
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
           toster.success(response.message);
            setTimeout(function() {
                window.location.reload(); 
            }, 1500);
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value[0]);
                });
            } else{
                toastr.error(xhr.responseJSON.message || "Something went wrong. Please try again.");
            }
        }
    });
});

</script>
@endsection
