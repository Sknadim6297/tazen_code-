
document.addEventListener('DOMContentLoaded', function() {
    // Form submission
    document.getElementById('aboutPageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Create FormData object
        const formData = new FormData(this);
        
        // Submit form via AJAX
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                alert('About page updated successfully!');
                // Optionally reload the page to show changes
                window.location.reload();
            } else {
                alert('Error updating about page: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the about page.');
        });
    });

    // Handle image removal
    document.querySelectorAll('.remove-image').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const fieldName = this.getAttribute('data-field');
            
            // Add hidden input to indicate image removal
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_' + fieldName;
            input.value = '1';
            document.getElementById('aboutPageForm').appendChild(input);
            
            // Hide the image and remove button
            this.previousElementSibling.style.display = 'none';
            this.style.display = 'none';
        });
    });
});
