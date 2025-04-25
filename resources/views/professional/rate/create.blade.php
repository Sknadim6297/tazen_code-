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
                            <tr>
                                <td>
                                    <select class="form-control">
                                        <option>Weekly</option>
                                        <option>Monthly</option>
                                        <option>Quarterly</option>
                                        <option>Free Hand</option>
                                    </select>
                                </td>
                                <td><input type="number" class="form-control" value="2" min="1"></td>
                                <td><input type="number" class="form-control" value="1000" min="0" step="100"></td>
                                <td>2000</td>
                                <td><input type="text" class="form-control" placeholder="e.g. 1 week"></td>
                                <td>
                                    <div class="action-btn" title="Delete rate">
                                        <i class="fas fa-trash"></i>
                                    </div>
                                </td>
                            </tr>
                            <!-- Repeat the above <tr> for additional rows -->
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
    // Add new rate row
document.getElementById('addRateBtn').addEventListener('click', function() {
    const tbody = document.querySelector('.table tbody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>
            <select class="form-control">
                <option>Weekly</option>
                <option>Monthly</option>
                <option>Quarterly</option>
                <option selected>Free Hand</option>
            </select>
        </td>
        <td><input type="number" class="form-control" value="1" min="1"></td>
        <td><input type="number" class="form-control" value="0" min="0" step="100"></td>
        <td>0</td>
        <td><input type="text" class="form-control" placeholder="e.g. custom duration"></td>
        <td>
            <div class="action-btn" title="Delete rate">
                <i class="fas fa-trash"></i>
            </div>
        </td>
    `;
    tbody.appendChild(newRow);

    // Attach event listeners to new row elements
    const numSessionsInput = newRow.querySelector('td:nth-child(2) input');
    const ratePerSessionInput = newRow.querySelector('td:nth-child(3) input');
    const finalRateCell = newRow.querySelector('td:nth-child(4)');
    
    const calculateFinalRate = () => {
        const numSessions = parseInt(numSessionsInput.value) || 0;
        const ratePerSession = parseInt(ratePerSessionInput.value) || 0;
        finalRateCell.textContent = (numSessions * ratePerSession).toLocaleString();
    };

    numSessionsInput.addEventListener('input', calculateFinalRate);
    ratePerSessionInput.addEventListener('input', calculateFinalRate);

    // Recalculate final rate for newly added row
    calculateFinalRate(); // Ensure that new row shows correct initial value
});

// Delete row functionality with event delegation
document.querySelector('.table tbody').addEventListener('click', function(e) {
    if (e.target && e.target.closest('.action-btn')) {
        const rowToDelete = e.target.closest('tr');
        rowToDelete.remove();
    }
});

$('#rateForm').submit(function(e) {
    e.preventDefault();

    let rateData = [];

    // Iterate through each row in the table and collect the data
    $('#rateForm .table tbody tr').each(function() {
        let row = $(this);

        let sessionType = row.find('td:nth-child(1) select').val();
        let numSessions = parseInt(row.find('td:nth-child(2) input').val()) || 0;
        let ratePerSession = parseInt(row.find('td:nth-child(3) input').val()) || 0;
        let finalRate = parseFloat(row.find('td:nth-child(4)').text()) || 0;  
        let duration = row.find('td:nth-child(5) input').val();

        if (finalRate === 0) {
            finalRate = numSessions * ratePerSession; // Simple calculation
        }

        // Ensure we are sending the correct data format (array of objects)
        rateData.push({
            session_type: sessionType,
            num_sessions: numSessions,
            rate_per_session: ratePerSession,
            final_rate: finalRate,  // Send as a number
            duration: duration
        });
    });

    // Add professional_id to the postData object
    let postData = {
        professional_id: "{{ Auth::guard('professional')->id() }}", // Dynamically add the professional_id
        rateData: rateData, // Directly sending the rateData array
        _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
    };

    // AJAX request
    $.ajax({
        url: "{{ route('professional.rate.store') }}",
        type: "POST",
        data: postData, // Send data as a regular object
        success: function(response) {
            if (response.status) {
                toastr.success(response.message);
                $('#rateForm')[0].reset(); // Reset the form
                setTimeout(() => {
                    window.location.href = "{{ route('professional.dashboard') }}";
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



</script>
@endsection
