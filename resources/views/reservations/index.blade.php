<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('My Reservations') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Manage your equipment reservations') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('reservations.calendar') }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                {{ __('Calendar View') }}
            </a>
            <a href="{{ route('reservations.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('New Reservation') }}
            </a>
        </div>
    </header>

    <!-- Status Filter Tabs -->
    <div class="glass-card rounded-2xl p-2 mb-6">
        <nav class="flex gap-2">
            <a href="{{ route('reservations.index') }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ !request('status') ? 'bg-accent-amber/10 text-accent-amber' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('All') }}
                @if(isset($counts['all']))
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ !request('status') ? 'bg-accent-amber/20 text-accent-amber' : 'bg-black/10 dark:bg-white/10' }}">
                        {{ $counts['all'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('reservations.index', ['status' => 'pending']) }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('status') == 'pending' ? 'bg-accent-amber/10 text-accent-amber' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('Pending') }}
                @if(isset($counts['pending']) && $counts['pending'] > 0)
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-accent-amber/20 text-accent-amber">
                        {{ $counts['pending'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('reservations.index', ['status' => 'approved']) }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('status') == 'approved' ? 'bg-accent-emerald/10 text-accent-emerald' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('Approved') }}
            </a>
            <a href="{{ route('reservations.index', ['status' => 'completed']) }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('status') == 'completed' ? 'bg-accent-cyan/10 text-accent-cyan' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('Completed') }}
            </a>
        </nav>
    </div>

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

    <!-- Reservations List -->
    @if(isset($reservations) && $reservations->count() > 0)
        <div class="space-y-4 mb-6">
            @foreach($reservations as $reservation)
                <div class="glass-card rounded-2xl p-5 lg:p-6 hover:scale-[1.01] transition-all duration-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <!-- Material Info -->
                        <div class="flex items-start gap-4 flex-1">
                            <!-- Material Image -->
                            <div class="flex-shrink-0 h-20 w-20 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-surface-700 dark:to-surface-600 rounded-xl overflow-hidden">
                                @if($reservation->material?->image)
                                    <img src="{{ asset('storage/' . $reservation->material->image) }}"
                                        alt="{{ $reservation->material->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full">
                                        <svg class="h-10 w-10 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div>
                                        <h3 class="text-lg font-semibold">
                                            {{ $reservation->material?->name ?? __('Material') }}
                                        </h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ $reservation->material?->category->name ?? __('Uncategorized') }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                                        {{ $reservation->status === 'approved' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                        {{ $reservation->status === 'pending' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                        {{ $reservation->status === 'rejected' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                                        {{ $reservation->status === 'completed' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                        {{ $reservation->status === 'cancelled' ? 'bg-zinc-500/10 text-zinc-500' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        {{ __(ucfirst($reservation->status)) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                                    <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-400">
                                        <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span class="truncate">{{ $reservation->start_date?->format('d M Y') }} - {{ $reservation->end_date?->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-400">
                                        <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                        </svg>
                                        <span>{{ __('Quantity') }}: <span class="font-semibold font-mono">{{ $reservation->quantity }}</span></span>
                                    </div>
                                    <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-400">
                                        <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="font-mono">{{ $reservation->start_date?->diffInDays($reservation->end_date) }}</span> {{ __('days') }}
                                    </div>
                                </div>

                                @if($reservation->purpose)
                                    <p class="mt-3 text-sm text-zinc-600 dark:text-zinc-300 line-clamp-1">
                                        <span class="font-medium">{{ __('Purpose') }}:</span> {{ $reservation->purpose }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 md:{{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }}">
                            <a href="{{ route('reservations.show', $reservation) }}" class="px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                                {{ __('View') }}
                            </a>
                            @if(in_array($reservation->status, ['pending', 'approved']) && $reservation->start_date > now())
                                <form method="POST" action="{{ route('reservations.cancel', $reservation) }}"
                                    onsubmit="return confirm('{{ __('Are you sure you want to cancel this reservation?') }}')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 text-sm font-medium transition-all">
                                        {{ __('Cancel') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $reservations->links() }}
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
