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
                <h1 class="page-title fw-medium fs-18 mb-2">Manage Professionals</h1>
                <div>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Professional</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Professional</li>
                        </ol>
                    </nav>
                </div>
            </div>
           <form action="{{ route('admin.professional.requests') }}" method="GET" class="d-flex gap-2">
           <div class="col-xl-6">
        <div class="card-body">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                    <input type="date" class="form-control"  placeholder="Choose Start Date" name="start_date" id="start_date">
                    <span class="input-group-text">to</span>
                    <input type="date" class="form-control"  placeholder="Choose End Date" name="end_date" id="end_date">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card custom-card">
            <input type="search" name="search" class="form-control" id="autoComplete" placeholder="Search">
        </div>
    </div>
    <div class="col-xl-2">
        <button type="submit" class="btn btn-primary">Search</button>
    </div>
</form>

           
        </div>

        <!-- Professionals Table -->
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
                            <table class="table text-nowrap" id="professionalsTable">
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
                                        <tr>
                                            <td><input class="form-check-input" type="checkbox" value="{{ $professional->id }}" aria-label="..."></td>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $professional->name }}</td>
                                            <td>{{ $professional->email }}</td>
                                            <td>{{ $professional->created_at }}</td>
                                            <td>
                                                @if($professional->status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($professional->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button class="btn btn-success btn-sm approve-btn" data-id="{{ $professional->id }}" data-url="{{ route('admin.professional.requests.approve', $professional->id) }}">Accept</button>
                                                <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $professional->id }}" data-name="{{ $professional->name }}" data-url="{{ route('admin.professional.requests.reject', $professional->id) }}" data-bs-toggle="modal" data-bs-target="#rejectModal">Reject</button>
                                                <a href="{{ route('admin.manage-professional.show', $professional->id) }}" class="btn btn-primary btn-sm">View</a>
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
                        <!-- Pagination (if needed) -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="rejectForm" method="POST">
            @csrf
            <input type="hidden" name="_method" value="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectModalLabel">Rejection Reason</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong id="professionalName"></strong> rejected for which reason?</p>
                    <div class="form-group">
                        <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </form>
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
            _token: '{{ csrf_token() }}',
            id: id
        },
        success: function(response) {
            if(response.status === 'success') {
                toastr.success(response.message); 
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            } else {
                toastr.error("Something went wrong! Please try again.");
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value[0]); 
                });
            } else {
                toastr.error(xhr.responseJSON.message || "Something went wrong. Please try again.");
            }
        }
    });
    
}
);


document.addEventListener('DOMContentLoaded', function () {
    const rejectButtons = document.querySelectorAll('.reject-btn');
    const form = document.getElementById('rejectForm');
    const reasonField = document.getElementById('reason');
    const nameField = document.getElementById('professionalName');
    let currentUrl = ''; 

    rejectButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            const url = this.getAttribute('data-url');

            currentUrl = url;
            form.setAttribute('action', url);
            nameField.textContent = name;
            reasonField.value = ''; 
        });
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch(currentUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                toastr.success(data.message);

                const rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
                rejectModal.hide();

                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                toastr.error(data.message || 'Something went wrong!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            toastr.error('Server error occurred!');
        });
    });
    
});
</script>
<script>
    flatpickr("#start_date", {
      dateFormat: "d-m-Y",  
      altInput: true,  
      altFormat: "d-m-Y", 
   });

   flatpickr("#end_date", {
      dateFormat: "d-m-Y", 
      altInput: true,  
      altFormat: "d-m-Y", 
   });
</script>
@endsection
