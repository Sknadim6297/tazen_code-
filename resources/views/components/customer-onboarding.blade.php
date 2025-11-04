<!-- Customer Onboarding Steps -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const customerOnboardingSteps = [
        {
            title: "Welcome to Your Customer Dashboard! 🎉",
            message: "Hi there! Welcome to your personal dashboard. Let's take a quick step-by-step tour to help you navigate and use all the features. This will only take a few minutes!",
            target: null,
            position: "center"
        },
        {
            title: "Step 1: Your Navigation Menu 📋",
            message: "This is your main navigation sidebar. Here you can access all important sections. Let's explore each section step by step. Click 'Next' to continue.",
            target: ".sidebar, .app-sidebar, nav.sidebar",
            position: "right",
            action: "highlight"
        },
        {
            title: "Step 2: Dashboard Overview 📊",
            message: "These cards show your quick stats - upcoming appointments, total appointments, events, and payments. Click on any card to go to that section. Try clicking on 'Upcoming Appointments' card!",
            target: ".card-grid, .dashboard-cards",
            position: "center",
            action: "highlight",
            interactive: true,
            clickTarget: "[href*='upcoming-appointment'], .card:first-child"
        },
        {
            title: "Step 3: Profile Management 👤",
            message: "Your profile is very important! Click on 'Profile' or 'Add Profile' in the sidebar to manage your personal information, preferences, and account settings.",
            target: "[href*='add-profile'], [href*='profile'], .nav-link:contains('Profile')",
            position: "right",
            action: "pulse",
            interactive: true,
            instruction: "Click here to manage your profile →"
        },
        {
            title: "Step 4: Booking Services 🔍",
            message: "Ready to book a service? You can book appointments in multiple ways: 1) From the homepage 2) Click 'Book Service' if available 3) Browse professionals. Let's see how!",
            target: "[href*='booking'], .booking-card, .book-service-btn",
            position: "center",
            action: "highlight",
            instruction: "This is where you can book new services"
        },
        {
            title: "Step 5: Your Appointments 📅",
            message: "Click 'Upcoming Appointments' in the sidebar to view, manage, and track all your scheduled appointments. You can reschedule, cancel, or add notes here.",
            target: "[href*='upcoming-appointment'], .nav-link:contains('Appointment')",
            position: "right",
            action: "pulse",
            interactive: true,
            instruction: "Click here to view your appointments →"
        },
        {
            title: "Step 6: Appointment History 📋",
            message: "Want to see your past appointments? Click 'All Appointments' or 'Appointment History' to view completed sessions, download reports, and rate your experiences.",
            target: "[href*='all-appointment'], [href*='appointment'], .nav-link:contains('History')",
            position: "right",
            action: "highlight",
            instruction: "View your appointment history here"
        },
        {
            title: "Step 7: Events & Workshops 🎪",
            message: "Explore upcoming events and workshops! Click 'Events' in the sidebar to browse, register, and manage your event bookings.",
            target: "[href*='event'], .nav-link:contains('Event')",
            position: "right",
            action: "pulse",
            interactive: true,
            instruction: "Click here to explore events →"
        },
        {
            title: "Step 8: Billing & Payments 💳",
            message: "Track your payments and manage billing information. Click 'Billing' in the sidebar to view invoices, payment history, and download receipts.",
            target: "[href*='billing'], .nav-link:contains('Billing')",
            position: "right",
            action: "highlight",
            instruction: "Manage your payments and billing here"
        },
        {
            title: "Perfect! You're Ready to Go! 🚀",
            message: "Congratulations! You now know how to use your dashboard effectively. Remember: \n\n• Complete your profile first\n• Browse and book services\n• Check appointments regularly\n• Explore events and workshops\n\nThe help button (?) is always available if you need this tour again!",
            target: null,
            position: "center"
        }
    ];

    // Initialize customer onboarding with enhanced features
    window.customerOnboardingTour = new OnboardingTour(customerOnboardingSteps, 'customer');
    
    // Auto-start onboarding for new users with a slight delay
    setTimeout(() => {
        window.customerOnboardingTour.start();
    }, 1500);
});
</script>

<!-- Help Button -->
<button class="onboarding-help-btn" onclick="restartOnboarding()" title="Take a tour of your dashboard">
    <i class="fas fa-question"></i>
</button>

<style>
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Customer-specific styling */
.customer-onboarding .onboarding-header {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.customer-onboarding .onboarding-help-btn {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

/* Enhanced highlighting effects */
.onboarding-highlight {
    animation: onboardingGlow 2s infinite alternate, onboardingPulse 3s infinite !important;
}

@keyframes onboardingPulse {
    0%, 100% { 
        transform: scale(1);
        box-shadow: 0 0 0 4px rgba(240, 147, 251, 0.5), 0 0 20px rgba(240, 147, 251, 0.3);
    }
    50% { 
        transform: scale(1.02);
        box-shadow: 0 0 0 8px rgba(240, 147, 251, 0.7), 0 0 30px rgba(240, 147, 251, 0.5);
    }
}

/* Interactive element styling */
.onboarding-interactive {
    cursor: pointer !important;
    position: relative;
}

.onboarding-interactive::after {
    content: '👆 Click me!';
    position: absolute;
    top: -30px;
    left: 50%;
    transform: translateX(-50%);
    background: #fff;
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    animation: bounce 2s infinite;
    z-index: 10001;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
    40% { transform: translateX(-50%) translateY(-10px); }
    60% { transform: translateX(-50%) translateY(-5px); }
}

/* Ensure proper highlighting for customer dashboard elements */
.card-grid .card {
    transition: all 0.3s ease;
}

.card-grid .card:hover {
    transform: translateY(-2px);
}

.sidebar-item, .nav-link {
    transition: all 0.3s ease;
}

.sidebar-item:hover, .nav-link:hover {
    background-color: rgba(240, 147, 251, 0.1);
}

/* Instruction pointer */
.onboarding-instruction {
    position: absolute;
    background: #f093fb;
    color: white;
    padding: 8px 12px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    z-index: 10000;
    animation: instructionPulse 2s infinite;
    box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
}

@keyframes instructionPulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.05); opacity: 0.9; }
}

.onboarding-instruction::before {
    content: '';
    position: absolute;
    width: 0;
    height: 0;
    border: 8px solid transparent;
    border-top-color: #f093fb;
    bottom: -16px;
    left: 20px;
}
</style>