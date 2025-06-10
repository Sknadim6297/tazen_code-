@extends('professional.layout.layout')

@section('style')
<!-- Add custom styles here if needed -->
@endsection

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <div class="page-title">
            <h3>Edit Rate</h3>
        </div>
        <ul class="breadcrumb">
            <li>Home</li>
            <li class="active">Edit Rate</li>
        </ul>
    </div>

    <div class="form-container">
        <form id="rateForm" method="POST" action="{{ route('professional.rate.update', $rates->id) }}">
            @csrf
            @method('PUT')
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Session Type</th>
                            <th>No. of Sessions</th>
                            <th>Rate Per Session (₹)</th>
                            <th>Final Rate (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class="form-control session-type" name="session_type" disabled>
                                    <option value="One Time" {{ $rates->session_type == 'One Time' ? 'selected' : '' }}>One Time</option>
                                    <option value="Monthly" {{ $rates->session_type == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Quarterly" {{ $rates->session_type == 'Quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="Free Hand" {{ $rates->session_type == 'Free Hand' ? 'selected' : '' }}>Free Hand</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control num-sessions" name="num_sessions" value="{{ $rates->num_sessions }}" min="1">
                            </td>
                            <td>
                                <input type="number" class="form-control rate-per-session" name="rate_per_session" value="{{ $rates->rate_per_session }}" min="0" step="100">
                            </td>
                            <td>
                                <input type="number" class="form-control final-rate" name="final_rate" value="{{ $rates->final_rate }}" readonly>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-actions mt-3 d-flex justify-content-between">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Rate
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
@media only screen and (min-width: 768px) and (max-width: 1024px) {
    .user-profile-wrapper {
        margin-top: -57px;
    }
    
}
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const row = document.querySelector('tbody tr');

        const calculateFinalRate = () => {
            const numSessions = parseInt(row.querySelector('.num-sessions').value || 0);
            const ratePerSession = parseInt(row.querySelector('.rate-per-session').value || 0);
            const finalRateInput = row.querySelector('.final-rate');
            finalRateInput.value = numSessions * ratePerSession;
        };

        row.querySelector('.num-sessions').addEventListener('input', calculateFinalRate);
        row.querySelector('.rate-per-session').addEventListener('input', calculateFinalRate);

        calculateFinalRate();
    });
</script>

<script>
    $(document).ready(function () {
        $('#rateForm').submit(function (e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);
            const submitBtn = $(form).find('button[type="submit"]');
            submitBtn.prop('disabled', true);

            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function (response) {
                    toastr.success("Rate updated successfully.");
                    setTimeout(() => {
                        window.location.href = "{{ route('professional.rate.index') }}";
                    }, 1500);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function (key, value) {
                            toastr.error(value[0]);
                        });
                    } else {
                        toastr.error("An unexpected error occurred.");
                    }
                },
                complete: function () {
                    submitBtn.prop('disabled', false);
                }
            });
        });
    });
</script>
@endsection
