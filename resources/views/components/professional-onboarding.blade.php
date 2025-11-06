<!-- Professional Onboarding Steps -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const professionalOnboardingSteps = [
        {
            title: "Welcome to Your Professional Dashboard! 💼",
            message: "Welcome aboard! As a professional on our platform, you have access to powerful tools to manage your services, clients, and business. Let's explore your dashboard together!",
            target: null,
            position: 'center'
        },
        {
            title: "📊 Dashboard Overview",
            message: "This is your business command center! View key metrics, recent bookings, revenue summaries, and quick actions. Monitor your business performance at a glance.",
            target: ".dashboard-stats, .overview-cards, .main-content, .dashboard-content",
            action: 'pulse',
            instruction: 'Your main business dashboard'
        },
        {
            title: "🧭 Navigation & Menu",
            message: "Your main navigation is here. Click on different menu items to access all professional tools including your profile, services, bookings, availability, billing, and more.",
            target: ".sidebar, .app-sidebar, .nav-sidebar",
            interactive: true,
            instruction: 'Click on any menu item to explore',
            position: 'right'
        },
        {
            title: "👤 Professional Profile",
            message: "Your professional profile is crucial for attracting clients. Click here to add your qualifications, experience, photos, and detailed service descriptions.",
            target: "[href*='profile'], .profile-section, a:contains('Profile')",
            interactive: true,
            instruction: 'Click to set up your profile',
            position: 'right'
        },
        {
            title: "🛠️ Service Management",
            message: "Manage all your services here. Click to add new services, set pricing, update descriptions, and manage service categories.",
            target: "[href*='service'], .service-management, a:contains('Service')",
            interactive: true,
            instruction: 'Click to manage your services',
            position: 'right'
        },
        {
            title: "📅 Availability & Scheduling",
            message: "Set your working hours and availability here. Click to manage when clients can book with you and avoid scheduling conflicts.",
            target: "[href*='availability'], .availability-section, a:contains('Availability')",
            interactive: true,
            instruction: 'Click to set your availability',
            position: 'right'
        },
        {
            title: "📋 Booking Management",
            message: "All your client bookings appear here. Click to accept or decline requests, manage schedules, and communicate with clients.",
            target: "[href*='booking'], .booking-management, a:contains('Booking')",
            interactive: true,
            instruction: 'Click to manage bookings',
            position: 'right'
        },
        {
            title: "💰 Billing & Earnings",
            message: "Track your earnings and view payment history here. Click to monitor your revenue trends and download financial reports.",
            target: "[href*='billing'], [href*='earning'], .billing-section, a:contains('Billing'), a:contains('Earning')",
            interactive: true,
            instruction: 'Click to view earnings',
            position: 'right'
        },
        {
            title: "⭐ Reviews & Ratings",
            message: "Monitor client feedback and maintain your reputation. Click here to view reviews and respond to client feedback professionally.",
            target: "[href*='review'], .reviews-section, a:contains('Review')",
            interactive: true,
            instruction: 'Click to view reviews',
            position: 'right'
        },
        {
            title: "🔔 Notifications",
            message: "Stay updated with new bookings, messages, and important updates. Check your notifications regularly to never miss important information.",
            target: ".notification, .alert, [class*='notification'], .dropdown-toggle[data-toggle='dropdown']",
            action: 'pulse',
            instruction: 'Your notifications appear here'
        },
        {
            title: "🌟 Ready to Succeed!",
            message: "Excellent! You're now ready to manage your professional business on our platform. Complete your profile, add your services, and start receiving bookings. Success awaits you!",
            target: null,
            position: 'center'
        }
    ];

    // Initialize professional onboarding
    window.professionalOnboardingTour = new OnboardingTour(professionalOnboardingSteps, 'professional');
    
    // Auto-start onboarding for new users
    setTimeout(() => {
        window.professionalOnboardingTour.start();
    }, 1000);
});
</script>

<!-- Help Button -->
<button class="onboarding-help-btn professional-help-btn" onclick="restartOnboarding()" title="Take a tour of your professional dashboard">
    <i class="fas fa-question"></i>
</button>

<style>
/* Professional-specific styling */
.professional-onboarding .onboarding-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.professional-help-btn {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.professional-help-btn:hover {
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

/* Ensure proper highlighting for professional dashboard elements */
.dashboard-stats .stat-card:hover {
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

.sidebar .nav-item:hover {
    background-color: rgba(102, 126, 234, 0.1);
    transition: all 0.3s ease;
}

/* Professional dashboard card enhancements */
.overview-cards .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
}

/* Service management highlights */
.service-management .service-item:hover {
    background-color: rgba(102, 126, 234, 0.05);
    transition: all 0.3s ease;
}
</style>