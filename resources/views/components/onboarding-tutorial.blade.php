<!-- Onboarding Tutorial Component -->
<div id="onboarding-overlay" class="onboarding-overlay" style="display: none;">
    <div class="onboarding-backdrop"></div>
    <div class="onboarding-content">
        <div class="onboarding-header">
            <h2 id="onboarding-title">Welcome to Your Dashboard!</h2>
            <div class="onboarding-progress">
                <span id="onboarding-step">1</span> of <span id="onboarding-total">5</span>
                <div class="progress-bar">
                    <div class="progress-fill" id="onboarding-progress-fill"></div>
                </div>
            </div>
        </div>
        
        <div class="onboarding-body">
            <div class="onboarding-message" id="onboarding-message">
                Let's take a quick tour of your dashboard to help you get started!
            </div>
            
            <div class="onboarding-pointer" id="onboarding-pointer">
                <div class="pointer-arrow"></div>
            </div>
        </div>
        
        <div class="onboarding-footer">
            <button type="button" class="btn btn-secondary" id="onboarding-skip">Skip Tour</button>
            <div class="onboarding-navigation">
                <button type="button" class="btn btn-outline-primary" id="onboarding-prev" style="display: none;">Previous</button>
                <button type="button" class="btn btn-primary" id="onboarding-next">Next</button>
                <button type="button" class="btn btn-success" id="onboarding-finish" style="display: none;">Complete Tour</button>
            </div>
        </div>
    </div>
</div>

<style>
.onboarding-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    pointer-events: none;
}

.onboarding-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.75);
    pointer-events: all;
}

.onboarding-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow: hidden;
    pointer-events: all;
    animation: onboardingSlideIn 0.5s ease-out;
}

@keyframes onboardingSlideIn {
    from {
        opacity: 0;
        transform: translate(-50%, -60%);
    }
    to {
        opacity: 1;
        transform: translate(-50%, -50%);
    }
}

.onboarding-header {
    padding: 24px 24px 16px;
    border-bottom: 1px solid #e9ecef;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.onboarding-header h2 {
    margin: 0 0 16px 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.onboarding-progress {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.9rem;
    opacity: 0.9;
}

.progress-bar {
    flex: 1;
    height: 4px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 2px;
    margin: 0 16px;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: white;
    border-radius: 2px;
    transition: width 0.3s ease;
    width: 20%;
}

.onboarding-body {
    padding: 24px;
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
}

.onboarding-message {
    font-size: 1.1rem;
    line-height: 1.6;
    color: #495057;
}

.onboarding-pointer {
    position: absolute;
    width: 20px;
    height: 20px;
    background: #ffc107;
    border-radius: 50%;
    display: none;
    animation: onboardingPulse 2s infinite;
}

@keyframes onboardingPulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.2);
        opacity: 0.7;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.pointer-arrow {
    position: absolute;
    width: 0;
    height: 0;
    border: 8px solid transparent;
    border-top-color: #ffc107;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
}

.onboarding-footer {
    padding: 16px 24px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
}

.onboarding-navigation {
    display: flex;
    gap: 12px;
}

.onboarding-navigation .btn {
    padding: 8px 20px;
    font-size: 0.9rem;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.onboarding-navigation .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* Highlight target elements */
.onboarding-highlight {
    position: relative;
    z-index: 9999;
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.5), 0 0 20px rgba(102, 126, 234, 0.3) !important;
    border-radius: 8px !important;
    transition: all 0.3s ease;
    animation: onboardingGlow 2s infinite alternate;
}

/* Interactive elements */
.onboarding-interactive {
    cursor: pointer !important;
    box-shadow: 0 0 0 4px rgba(40, 167, 69, 0.5), 0 0 20px rgba(40, 167, 69, 0.3) !important;
    position: relative !important;
}

.onboarding-interactive::after {
    content: 'Click me!';
    position: absolute;
    top: -35px;
    left: 50%;
    transform: translateX(-50%);
    background: #28a745;
    color: white;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    font-weight: bold;
    z-index: 10001;
    animation: onboardingBounce 1s infinite;
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.3);
    white-space: nowrap;
}

/* Instruction pointer */
.onboarding-instruction {
    position: fixed;
    background: #333;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 14px;
    z-index: 10001;
    max-width: 200px;
    text-align: center;
    animation: onboardingFadeInInstruction 0.3s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.onboarding-instruction::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    border: 6px solid transparent;
    border-top-color: #333;
}

@keyframes onboardingGlow {
    from {
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.5), 0 0 20px rgba(102, 126, 234, 0.3);
    }
    to {
        box-shadow: 0 0 0 6px rgba(102, 126, 234, 0.7), 0 0 30px rgba(102, 126, 234, 0.5);
    }
}

@keyframes onboardingBounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateX(-50%) translateY(0);
    }
    40% {
        transform: translateX(-50%) translateY(-10px);
    }
    60% {
        transform: translateX(-50%) translateY(-5px);
    }
}

@keyframes onboardingFadeInInstruction {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes onboardingSuccessPop {
    0% {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.5);
    }
    20% {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1.1);
    }
    100% {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }
}

/* Success popup */
.onboarding-success-popup {
    position: fixed;
    z-index: 10002;
    animation: onboardingSuccessPop 1.5s ease;
}

/* Mobile responsive */
@media (max-width: 768px) {
    .onboarding-content {
        width: 95%;
        max-width: none;
        margin: 20px;
    }
    
    .onboarding-header h2 {
        font-size: 1.3rem;
    }
    
    .onboarding-message {
        font-size: 1rem;
    }
    
    .onboarding-footer {
        flex-direction: column;
        gap: 16px;
    }
    
    .onboarding-navigation {
        width: 100%;
        justify-content: center;
    }
}

/* Help button for accessing tour later */
.onboarding-help-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 50%;
    box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
    cursor: pointer;
    z-index: 1000;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
}

.onboarding-help-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.onboarding-help-btn i {
    font-size: 1.4rem;
}
</style>

<script>
class OnboardingTour {
    constructor(steps, type = 'customer') {
        this.steps = steps;
        this.currentStep = 0;
        this.type = type; // 'customer' or 'professional'
        this.isActive = false;
        
        this.overlay = document.getElementById('onboarding-overlay');
        this.title = document.getElementById('onboarding-title');
        this.message = document.getElementById('onboarding-message');
        this.stepIndicator = document.getElementById('onboarding-step');
        this.totalIndicator = document.getElementById('onboarding-total');
        this.progressFill = document.getElementById('onboarding-progress-fill');
        this.pointer = document.getElementById('onboarding-pointer');
        
        this.prevBtn = document.getElementById('onboarding-prev');
        this.nextBtn = document.getElementById('onboarding-next');
        this.finishBtn = document.getElementById('onboarding-finish');
        this.skipBtn = document.getElementById('onboarding-skip');
        
        this.bindEvents();
    }
    
    bindEvents() {
        this.nextBtn.addEventListener('click', () => this.nextStep());
        this.prevBtn.addEventListener('click', () => this.prevStep());
        this.finishBtn.addEventListener('click', () => this.completeTour());
        this.skipBtn.addEventListener('click', () => this.skipTour());
        
        // Close on backdrop click
        document.querySelector('.onboarding-backdrop').addEventListener('click', () => this.skipTour());
        
        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (!this.isActive) return;
            
            if (e.key === 'Escape') this.skipTour();
            if (e.key === 'ArrowRight') this.nextStep();
            if (e.key === 'ArrowLeft') this.prevStep();
        });
    }
    
    async start() {
        // Check if onboarding is already completed
        const status = await this.checkOnboardingStatus();
        if (status.completed) {
            return;
        }
        
        this.isActive = true;
        this.currentStep = 0;
        this.totalIndicator.textContent = this.steps.length;
        this.showStep();
        this.overlay.style.display = 'block';
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
    }
    
    showStep() {
        const step = this.steps[this.currentStep];
        
        // Update content
        this.title.textContent = step.title;
        this.message.textContent = step.message;
        this.stepIndicator.textContent = this.currentStep + 1;
        
        // Update progress
        const progress = ((this.currentStep + 1) / this.steps.length) * 100;
        this.progressFill.style.width = `${progress}%`;
        
        // Clear previous highlights and effects
        this.clearHighlights();
        this.clearInstructions();
        
        // Highlight target element with enhanced effects
        if (step.target) {
            const target = document.querySelector(step.target);
            if (target) {
                target.classList.add('onboarding-highlight');
                
                // Add interactive class if step is interactive
                if (step.interactive) {
                    target.classList.add('onboarding-interactive');
                    this.makeInteractive(target, step);
                }
                
                // Apply specific action
                if (step.action === 'pulse') {
                    target.style.animation = 'onboardingPulse 2s infinite';
                }
                
                // Add instruction pointer if specified
                if (step.instruction) {
                    this.showInstruction(target, step.instruction, step.position || 'top');
                }
                
                this.scrollToTarget(target);
                
                // Position modal relative to target
                this.positionModal(target, step.position || 'center');
            }
        } else {
            // Center the modal
            this.positionModal(null, 'center');
        }
        
        // Update navigation buttons
        this.prevBtn.style.display = this.currentStep > 0 ? 'block' : 'none';
        this.nextBtn.style.display = this.currentStep < this.steps.length - 1 ? 'block' : 'none';
        this.finishBtn.style.display = this.currentStep === this.steps.length - 1 ? 'block' : 'none';
        
        // Update button text for interactive steps
        if (step.interactive && this.currentStep < this.steps.length - 1) {
            this.nextBtn.textContent = 'Skip & Continue';
        } else {
            this.nextBtn.textContent = 'Next';
        }
    }
    
    makeInteractive(target, step) {
        // Add click handler for interactive elements
        const clickHandler = (e) => {
            e.preventDefault();
            
            // Show success message
            this.showClickSuccess();
            
            // Auto-advance after a short delay
            setTimeout(() => {
                if (this.currentStep < this.steps.length - 1) {
                    this.nextStep();
                }
            }, 1500);
            
            // Remove this handler
            target.removeEventListener('click', clickHandler);
        };
        
        target.addEventListener('click', clickHandler);
        
        // Store handler for cleanup
        target._onboardingClickHandler = clickHandler;
    }
    
    showClickSuccess() {
        // Create success popup
        const successPopup = document.createElement('div');
        successPopup.className = 'onboarding-success-popup';
        successPopup.innerHTML = '✅ Great! Well done!';
        successPopup.style.cssText = `
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #28a745;
            color: white;
            padding: 15px 25px;
            border-radius: 25px;
            font-weight: bold;
            z-index: 10002;
            animation: successPop 1.5s ease;
            box-shadow: 0 4px 20px rgba(40, 167, 69, 0.4);
        `;
        
        document.body.appendChild(successPopup);
        
        setTimeout(() => {
            successPopup.remove();
        }, 1500);
    }
    
    showInstruction(target, text, position) {
        const instruction = document.createElement('div');
        instruction.className = 'onboarding-instruction';
        instruction.textContent = text;
        
        document.body.appendChild(instruction);
        
        // Position instruction relative to target
        const targetRect = target.getBoundingClientRect();
        let top, left;
        
        switch(position) {
            case 'top':
                top = targetRect.top - instruction.offsetHeight - 20;
                left = targetRect.left + (targetRect.width / 2) - (instruction.offsetWidth / 2);
                break;
            case 'bottom':
                top = targetRect.bottom + 20;
                left = targetRect.left + (targetRect.width / 2) - (instruction.offsetWidth / 2);
                break;
            case 'left':
                top = targetRect.top + (targetRect.height / 2) - (instruction.offsetHeight / 2);
                left = targetRect.left - instruction.offsetWidth - 20;
                break;
            case 'right':
                top = targetRect.top + (targetRect.height / 2) - (instruction.offsetHeight / 2);
                left = targetRect.right + 20;
                break;
            default:
                top = targetRect.top - instruction.offsetHeight - 20;
                left = targetRect.left + (targetRect.width / 2) - (instruction.offsetWidth / 2);
        }
        
        instruction.style.top = Math.max(10, top) + 'px';
        instruction.style.left = Math.max(10, Math.min(window.innerWidth - instruction.offsetWidth - 10, left)) + 'px';
        
        // Store for cleanup
        this._currentInstruction = instruction;
    }
    
    positionModal(target, position) {
        const modal = this.overlay.querySelector('.onboarding-content');
        
        if (!target || position === 'center') {
            // Center the modal
            modal.style.position = 'fixed';
            modal.style.top = '50%';
            modal.style.left = '50%';
            modal.style.transform = 'translate(-50%, -50%)';
            return;
        }
        
        const targetRect = target.getBoundingClientRect();
        const modalRect = modal.getBoundingClientRect();
        
        let top, left;
        
        switch(position) {
            case 'right':
                top = targetRect.top + (targetRect.height / 2) - (modalRect.height / 2);
                left = targetRect.right + 20;
                break;
            case 'left':
                top = targetRect.top + (targetRect.height / 2) - (modalRect.height / 2);
                left = targetRect.left - modalRect.width - 20;
                break;
            case 'bottom':
                top = targetRect.bottom + 20;
                left = targetRect.left + (targetRect.width / 2) - (modalRect.width / 2);
                break;
            case 'top':
                top = targetRect.top - modalRect.height - 20;
                left = targetRect.left + (targetRect.width / 2) - (modalRect.width / 2);
                break;
            default:
                return; // Keep center position
        }
        
        // Ensure modal stays within viewport
        top = Math.max(20, Math.min(window.innerHeight - modalRect.height - 20, top));
        left = Math.max(20, Math.min(window.innerWidth - modalRect.width - 20, left));
        
        modal.style.position = 'fixed';
        modal.style.top = top + 'px';
        modal.style.left = left + 'px';
        modal.style.transform = 'none';
    }
    
    clearInstructions() {
        if (this._currentInstruction) {
            this._currentInstruction.remove();
            this._currentInstruction = null;
        }
    }
    
    nextStep() {
        if (this.currentStep < this.steps.length - 1) {
            this.currentStep++;
            this.showStep();
        }
    }
    
    prevStep() {
        if (this.currentStep > 0) {
            this.currentStep--;
            this.showStep();
        }
    }
    
    async completeTour() {
        this.clearHighlights();
        this.overlay.style.display = 'none';
        this.isActive = false;
        document.body.style.overflow = '';
        
        // Mark onboarding as completed
        await this.markAsCompleted();
        
        // Show success message
        this.showSuccessMessage();
    }
    
    skipTour() {
        if (confirm('Are you sure you want to skip the tour? You can access it later from the help button.')) {
            this.clearHighlights();
            this.overlay.style.display = 'none';
            this.isActive = false;
            document.body.style.overflow = '';
        }
    }
    
    clearHighlights() {
        // Remove all highlight classes and effects
        document.querySelectorAll('.onboarding-highlight, .onboarding-interactive').forEach(el => {
            el.classList.remove('onboarding-highlight', 'onboarding-interactive');
            el.style.animation = '';
            
            // Remove click handlers
            if (el._onboardingClickHandler) {
                el.removeEventListener('click', el._onboardingClickHandler);
                delete el._onboardingClickHandler;
            }
        });
        
        // Clear instructions
        this.clearInstructions();
    }
    
    scrollToTarget(target) {
        // Smooth scroll to target with offset
        const rect = target.getBoundingClientRect();
        const offset = window.innerHeight * 0.3;
        
        window.scrollTo({
            top: window.scrollY + rect.top - offset,
            behavior: 'smooth'
        });
    }
    
    async checkOnboardingStatus() {
        try {
            const response = await fetch('/onboarding/status?type=' + this.type, {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            return await response.json();
        } catch (error) {
            console.error('Error checking onboarding status:', error);
            return { completed: false };
        }
    }
    
    async markAsCompleted() {
        try {
            const endpoint = this.type === 'customer' 
                ? '/onboarding/complete-customer'
                : '/onboarding/complete-professional';
                
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const result = await response.json();
            console.log('Onboarding completed:', result);
        } catch (error) {
            console.error('Error marking onboarding as completed:', error);
        }
    }
    
    showSuccessMessage() {
        // Create a temporary success notification
        const notification = document.createElement('div');
        notification.className = 'alert alert-success';
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10001;
            padding: 16px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            animation: slideInRight 0.5s ease;
        `;
        notification.innerHTML = `
            <strong>🎉 Welcome aboard!</strong> You've completed the tour. 
            You can restart it anytime using the help button in the bottom right.
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 5000);
    }
}

// Global function to restart onboarding
function restartOnboarding() {
    if (window.onboardingTour) {
        window.onboardingTour.start();
    }
}
</script>