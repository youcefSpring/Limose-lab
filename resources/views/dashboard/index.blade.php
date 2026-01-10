<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Dashboard') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">
                {{ __('Welcome back') }}, <span class="font-semibold">{{ auth()->user()->name ?? 'User' }}</span>
            </p>
        </div>
    </header>
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6 lg:mb-8">
        <!-- My Reservations -->
        <div class="stat-card glass-card rounded-2xl p-5 lg:p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-accent-cyan/10 flex items-center justify-center">
                    <svg class="h-6 w-6 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold font-mono mb-1">{{ $myReservationsCount ?? 0 }}</p>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-3">{{ __('My Reservations') }}</p>
            <a href="{{ route('reservations.index') }}" class="text-sm text-accent-cyan hover:text-accent-cyan/80 font-medium">
                {{ __('View all') }} →
            </a>
        </div>

        <!-- Available Materials -->
        <div class="stat-card glass-card rounded-2xl p-5 lg:p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-accent-emerald/10 flex items-center justify-center">
                    <svg class="h-6 w-6 text-accent-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold font-mono mb-1">{{ $availableMaterialsCount ?? 0 }}</p>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-3">{{ __('Available Materials') }}</p>
            <a href="{{ route('materials.index') }}" class="text-sm text-accent-emerald hover:text-accent-emerald/80 font-medium">
                {{ __('Browse materials') }} →
            </a>
        </div>

        <!-- My Projects -->
        <div class="stat-card glass-card rounded-2xl p-5 lg:p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-accent-violet/10 flex items-center justify-center">
                    <svg class="h-6 w-6 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold font-mono mb-1">{{ $myProjectsCount ?? 0 }}</p>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-3">{{ __('My Projects') }}</p>
            <a href="{{ route('projects.index') }}" class="text-sm text-accent-violet hover:text-accent-violet/80 font-medium">
                {{ __('View projects') }} →
            </a>
        </div>

        <!-- Upcoming Events -->
        <div class="stat-card glass-card rounded-2xl p-5 lg:p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="h-12 w-12 rounded-xl bg-accent-amber/10 flex items-center justify-center">
                    <svg class="h-6 w-6 text-accent-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold font-mono mb-1">{{ $upcomingEventsCount ?? 0 }}</p>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-3">{{ __('Upcoming Events') }}</p>
            <a href="{{ route('events.index', ['filter' => 'upcoming']) }}" class="text-sm text-accent-amber hover:text-accent-amber/80 font-medium">
                {{ __('View events') }} →
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6 lg:mb-8">
        <!-- Recent Reservations -->
        <div class="glass-card rounded-2xl p-5 lg:p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold">{{ __('Recent Reservations') }}</h2>
                <a href="{{ route('reservations.index') }}" class="text-sm text-accent-cyan hover:text-accent-cyan/80 font-medium">
                    {{ __('View all') }} →
                </a>
            </div>

            @if(isset($recentReservations) && $recentReservations->count() > 0)
                <div class="space-y-3">
                    @foreach($recentReservations as $reservation)
                        <div class="flex items-start justify-between p-4 glass rounded-xl">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-sm truncate">
                                    {{ $reservation->material->name ?? __('Material') }}
                                </h4>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 font-mono">
                                    {{ $reservation->start_date?->format('d M Y') }} - {{ $reservation->end_date?->format('d M Y') }}
                                </p>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium flex-shrink-0 {{ app()->getLocale() === 'ar' ? 'mr-3' : 'ml-3' }}
                                {{ $reservation->status === 'approved' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                {{ $reservation->status === 'pending' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                {{ $reservation->status === 'rejected' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                                {{ $reservation->status === 'completed' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}">
                                {{ __(ucfirst($reservation->status)) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-zinc-500 dark:text-zinc-400 text-center py-8">
                    {{ __('No recent reservations') }}
                </p>
            @endif
        </div>

        <!-- Notifications -->
        <div class="glass-card rounded-2xl p-5 lg:p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold">{{ __('Recent Notifications') }}</h2>
            </div>

            @if(isset($recentNotifications) && $recentNotifications->count() > 0)
                <div class="space-y-3">
                    @foreach($recentNotifications as $notification)
                        <div class="flex items-start p-3 glass rounded-xl {{ $notification->read_at ? 'opacity-75' : '' }}">
                            <div class="flex-shrink-0 {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                                <div class="h-2 w-2 bg-accent-cyan rounded-full {{ $notification->read_at ? 'opacity-0' : '' }}"></div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm">
                                    {{ $notification->data['message'] ?? __('New notification') }}
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                    {{ $notification->created_at?->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-zinc-500 dark:text-zinc-400 text-center py-8">
                    {{ __('No recent notifications') }}
                </p>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-lg font-semibold mb-5">{{ __('Quick Actions') }}</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('reservations.create') }}" class="flex items-center p-4 glass rounded-xl hover:glass-card transition-all group">
                <div class="h-10 w-10 rounded-lg bg-accent-cyan/10 flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                    <svg class="h-5 w-5 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">
                    {{ __('New Reservation') }}
                </span>
            </a>

            <a href="{{ route('materials.index') }}" class="flex items-center p-4 glass rounded-xl hover:glass-card transition-all group">
                <div class="h-10 w-10 rounded-lg bg-accent-emerald/10 flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                    <svg class="h-5 w-5 text-accent-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">
                    {{ __('Browse Materials') }}
                </span>
            </a>

            <a href="{{ route('events.index', ['filter' => 'upcoming']) }}" class="flex items-center p-4 glass rounded-xl hover:glass-card transition-all group">
                <div class="h-10 w-10 rounded-lg bg-accent-violet/10 flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                    <svg class="h-5 w-5 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">
                    {{ __('View Events') }}
                </span>
            </a>

            <a href="{{ route('projects.index') }}" class="flex items-center p-4 glass rounded-xl hover:glass-card transition-all group">
                <div class="h-10 w-10 rounded-lg bg-accent-rose/10 flex items-center justify-center {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}">
                    <svg class="h-5 w-5 text-accent-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">
                    {{ __('My Projects') }}
                </span>
            </a>
        </div>
    </div>
</x-app-layout>
