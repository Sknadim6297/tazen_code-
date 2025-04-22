
	$(document).ready(function() {
		let currentQuestion = 1;
		const totalQuestions = 4;
		let selectedService = '';
		
		// Add click handler to all Book Now buttons
		$('.book-now-btn').click(function(e) {
			e.preventDefault();
			selectedService = $(this).closest('.card').find('.text-dark').text().trim();
			$('#mcqModal').modal('show');
		});
		
		// Next button click handler
		$('#nextBtn').click(function() {
			// Validate that an option is selected
			if (!$('input[name="q' + currentQuestion + '"]:checked').val()) {
				alert('Please select an option to continue');
				return;
			}
			
			if (currentQuestion < totalQuestions) {
				$(`#question${currentQuestion}`).removeClass('active');
				currentQuestion++;
				$(`#question${currentQuestion}`).addClass('active');
				
				// Show previous button after first question
				if (currentQuestion > 1) {
					$('#prevBtn').show();
				}
				
				// Change next to submit on last question
				if (currentQuestion === totalQuestions) {
					$('#nextBtn').hide();
					$('#submitBtn').show();
				}
			}
		});
		
		// Previous button click handler
		$('#prevBtn').click(function() {
			if (currentQuestion > 1) {
				$(`#question${currentQuestion}`).removeClass('active');
				currentQuestion--;
				$(`#question${currentQuestion}`).addClass('active');
				
				// Hide submit button if not on last question
				$('#submitBtn').hide();
				$('#nextBtn').show();
				
				// Hide previous button on first question
				if (currentQuestion === 1) {
					$('#prevBtn').hide();
				}
			}
		});
		
		// Submit button click handler
		$('#submitBtn').click(function() {
			// Validate that an option is selected for the last question
			if (!$('input[name="q' + currentQuestion + '"]:checked').val()) {
				alert('Please select an option to submit');
				return;
			}
			
			// Collect all the answers
			const answers = {
				service: selectedService,
				q1: $('input[name="q1"]:checked').val(),
				q2: $('input[name="q2"]:checked').val(),
				q3: $('input[name="q3"]:checked').val(),
				q4: $('input[name="q4"]:checked').val()
			};
			
			// You could send this data to a server here if needed
			console.log('Collected answers:', answers);
			
			// Close the modal
			$('#mcqModal').modal('hide');
			
			// Redirect to your desired page after submission
			window.location.href = "../prozim/grid-listing-1.html"; // Change this URL
		});
		
		// Reset modal when closed
		$('#mcqModal').on('hidden.bs.modal', function() {
			currentQuestion = 1;
			$('.question').removeClass('active');
			$('#question1').addClass('active');
			$('#prevBtn').hide();
			$('#submitBtn').hide();
			$('#nextBtn').show();
			$('#mcqForm')[0].reset();
		});
	});
	