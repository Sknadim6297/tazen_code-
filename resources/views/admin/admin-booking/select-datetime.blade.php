    @extends('admin.layouts.layout')

    @section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .datetime-card {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            background: #fafbfc;
            transition: all 0.3s ease;
        }

        .datetime-card.selected {
            border-color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .slot-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 10px;
            margin-top: 15px;
        }

        .slot-option {
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .slot-option:hover {
            border-color: #667eea;
            background: #f0f2ff;
        }

        .slot-option.selected {
            border-color: #667eea;
            background: #667eea;
            color: white;
        }

        .slot-option.booked {
            background: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .slot-option.booked:hover {
            background: #f8d7da;
            border-color: #dc3545;
            transform: none;
        }

        .slot-option.available {
            border-color: #28a745;
            background: #d4edda;
            color: #155724;
        }

        .slot-option.available:hover {
            background: #28a745;
            color: white;
            border-color: #28a745;
        }

        .selected-bookings {
            background: #e3f2fd;
            border-radius: 8px;
            padding: 15px;
            margin-top: 20px;
        }

        .booking-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background: white;
            border-radius: 5px;
            margin-bottom: 8px;
            border-left: 4px solid #667eea;
        }

        .remove-booking {
            background: none;
            border: none;
            color: #dc3545;
            cursor: pointer;
            font-size: 18px;
        }

        .calendar-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Calendar date styling */
        .flatpickr-day.has-slots {
            background: #d4edda !important;
            border-color: #28a745 !important;
            color: #155724 !important;
        }

        .flatpickr-day.has-slots:hover {
            background: #28a745 !important;
            color: white !important;
        }

        .flatpickr-day.no-slots {
            background: #f8d7da !important;
            border-color: #dc3545 !important;
            color: #721c24 !important;
        }

        .flatpickr-day.no-slots:hover {
            background: #dc3545 !important;
            color: white !important;
        }
    </style>
    </style>
    @endsection

    @section('content')
    <div class="main-content app-content">
        <div class="container-fluid">
            <!-- Page Header -->
            <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
                <div>
                    <h1 class="page-title fw-medium fs-18 mb-2">Select Date & Time</h1>
                    <div>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.admin-booking.index') }}">Admin Bookings</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Select Date & Time</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Progress Steps -->
            <div class="card custom-card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success rounded-pill me-2">1</span>
                            <span class="text-success fw-semibold">Customer Selected</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success rounded-pill me-2">2</span>
                            <span class="text-success fw-semibold">Service Selected</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success rounded-pill me-2">3</span>
                            <span class="text-success fw-semibold">Professional Selected</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-success rounded-pill me-2">4</span>
                            <span class="text-success fw-semibold">Session Selected</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-primary rounded-pill me-2">5</span>
                            <span class="text-primary fw-semibold">Select Date & Time</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-secondary rounded-pill me-2">6</span>
                            <span class="text-muted">Confirm</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selected Session Info -->
            <div class="card custom-card mb-4">
                <div class="card-header">
                    <div class="card-title">
                        <i class="ri-calendar-check-line me-2"></i>Selected Session
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-1">{{ $selectedRate->session_type ?? 'Session' }}</h6>
                            <p class="mb-0 text-muted">{{ $selectedRate->num_sessions ?? 1 }} session(s) • {{ $selectedRate->duration ?? '60 mins' }}</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h5 class="text-primary mb-0">Rs. {{ number_format($selectedRate->final_rate ?? 0, 2) }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Date & Time Selection -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="ri-calendar-line me-2"></i>Select Date
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="calendar-container">
                                <input type="text" id="calendar" class="form-control" placeholder="Select date" readonly>
                                
                                <!-- Calendar Legend -->
                                <div class="mt-3">
                                    <small class="text-muted d-block mb-2"><strong>Legend:</strong></small>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 15px; height: 15px; background: #d4edda; border: 1px solid #28a745; border-radius: 3px; margin-right: 5px;"></div>
                                            <small class="text-muted">Available slots</small>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div style="width: 15px; height: 15px; background: #f8d7da; border: 1px solid #dc3545; border-radius: 3px; margin-right: 5px;"></div>
                                            <small class="text-muted">No available slots</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card custom-card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="ri-time-line me-2"></i>Available Time Slots
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="slots-container">
                                <p class="text-muted">Please select a date first</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Selected Bookings -->
            <div class="card custom-card" id="selected-bookings-card" style="display: none;">
                <div class="card-header">
                    <div class="card-title">
                        <i class="ri-bookmark-line me-2"></i>Selected Bookings
                    </div>
                </div>
                <div class="card-body">
                    <div id="selected-bookings"></div>
                    
                    <form method="POST" action="{{ route('admin.admin-booking.store-datetime-selection') }}" id="datetime-form">
                        @csrf
                        <input type="hidden" name="booking_dates" id="booking-dates-input">
                        
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="next_btn" disabled>
                                    <i class="ri-arrow-right-line me-1"></i>Next: Confirm Booking
                                </button>
                                <a href="{{ route('admin.admin-booking.select-session') }}" class="btn btn-secondary ms-2">
                                    <i class="ri-arrow-left-line me-1"></i>Back
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectedBookings = [];
        const professionalId = {{ $professional->id ?? 'null' }};
        const nextBtn = document.getElementById('next_btn');
        const selectedBookingsCard = document.getElementById('selected-bookings-card');
        const selectedBookingsContainer = document.getElementById('selected-bookings');
        const bookingDatesInput = document.getElementById('booking-dates-input');
        
        // Check if professional ID is valid
        if (!professionalId) {
            console.error('Professional ID is missing');
            document.getElementById('slots-container').innerHTML = '<p class="text-danger">Error: Professional not found</p>';
            return;
        }
        
        // Professional's enabled dates from server
        const enabledDates = {!! json_encode($enabledDates ?? []) !!};
        const existingBookings = {!! json_encode($existingBookings ?? []) !!};
        let dateSlotAvailability = {}; // Store slot availability for each date

        console.log('Enabled dates from server:', enabledDates);
        console.log('Professional ID:', professionalId);

        // Initialize Flatpickr with professional's availability
        try {
            console.log('Initializing Flatpickr...');
            
            // Normalize enabled dates to YYYY-MM-DD format
            const normalizedEnabledDates = Array.isArray(enabledDates) ? enabledDates.filter(date => date && typeof date === 'string') : [];
            
            // Create safe date boundaries
            const today = new Date();
            const maxDate = new Date();
            maxDate.setDate(today.getDate() + 90); // 90 days from today

            // Flatpickr config with proper date filtering
            const fp = flatpickr("#calendar", {
                inline: true,
                minDate: today,
                maxDate: maxDate,
                dateFormat: "Y-m-d",
                // Only enable dates that are in the professional's availability
                enable: normalizedEnabledDates.length > 0 ? normalizedEnabledDates.map(date => new Date(date)) : undefined,
                onChange: function(selectedDates, dateStr) {
                    console.log('Date selected:', dateStr);
                    if (dateStr) {
                        loadAvailableSlots(dateStr);
                    }
                },
                onDayCreate: function(dObj, dStr, fp, dayElem) {
                    const dateStr = dayElem.dateObj.toISOString().split('T')[0];
                    
                    // Only check slots for enabled dates
                    if (normalizedEnabledDates.includes(dateStr) && dayElem.dateObj >= today) {
                        // Mark as available initially, will be updated by slot check
                        dayElem.classList.add('has-slots');
                        dayElem.title = 'Available for booking';
                    }
                }
            });

            console.log('Flatpickr initialized successfully');
            
        } catch (error) {
            console.error('Flatpickr initialization failed:', error);
            
            // Fallback: Use a simple HTML date input
            const calendarElement = document.getElementById('calendar');
            if (calendarElement) {
                calendarElement.type = 'date';
                calendarElement.min = new Date().toISOString().split('T')[0];
                
                const maxDate = new Date();
                maxDate.setDate(maxDate.getDate() + 90);
                calendarElement.max = maxDate.toISOString().split('T')[0];
                
                calendarElement.addEventListener('change', function() {
                    if (this.value) {
                        loadAvailableSlots(this.value);
                    }
                });
                
                console.log('Fallback date input initialized');
            }
        }

        // Load available slots for selected date
        function loadAvailableSlots(date) {
            console.log('Loading slots for date:', date);
            const slotsContainer = document.getElementById('slots-container');
            slotsContainer.innerHTML = '<div class="text-center"><i class="ri-loader-line fa-spin"></i> Loading slots...</div>';

            fetch(`{{ route('admin.admin-booking.get-available-slots') }}?date=${date}&professional_id=${professionalId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Slots data:', data);
                    displaySlots(data, date);
                })
                .catch(error => {
                    console.error('Error loading slots:', error);
                    slotsContainer.innerHTML = '<div class="alert alert-danger">Error loading time slots. Please try again.</div>';
                });
        }

        // Display available time slots
        function displaySlots(data, date) {
            const slotsContainer = document.getElementById('slots-container');
            
            if (data.available_slots && data.available_slots.length === 0) {
                let message = data.message || 'No available slots for this date';
                slotsContainer.innerHTML = `<p class="text-muted">${message}</p>`;
                return;
            }

            let slotsHtml = '<div class="slot-grid">';
            
            // Show all slots (available + booked) for better UX
            const allSlots = data.all_slots || [];
            const availableSlots = data.available_slots || [];
            const bookedSlots = data.booked_slots || [];
            
            allSlots.forEach(slot => {
                const isBooked = bookedSlots.includes(slot);
                const isAvailable = availableSlots.includes(slot);
                
                let slotClass = 'slot-option';
                let clickHandler = '';
                
                if (isBooked) {
                    slotClass += ' booked';
                } else if (isAvailable) {
                    slotClass += ' available';
                    clickHandler = `onclick="selectSlot('${date}', '${slot}')"`;
                }
                
                slotsHtml += `
                    <div class="${slotClass}" ${clickHandler} data-date="${date}" data-slot="${slot}">
                        ${slot}
                        ${isBooked ? '<small class="d-block text-danger mt-1"><i class="ri-close-circle-line"></i> Booked</small>' : ''}
                        ${isAvailable && !isBooked ? '<small class="d-block text-success mt-1"><i class="ri-check-circle-line"></i> Available</small>' : ''}
                    </div>
                `;
            });
            
            slotsHtml += '</div>';
            slotsContainer.innerHTML = slotsHtml;
        }

        // Select a time slot
        window.selectSlot = function(date, slot) {
            // Check if already selected
            const existingIndex = selectedBookings.findIndex(b => b.date === date && b.time_slot === slot);
            if (existingIndex === -1) {
                addBooking(date, slot);
            }
        };

        // Add a booking
        function addBooking(date, timeSlot) {
            selectedBookings.push({ date, time_slot: timeSlot });
            updateSelectedBookingsDisplay();
            updateFormData();
        }

        // Remove a booking
        function removeBooking(index) {
            selectedBookings.splice(index, 1);
            updateSelectedBookingsDisplay();
            updateFormData();
        }

        // Update the display of selected bookings
        function updateSelectedBookingsDisplay() {
            if (selectedBookings.length === 0) {
                selectedBookingsCard.style.display = 'none';
                nextBtn.disabled = true;
                return;
            }

            selectedBookingsCard.style.display = 'block';
            nextBtn.disabled = false;

            let html = '';
            selectedBookings.forEach((booking, index) => {
                const formattedDate = new Date(booking.date).toLocaleDateString('en-US', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                html += `
                    <div class="booking-item">
                        <span>${formattedDate} at ${booking.time_slot}</span>
                        <button type="button" class="remove-booking" onclick="removeBooking(${index})">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                `;
            });

            selectedBookingsContainer.innerHTML = html;
        }

        // Update form data
        function updateFormData() {
            bookingDatesInput.value = JSON.stringify(selectedBookings);
        }

        // Make removeBooking function globally accessible
        window.removeBooking = removeBooking;

        // Form submission
        document.getElementById('datetime-form').addEventListener('submit', function(e) {
            if (selectedBookings.length === 0) {
                e.preventDefault();
                alert('Please select at least one date and time slot');
            }
        });
    });
    </script>
    @endsection