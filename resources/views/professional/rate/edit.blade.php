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
                    <table class="table" id="rateTable">
                        <thead>
                            <tr>
                                <th>Session Type</th>
                                <th>No. of Sessions</th>
                                <th>Rate Per Session (₹)</th>
                                <th>Final Rate (₹)</th>
                                <th>Duration</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rates as $rate)
                            @if(is_array($rate))
                            <tr>
                                <td>
                                    <select class="form-control" name="session_type[]">
                                        <option value="Weekly" {{ ($rate['session_type'] ?? '') == 'One Time' ? 'selected' : '' }}>One TIme</option>
                                        <option value="Monthly" {{ ($rate['session_type'] ?? '') == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="Quarterly" {{ ($rate['session_type'] ?? '') == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                        <option value="Free Hand" {{ ($rate['session_type'] ?? '') == 'Free Hand' ? 'selected' : '' }}>Free Hand</option>
                                    </select>
                                </td>
                                <td><input type="number" class="form-control" name="num_sessions[]" value="{{ $rate['num_sessions'] ?? '' }}" min="1"></td>
                                <td><input type="number" class="form-control" name="rate_per_session[]" value="{{ $rate['rate_per_session'] ?? '' }}" min="0" step="100"></td>
                                <td><input type="number" class="form-control final-rate" name="final_rate[]" value="{{ $rate['final_rate'] ?? '' }}" readonly></td>
                                <td><input type="text" class="form-control" name="duration[]" value="{{ $rate['duration'] ?? '' }}" placeholder="e.g. 1 week"></td>
                                <td>
                                    <div class="action-btn delete-rate" style="cursor: pointer;" title="Delete rate">
                                        <i class="fas fa-trash text-danger"></i>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        @endforeach
                        
                        </tbody>
                    </table>
                </div>
            
                <div class="form-actions mt-3" style="display: flex; gap: 10px;">
                    <button type="button" class="btn btn-outline-primary" id="addRateBtn">
                        <i class="fas fa-plus"></i> Add New Rate
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Save Rates
                    </button>
                </div>
            </form>
            
        </div>
    </div>
@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const calculateFinalRate = (row) => {
        const numSessions = parseInt(row.querySelector('td:nth-child(2) input').value) || 0;
        const ratePerSession = parseInt(row.querySelector('td:nth-child(3) input').value) || 0;
        const finalRateInput = row.querySelector('td:nth-child(4) input');
        finalRateInput.value = numSessions * ratePerSession;
    };

    // Initial calculation for the first row
    const firstRow = document.querySelector('.table tbody tr');
    calculateFinalRate(firstRow);

    // Add new rate row
    document.getElementById('addRateBtn').addEventListener('click', function() {
        const tbody = document.querySelector('.table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select class="form-control" name="session_type[]">
                    <option>Weekly</option>
                    <option>Monthly</option>
                    <option>Quarterly</option>
                    <option selected>Free Hand</option>
                </select>
            </td>
            <td><input type="number" name="sessions[]" class="form-control" value="1" min="1"></td>
            <td><input type="number" name="rate_per_session[]" class="form-control" value="0" min="0" step="100"></td>
            <td><input type="number" name="final_rate[]" class="form-control final-rate" value="0" readonly></td>
            <td><input type="text" name="duration[]" class="form-control" placeholder="e.g. custom duration"></td>
            <td>
                <div class="action-btn" title="Delete rate">
                    <i class="fas fa-trash"></i>
                </div>
            </td>
        `;
        tbody.appendChild(newRow);

        const numSessionsInput = newRow.querySelector('td:nth-child(2) input');
        const ratePerSessionInput = newRow.querySelector('td:nth-child(3) input');
        const finalRateInput = newRow.querySelector('td:nth-child(4) input');

        numSessionsInput.addEventListener('input', function() {
            calculateFinalRate(newRow);
        });
        ratePerSessionInput.addEventListener('input', function() {
            calculateFinalRate(newRow);
        });
        calculateFinalRate(newRow);
    });

    document.querySelector('.table tbody').addEventListener('click', function(e) {
        if (e.target && e.target.closest('.action-btn')) {
            const rowToDelete = e.target.closest('tr');
            rowToDelete.remove();
        }
    });

});
$(document).ready(function() {
    $('#rateForm').submit(function(e) {
    e.preventDefault();
    let form = this;
    let formData = new FormData(form);
    $.ajax({
    
        type: "PUT",
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message);
                form.reset();
                setTimeout(() => {
                    window.location.href = "{{ route('professional.rate.index') }}";
                }, 1500);
            } else {
                toastr.error(response.message || "Something went wrong");
            }
        },
        error: function(xhr) {
            console.log(xhr);  // Inspect this to see error details
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    toastr.error(value[0]);
                });
            } else {
                toastr.error(xhr.responseJSON.message || "An unexpected error occurred");
            }
        }
    });
});
    });
</script>
@endsection
