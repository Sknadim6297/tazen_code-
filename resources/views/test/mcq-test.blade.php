@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">MCQ Test Page</div>
                <div class="card-body">
                    <h5>Test MCQ Functionality</h5>
                    <p>This page simulates a booking success with MCQ questions.</p>
                    
                    <button class="btn btn-primary" onclick="simulateBookingSuccess()">
                        Simulate Booking Success with MCQ
                    </button>
                    
                    <div id="result" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function simulateBookingSuccess() {
    // Simulate setting session data for booking success
    fetch('/user/test/set-mcq-session', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            service_id: 1,
            booking_id: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to success page to see MCQ modal
            window.location.href = '/user/booking/success';
        } else {
            document.getElementById('result').innerHTML = '<div class="alert alert-danger">Error: ' + data.message + '</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        document.getElementById('result').innerHTML = '<div class="alert alert-danger">An error occurred</div>';
    });
}
</script>
@endsection
