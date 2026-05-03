<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('messages.Reservations Calendar') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('messages.View all reservations in calendar format') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.button variant="secondary" href="{{ route('reservations.index') }}" size="md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                {{ __('messages.List View') }}
            </x-ui.button>
            <x-ui.button variant="primary" href="{{ route('reservations.create') }}" size="md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                {{ __('messages.New Reservation') }}
            </x-ui.button>
        </div>
    </header>

    <!-- Calendar Legend -->
    <div class="glass-card rounded-2xl p-4 mb-6">
        <div class="flex flex-wrap items-center gap-6">
            <div class="flex items-center gap-2">
                <div class="h-3 w-3 rounded-full bg-accent-amber"></div>
                <span class="text-sm font-medium">{{ __('messages.Pending') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="h-3 w-3 rounded-full bg-accent-emerald"></div>
                <span class="text-sm font-medium">{{ __('messages.Approved') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="h-3 w-3 rounded-full bg-accent-cyan"></div>
                <span class="text-sm font-medium">{{ __('messages.Completed') }}</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="h-3 w-3 rounded-full bg-accent-rose"></div>
                <span class="text-sm font-medium">{{ __('messages.Rejected/Cancelled') }}</span>
            </div>
        </div>
    </div>

    <!-- Calendar Container -->
    <div class="glass-card rounded-2xl p-6">
        <div id="calendar"></div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <style>
        /* FullCalendar custom styling */
        #calendar {
            font-family: inherit;
        }

        .fc {
            background: transparent;
        }

        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: inherit;
        }

        .fc .fc-button {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: #3f3f46;
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            text-transform: capitalize;
            font-weight: 500;
            transition: all 0.2s;
        }

        .dark .fc .fc-button {
            background: rgba(37, 37, 50, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #e4e4e7;
        }

        .fc .fc-button:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(0, 0, 0, 0.2);
        }

        .dark .fc .fc-button:hover {
            background: rgba(37, 37, 50, 0.95);
            border-color: rgba(255, 255, 255, 0.2);
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            border-color: transparent;
            color: white;
        }

        .fc .fc-daygrid-day-number,
        .fc .fc-col-header-cell-cushion {
            color: inherit;
            text-decoration: none;
        }

        .fc .fc-day-today {
            background: rgba(245, 158, 11, 0.1) !important;
        }

        .dark .fc-theme-standard td,
        .dark .fc-theme-standard th {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .fc-theme-standard td,
        .fc-theme-standard th {
            border-color: rgba(0, 0, 0, 0.1);
        }

        .fc .fc-event {
            border-radius: 0.375rem;
            padding: 2px 4px;
            font-size: 0.75rem;
            border: none;
            cursor: pointer;
        }

        .fc .fc-event:hover {
            opacity: 0.8;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js" data-turbo-track="reload"></script>
    <script>
        let calendarInstance = null;

        function initializeCalendar() {
            const calendarEl = document.getElementById('calendar');

            if (!calendarEl) return;

            // Check if FullCalendar is loaded
            if (typeof FullCalendar === 'undefined') {
                console.log('FullCalendar not loaded yet, retrying...');
                setTimeout(initializeCalendar, 100);
                return;
            }

            // Destroy existing calendar instance if it exists
            if (calendarInstance) {
                calendarInstance.destroy();
            }

            // Clear any existing content
            calendarEl.innerHTML = '';

            calendarInstance = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                direction: '{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}',
                locale: '{{ app()->getLocale() }}',
                buttonText: {
                    today: '{{ __('messages.Today') }}',
                    month: '{{ __('messages.Month') }}',
                    week: '{{ __('messages.Week') }}',
                    list: '{{ __('messages.List') }}'
                },
                height: 'auto',
                events: function(info, successCallback, failureCallback) {
                    fetch('{{ route('reservations.calendar.data') }}')
                        .then(response => response.json())
                        .then(data => successCallback(data))
                        .catch(error => {
                            console.error('Error fetching calendar data:', error);
                            failureCallback(error);
                        });
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    window.Turbo.visit('/reservations/' + info.event.id);
                },
                eventDidMount: function(info) {
                    // Add custom styling based on status
                    const status = info.event.extendedProps.status;
                    let bgColor = '#3B82F6';

                    switch(status) {
                        case 'pending':
                            bgColor = '#f59e0b'; // amber
                            break;
                        case 'approved':
                            bgColor = '#10b981'; // emerald
                            break;
                        case 'completed':
                            bgColor = '#06b6d4'; // cyan
                            break;
                        case 'rejected':
                        case 'cancelled':
                            bgColor = '#f43f5e'; // rose
                            break;
                    }

                    info.el.style.backgroundColor = bgColor;
                    info.el.style.borderColor = bgColor;
                }
            });

            calendarInstance.render();
        }

        // Initialize on turbo:load
        document.addEventListener('turbo:load', initializeCalendar);

        // Cleanup before caching
        document.addEventListener('turbo:before-cache', function() {
            if (calendarInstance) {
                calendarInstance.destroy();
                calendarInstance = null;
            }
        });
    </script>
    @endpush
</x-app-layout>
