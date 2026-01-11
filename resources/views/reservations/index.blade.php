<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('My Reservations') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Manage your equipment reservations') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <!-- Filter Button -->
            <button @click="$dispatch('open-modal', 'filter-modal')" class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span class="hidden sm:inline">{{ __('Filter') }}</span>
                @if(request()->has('search') || request()->has('filter'))
                    <span class="w-2 h-2 rounded-full bg-accent-amber"></span>
                @endif
            </button>

            <a href="{{ route('reservations.calendar') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="hidden sm:inline">{{ __('Calendar View') }}</span>
            </a>
            <a href="{{ route('reservations.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('New Reservation') }}
            </a>
        </div>
    </header>

    <!-- Filter Modal -->
    <x-modal name="filter-modal" :show="false" maxWidth="lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold">{{ __('Filter Reservations') }}</h2>
                <button @click="$dispatch('close-modal', 'filter-modal')" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-surface-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="GET" action="{{ route('reservations.index') }}" class="space-y-4">
                <!-- Search Input -->
                <div>
                    <label for="modal-search" class="block text-sm font-medium mb-2">{{ __('Search') }}</label>
                    <input
                        type="text"
                        name="search"
                        id="modal-search"
                        value="{{ request('search') }}"
                        placeholder="{{ __('Search by material, user, or purpose...') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                    >
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="modal-filter" class="block text-sm font-medium mb-2">{{ __('Status') }}</label>
                    <select
                        name="filter"
                        id="modal-filter"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                    >
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="pending" {{ request('filter') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="approved" {{ request('filter') == 'approved' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                        <option value="rejected" {{ request('filter') == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                        <option value="completed" {{ request('filter') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="cancelled" {{ request('filter') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                        <option value="my" {{ request('filter') == 'my' ? 'selected' : '' }}>{{ __('My Reservations Only') }}</option>
                    </select>
                </div>

                <div class="flex items-center justify-between gap-3 pt-4 border-t border-black/5 dark:border-white/5">
                    <a href="{{ route('reservations.index') }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                        {{ __('Clear Filters') }}
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-accent-amber to-accent-coral text-white text-sm font-medium hover:opacity-90 transition-opacity">
                        {{ __('Apply Filters') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Results Count -->
    @if(isset($reservations))
        <div class="glass-card rounded-xl px-4 py-3 mb-6">
            <div class="flex items-center justify-between text-sm">
                <span class="text-zinc-500 dark:text-zinc-400">
                    {{ __('Found') }} <span class="font-semibold text-zinc-800 dark:text-white">{{ $reservations->total() }}</span> {{ __('reservations') }}
                </span>
                @if(request()->has('search') || request()->has('filter'))
                    <a href="{{ route('reservations.index') }}" class="text-accent-rose hover:underline">
                        {{ __('Clear all filters') }}
                    </a>
                @endif
            </div>
        </div>
    @endif

    <!-- Active Reservations Alert -->
    @if(isset($activeReservationsLimit))
        <div class="glass-card rounded-2xl p-4 mb-6 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4 border-accent-cyan">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 text-accent-cyan flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm">
                    {{ __('You have') }} <strong class="font-semibold">{{ $activeReservationsCount ?? 0 }}</strong> {{ __('active reservations out of maximum') }} <strong class="font-semibold">{{ $activeReservationsLimit }}</strong>.
                </p>
            </div>
        </div>
    @endif

    <!-- Reservations Table -->
    @if(isset($reservations) && $reservations->count() > 0)
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-surface-800/50">
                        <tr>
                            <th class="px-4 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">
                                {{ __('Material') }}
                            </th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">
                                {{ __('User') }}
                            </th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">
                                {{ __('Period') }}
                            </th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">
                                {{ __('Quantity') }}
                            </th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">
                                {{ __('Status') }}
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5">
                        @foreach($reservations as $reservation)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-surface-800/30 transition-colors">
                                <!-- Material -->
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-lg overflow-hidden bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-surface-700 dark:to-surface-600 flex-shrink-0">
                                            @if($reservation->material?->image)
                                                <img src="{{ asset('storage/' . $reservation->material->image) }}" alt="{{ $reservation->material->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="flex items-center justify-center h-full">
                                                    <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <a href="{{ route('materials.show', $reservation->material) }}" class="font-semibold hover:text-accent-amber transition-colors">
                                                {{ $reservation->material?->name ?? __('Material') }}
                                            </a>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                {{ $reservation->material?->category->name ?? __('Uncategorized') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <!-- User -->
                                <td class="px-4 py-3">
                                    <span class="text-sm">{{ $reservation->user?->name ?? __('Unknown') }}</span>
                                </td>

                                <!-- Period -->
                                <td class="px-4 py-3">
                                    <div class="flex flex-col text-sm">
                                        <span class="font-medium">{{ $reservation->start_date?->format('d M Y') }}</span>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('to') }} {{ $reservation->end_date?->format('d M Y') }}</span>
                                        <span class="text-xs text-zinc-500 dark:text-zinc-400 font-mono">{{ $reservation->start_date?->diffInDays($reservation->end_date) }} {{ __('days') }}</span>
                                    </div>
                                </td>

                                <!-- Quantity -->
                                <td class="px-4 py-3">
                                    <span class="font-mono font-semibold">{{ $reservation->quantity }}</span>
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $reservation->status === 'approved' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                        {{ $reservation->status === 'pending' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                        {{ $reservation->status === 'rejected' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                                        {{ $reservation->status === 'completed' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                        {{ $reservation->status === 'cancelled' ? 'bg-zinc-500/10 text-zinc-500' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        {{ __(ucfirst($reservation->status)) }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('reservations.show', $reservation) }}" class="p-1.5 rounded-lg hover:bg-zinc-200 dark:hover:bg-surface-700 transition-colors" title="{{ __('View') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        @if(in_array($reservation->status, ['pending', 'approved']) && $reservation->start_date > now())
                                            <form action="{{ route('reservations.cancel', $reservation) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to cancel this reservation?') }}');">
                                                @csrf
                                                <button type="submit" class="p-1.5 rounded-lg hover:bg-accent-rose/10 text-accent-rose transition-colors" title="{{ __('Cancel') }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6">
            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Showing') }} <span class="font-semibold text-zinc-800 dark:text-white">{{ $reservations->firstItem() }}</span>
                {{ __('to') }} <span class="font-semibold text-zinc-800 dark:text-white">{{ $reservations->lastItem() }}</span>
                {{ __('of') }} <span class="font-semibold text-zinc-800 dark:text-white">{{ $reservations->total() }}</span>
                {{ __('reservations') }}
            </div>
            <div>
                {{ $reservations->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent-cyan/10 mb-6">
                <svg class="w-10 h-10 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ __('No reservations found') }}</h3>
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 max-w-md mx-auto">
                {{ request('status') ? __('No reservations with this status.') : __('You have not made any reservations yet.') }}
            </p>
            <a href="{{ route('reservations.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Make Your First Reservation') }}
            </a>
        </div>
    @endif
</x-app-layout>
