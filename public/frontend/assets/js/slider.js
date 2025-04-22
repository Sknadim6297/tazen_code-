document.getElementById('openPopups').addEventListener('click', function(){
    document.getElementById('progressModel2').style.display = 'block';
});


document.getElementById('openPopups-2').addEventListener('click', function(){
    document.getElementById('progressModel').style.display = 'block';
});
document.getElementById('openPopups-3').addEventListener('click', function(){
    document.getElementById('progressModel').style.display = 'block';
});
document.getElementById('openPopups-4').addEventListener('click', function(){
    document.getElementById('progressModel').style.display = 'block';
});
document.getElementById('openPopups-5').addEventListener('click', function(){
    document.getElementById('progressModel').style.display = 'block';
});
document.getElementById('openPopups-6').addEventListener('click', function(){
    document.getElementById('progressModel').style.display = 'block';
});
document.getElementById('openPopups-7').addEventListener('click', function(){
    document.getElementById('progressModel').style.display = 'block';
});



document.getElementById('closeModel').addEventListener('click', function(){
    document.getElementById('progressModel2').style.display = 'none';

     // Reset progress bar width to initial state (20%)
     var progressBar = document.getElementById('progressBar');
     progressBar.style.width = '20%';
     
     // Uncheck all checkboxes
     const checkboxes = document.querySelectorAll('#progressForm input[type="checkbox"]');
     checkboxes.forEach(function(checkbox) {
         checkbox.checked = false;
     });
});


document.getElementById('closeModel').addEventListener('click', function(){
    document.getElementById('progressModel').style.display = 'none';

     // Reset progress bar width to initial state (20%)
     var progressBar = document.getElementById('progressBar');
     progressBar.style.width = '20%';
     
     // Uncheck all checkboxes
     const checkboxes = document.querySelectorAll('#progressForm input[type="checkbox"]');
     checkboxes.forEach(function(checkbox) {
         checkbox.checked = false;
     });
});


window.addEventListener('click', function(event) {
    const popups = document.getElementById('progressModel2');


    
    // Check if the click event is outside the popup (on the overlay)
    if(event.target === popups) {
        // Close the popup
        popups.style.display = 'none';
        
        // Reset progress bar width to initial state (20%)
        var progressBar = document.getElementById('progressBar');
        progressBar.style.width = '20%';
        
        // Uncheck all checkboxes
        const checkboxes = document.querySelectorAll('#progressForm input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
    }
});
window.addEventListener('click', function(event) {
    const popups = document.getElementById('progressModel');


    
    // Check if the click event is outside the popup (on the overlay)
    if(event.target === popups) {
        // Close the popup
        popups.style.display = 'none';
        
        // Reset progress bar width to initial state (20%)
        var progressBar = document.getElementById('progressBar');
        progressBar.style.width = '20%';
        
        // Uncheck all checkboxes
        const checkboxes = document.querySelectorAll('#progressForm input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
    }
});



document.getElementById('progress-control').addEventListener('click', function(event){
    event.preventDefault(); // Prevent form submission or page reload
    var progressBar = document.getElementById('progressBar');
    progressBar.style.width = '80%';



     // Hide step-3
     const step3 = document.querySelector('.step.step-3');
     step3.style.display = 'none';
     
     // Show step-4
     const step4 = document.querySelector('.step.step-4');
     step4.style.display = 'block';
});



// Function to reset the form to its initial state (step-3 with default progress bar and unchecked checkboxes)
function resetForm() {
    // Reset progress bar width to initial state (20%)
    var progressBar = document.getElementById('progressBar');
    progressBar.style.width = '20%';
    
    // Uncheck all checkboxes
    const checkboxes = document.querySelectorAll('#progressForm input[type="checkbox"]');
    checkboxes.forEach(function(checkbox) {
        checkbox.checked = false;
    });

    // Show step-3 and hide step-4
    const step3 = document.querySelector('.step.step-3');
    const step4 = document.querySelector('.step.step-4');
    step3.style.display = 'block';
    step4.style.display = 'none';
}

// Event listeners for opening the popup
document.querySelectorAll('[id^="openPopups"]').forEach(button => {
    button.addEventListener('click', function() {
        resetForm(); // Ensure the form is reset every time the popup opens
        document.getElementById('progressModel').style.display = 'block';
    });
});

// Close popup when the close button is clicked
document.getElementById('closeModel').addEventListener('click', function() {
    document.getElementById('progressModel').style.display = 'none';
});

// Close popup when clicking outside the popup
window.addEventListener('click', function(event) {
    const popups = document.getElementById('progressModel');
    if (event.target === popups) {
        popups.style.display = 'none';
    }
});

// Handling "Continue" button click
document.getElementById('progress-control').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission or page reload

    // Update progress bar width to 80%
    var progressBar = document.getElementById('progressBar');
    progressBar.style.width = '80%';

    // Hide step-3 and show step-4
    const step3 = document.querySelector('.step.step-3');
    const step4 = document.querySelector('.step.step-4');
    step3.style.display = 'none';
    step4.style.display = 'block';
});


// Event listener for the Continue button
document.getElementById('progress-control').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission or page reload

    // Update progress bar width to 80%
    var progressBar = document.getElementById('progressBar');
    progressBar.style.width = '80%';

    // Hide step-3 and show step-4
    const step3 = document.querySelector('.step.step-3');
    const step4 = document.querySelector('.step.step-4');
    step3.style.display = 'none';
    step4.style.display = 'block';

    // Ensure both Back and Continue buttons are visible
    document.getElementById('back-control').style.display = 'inline-block';
    document.getElementById('progress-control').style.display = 'inline-block';
});

// Event listener for the Back button
document.getElementById('back-control').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent form submission or page reload

    // Update progress bar width to 20%
    var progressBar = document.getElementById('progressBar');
    progressBar.style.width = '20%';

    // Hide step-4 and show step-3
    const step3 = document.querySelector('.step.step-3');
    const step4 = document.querySelector('.step.step-4');
    step3.style.display = 'block';
    step4.style.display = 'none';

    // Hide Back button when returning to step-3
    document.getElementById('back-control').style.display = 'none';
});
