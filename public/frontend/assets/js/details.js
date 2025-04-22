document.addEventListener('DOMContentLoaded', function() {
    const planButtons = document.querySelectorAll('.select-plan');
    const selectedPlanDisplay = document.getElementById('selected-plan-display');
    const selectedPlanText = document.getElementById('selected-plan-text');
    const selectedPlanInput = document.getElementById('selected_plan');
    
    planButtons.forEach(button => {
        button.addEventListener('click', function() {
            const plan = this.getAttribute('data-plan');
            let planName = '';
            
            switch(plan) {
                case 'one-time':
                    planName = 'One-time Consultation (Rs. 2,500)';
                    break;
                case 'monthly':
                    planName = 'Monthly Package (Rs. 8,000)';
                    break;
                case 'quarterly':
                    planName = 'Quarterly Package (Rs. 21,000)';
                    break;
                case 'freehand':
                    planName = 'Free-hand Consultation (Starting from Rs. 2,000)';
                    break;
            }
            
            selectedPlanText.textContent = planName;
            selectedPlanInput.value = plan;
            selectedPlanDisplay.style.display = 'block';
            
            // Scroll to booking section
            document.querySelector('.box_booking.mobile_fixed').scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});