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
                                <th>Duration</th>
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
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sessionTypes = ['One Time', 'Monthly', 'Quarterly', 'Free Hand']; 
    let selectedSessionTypes = [];
    function updateDropdownOptions() {
        const allSelects = document.querySelectorAll('.session-type');
        allSelects.forEach(select => {
            select.querySelectorAll('option').forEach(option => {
                option.disabled = false;
            });
            select.querySelectorAll('option').forEach(option => {
                if (selectedSessionTypes.includes(option.value) && !option.selected) {
                    option.disabled = true;
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

    document.getElementById('addRateBtn').addEventListener('click', function() {
        if (selectedSessionTypes.length >= 4) {
            toastr.error('You can only add up to 4 different session types.');
            return;
        }
        const tbody = document.querySelector('.table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select class="form-control session-type">
                    <option value="">Select Session Type</option>
                    <option>One Time</option>
                    <option>Monthly</option>
                    <option>Quarterly</option>
                    <option>Free Hand</option>
                </select>
            </td>
            <td><input type="number" class="form-control" value="1" min="1"></td>
            <td><input type="number" class="form-control" value="0" min="0" step="100"></td>
            <td><input type="number" class="form-control final-rate" name="final_rate[]" readonly></td>
           <td>
    <select class="form-control" id="durationSelect" onchange="toggleCustomDuration()">
        <option value="30">30 minutes</option>
        <option value="45">45 minutes</option>
        <option value="60" selected>60 minutes</option>
        <option value="90">90 minutes</option>
        <option value="120">2 hours</option>

    </select>
</td>
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
        const sessionTypeSelect = newRow.querySelector('.session-type');
        numSessionsInput.addEventListener('input', function() {
            calculateFinalRate(newRow);
        });
        ratePerSessionInput.addEventListener('input', function() {
            calculateFinalRate(newRow);
        });

        sessionTypeSelect.addEventListener('change', function() {
            const selectedType = sessionTypeSelect.value;
            if (selectedType && !selectedSessionTypes.includes(selectedType)) {
                selectedSessionTypes.push(selectedType);
            }
            updateDropdownOptions();
        });

        calculateFinalRate(newRow);
        updateDropdownOptions(); // Update all dropdowns
    });

    // Row deletion
    document.querySelector('.table tbody').addEventListener('click', function(e) {
        if (e.target && e.target.closest('.action-btn')) {
            const rowToDelete = e.target.closest('tr');
            const sessionTypeToDelete = rowToDelete.querySelector('.session-type').value;
            rowToDelete.remove();
            selectedSessionTypes = selectedSessionTypes.filter(type => type !== sessionTypeToDelete);
            updateDropdownOptions();
        }
    });

    // Submit form via AJAX
    document.getElementById('rateForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let rateData = [];
        document.querySelectorAll('.table tbody tr').forEach(row => {
            let sessionType = row.querySelector('td:nth-child(1) select').value;
            let numSessions = parseInt(row.querySelector('td:nth-child(2) input').value) || 0;
            let ratePerSession = parseInt(row.querySelector('td:nth-child(3) input').value) || 0;
            let finalRate = parseFloat(row.querySelector('td:nth-child(4) input').value) || 0;  
             let duration = row.querySelector('td:nth-child(5) select').value;

            rateData.push({
                session_type: sessionType,
                num_sessions: numSessions,
                rate_per_session: ratePerSession,
                final_rate: finalRate,
                duration: duration
            });
        });

        let postData = {
            professional_id: "{{ Auth::guard('professional')->id() }}", 
            rateData: rateData, 
            _token: $('meta[name="csrf-token"]').attr('content') 
        };

        // AJAX request
        $.ajax({
            url: "{{ route('professional.rate.store') }}",
            type: "POST",
            data: postData,
            success: function(response) {
                if (response.status) {
                    toastr.success(response.message);
                    $('#rateForm')[0].reset();
                    setTimeout(() => {
                        window.location.href = "{{ route('professional.rate.index') }}";
                    }, 1500);
                } else {
                    toastr.error(response.message || "Something went wrong");
                }
            },
            error: function(xhr) {
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
