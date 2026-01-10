<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Reservations Calendar') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    {{ __('View all reservations in calendar format') }}
                </p>
            </div>
            <div class="flex space-x-3 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                <a href="{{ route('reservations.index') }}">
                    <x-button variant="outline">
                        <svg class="h-5 w-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                        {{ __('List View') }}
                    </x-button>
                </a>
                <a href="{{ route('reservations.create') }}">
                    <x-button variant="primary">
                        <svg class="h-5 w-5 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        {{ __('New Reservation') }}
                    </x-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Calendar Legend -->
        <x-card class="mb-6">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                    <div class="h-4 w-4 rounded bg-yellow-500"></div>
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Pending') }}</span>
                </div>
                <div class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                    <div class="h-4 w-4 rounded bg-green-500"></div>
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Approved') }}</span>
                </div>
                <div class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                    <div class="h-4 w-4 rounded bg-blue-500"></div>
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Completed') }}</span>
                </div>
                <div class="flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                    <div class="h-4 w-4 rounded bg-red-500"></div>
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('Rejected/Cancelled') }}</span>
                </div>
            </div>
        </x-card>

        <!-- Calendar Container -->
        <x-card>
            <div id="calendar"></div>
        </x-card>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,listWeek'
                },
                direction: '{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}',
                locale: '{{ app()->getLocale() }}',
                buttonText: {
                    today: '{{ __('Today') }}',
                    month: '{{ __('Month') }}',
                    week: '{{ __('Week') }}',
                    list: '{{ __('List') }}'
                },
                events: '/reservations/calendar/data',
                eventClick: function(info) {
                    window.location.href = '/reservations/' + info.event.id;
                },
                eventClassNames: function(arg) {
                    return ['cursor-pointer', 'hover:opacity-80', 'transition-opacity'];
                },
                eventColor: '#3B82F6',
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                }
            });
            calendar.render();
        });
    </script>
    @endpush
</x-app-layout>
