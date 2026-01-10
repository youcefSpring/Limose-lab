<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-4">
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Welcome back') }}, {{ auth()->user()->name }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1 hidden sm:block">{{ __("Here's what's happening with your laboratory today") }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Theme Toggle (Desktop) -->
            <button onclick="toggleTheme()" class="hidden lg:block relative p-2.5 rounded-xl glass hover:glass-card transition-all group">
                <div class="relative w-5 h-5">
                    <svg class="w-5 h-5 text-accent-amber absolute inset-0 transition-all duration-500 dark:opacity-0 dark:rotate-90 dark:scale-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <svg class="w-5 h-5 text-accent-violet absolute inset-0 transition-all duration-500 opacity-0 -rotate-90 scale-0 dark:opacity-100 dark:rotate-0 dark:scale-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </div>
            </button>

            <!-- Notifications -->
            <a href="{{ route('notifications.index') }}" class="relative p-2.5 rounded-xl glass hover:glass-card transition-colors">
                <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="absolute top-2 right-2 w-2 h-2 bg-accent-rose rounded-full"></span>
                @endif
            </a>

            <!-- Quick Action Button -->
            <a href="{{ route('materials.create') }}" class="hidden sm:flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span class="hidden lg:inline">{{ __('New Material') }}</span>
            </a>
        </div>
    </header>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
        <!-- Pending Users -->
        <div class="stat-card glass-card rounded-2xl p-5 lg:p-6 transition-all duration-300 glow-amber">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-zinc-500 dark:text-zinc-400 text-sm">{{ __('Pending Users') }}</p>
                    <p class="text-2xl lg:text-3xl font-semibold mt-2 font-mono">{{ $pendingUsersCount ?? 0 }}</p>
                    <div class="flex items-center gap-1.5 mt-3">
                        <a href="{{ route('users.index') }}" class="text-accent-amber text-sm hover:text-accent-coral transition-colors">
                            {{ __('Review now') }} →
                        </a>
                    </div>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-accent-amber/10 flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-accent-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Reservations -->
        <div class="stat-card glass-card rounded-2xl p-5 lg:p-6 transition-all duration-300 glow-cyan">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-zinc-500 dark:text-zinc-400 text-sm">{{ __('Pending Reservations') }}</p>
                    <p class="text-2xl lg:text-3xl font-semibold mt-2 font-mono">{{ $pendingReservationsCount ?? 0 }}</p>
                    <div class="flex items-center gap-1.5 mt-3">
                        <a href="{{ route('reservations.index') }}" class="text-accent-cyan text-sm hover:text-accent-emerald transition-colors">
                            {{ __('Review now') }} →
                        </a>
                    </div>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-accent-cyan/10 flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Materials -->
        <div class="stat-card glass-card rounded-2xl p-5 lg:p-6 transition-all duration-300 glow-violet">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-zinc-500 dark:text-zinc-400 text-sm">{{ __('Total Materials') }}</p>
                    <p class="text-2xl lg:text-3xl font-semibold mt-2 font-mono">{{ $totalMaterialsCount ?? 0 }}</p>
                    <div class="flex items-center gap-1.5 mt-3">
                        <a href="{{ route('materials.index') }}" class="text-accent-violet text-sm hover:text-accent-rose transition-colors">
                            {{ __('Manage') }} →
                        </a>
                    </div>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-accent-violet/10 flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Users -->
        <div class="stat-card glass-card rounded-2xl p-5 lg:p-6 transition-all duration-300 glow-emerald">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-zinc-500 dark:text-zinc-400 text-sm">{{ __('Active Users') }}</p>
                    <p class="text-2xl lg:text-3xl font-semibold mt-2 font-mono">{{ $activeUsersCount ?? 0 }}</p>
                    <div class="flex items-center gap-1.5 mt-3">
                        <a href="{{ route('users.index') }}" class="text-accent-emerald text-sm hover:text-accent-cyan transition-colors">
                            {{ __('View all') }} →
                        </a>
                    </div>
                </div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-accent-emerald/10 flex items-center justify-center">
                    <svg class="w-5 h-5 lg:w-6 lg:h-6 text-accent-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 lg:gap-6 mb-6 lg:mb-8">
        <!-- System Alerts & Materials Overview -->
        <div class="xl:col-span-2 space-y-4 lg:space-y-6">
            <!-- System Alerts -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('System Alerts') }}</h2>
                <div class="space-y-3">
                    @if(isset($maintenanceDueCount) && $maintenanceDueCount > 0)
                        <div class="glass-card rounded-xl p-4 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4 border-accent-amber">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-accent-amber {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm flex-1">
                                    <strong>{{ $maintenanceDueCount }}</strong> {{ __('materials require maintenance') }}
                                    <a href="{{ route('materials.index') }}" class="underline font-semibold text-accent-amber hover:text-accent-coral">{{ __('View') }}</a>
                                </p>
                            </div>
                        </div>
                    @endif

                    @if(isset($pendingUsersCount) && $pendingUsersCount > 0)
                        <div class="glass-card rounded-xl p-4 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4 border-accent-cyan">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-accent-cyan {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm flex-1">
                                    <strong>{{ $pendingUsersCount }}</strong> {{ __('users waiting for approval') }}
                                    <a href="{{ route('users.index') }}" class="underline font-semibold text-accent-cyan hover:text-accent-emerald">{{ __('Review') }}</a>
                                </p>
                            </div>
                        </div>
                    @endif

                    @if(isset($pendingReservationsCount) && $pendingReservationsCount > 0)
                        <div class="glass-card rounded-xl p-4 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4 border-accent-violet">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-accent-violet {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm flex-1">
                                    <strong>{{ $pendingReservationsCount }}</strong> {{ __('reservations pending review') }}
                                    <a href="{{ route('reservations.index') }}" class="underline font-semibold text-accent-violet hover:text-accent-rose">{{ __('Review') }}</a>
                                </p>
                            </div>
                        </div>
                    @endif

                    @if((!isset($maintenanceDueCount) || $maintenanceDueCount == 0) && (!isset($pendingUsersCount) || $pendingUsersCount == 0) && (!isset($pendingReservationsCount) || $pendingReservationsCount == 0))
                        <div class="glass-card rounded-xl p-4 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4 border-accent-emerald">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-accent-emerald {{ app()->getLocale() === 'ar' ? 'ml-3' : 'mr-3' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <p class="text-sm">{{ __('All systems operational. No pending actions required.') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Materials Overview -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-6">{{ __('Materials Overview') }}</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="text-center p-4 glass-card rounded-xl border border-accent-emerald/20">
                        <p class="text-3xl font-bold text-accent-emerald font-mono">{{ $availableMaterialsCount ?? 0 }}</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">{{ __('Available') }}</p>
                    </div>
                    <div class="text-center p-4 glass-card rounded-xl border border-accent-coral/20">
                        <p class="text-3xl font-bold text-accent-coral font-mono">{{ $maintenanceMaterialsCount ?? 0 }}</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">{{ __('Maintenance') }}</p>
                    </div>
                    <div class="text-center p-4 glass-card rounded-xl border border-zinc-400/20">
                        <p class="text-3xl font-bold text-zinc-500 dark:text-zinc-400 font-mono">{{ $retiredMaterialsCount ?? 0 }}</p>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-2">{{ __('Retired') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Feed -->
        <div class="glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-lg font-semibold mb-6">{{ __('Recent Activity') }}</h2>
            <div class="space-y-6">
                @if(isset($recentActivities) && $recentActivities->count() > 0)
                    @foreach($recentActivities->take(5) as $activity)
                        <div class="flex gap-4">
                            <div class="relative">
                                <div class="w-10 h-10 rounded-full bg-accent-violet/10 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                @if(!$loop->last)
                                    <div class="absolute top-10 left-1/2 w-px h-6 bg-black/10 dark:bg-white/10"></div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm">{{ $activity->description ?? __('Activity') }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ $activity->created_at?->diffForHumans() }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-zinc-300 dark:text-zinc-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('No recent activity') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Admin Quick Actions -->
    <div class="glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-lg font-semibold mb-6">{{ __('Quick Actions') }}</h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('users.create') }}" class="glass-card rounded-xl p-4 hover:border-accent-amber transition-all group text-center">
                <div class="w-12 h-12 rounded-xl bg-accent-amber/10 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-accent-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">{{ __('Add User') }}</span>
            </a>

            <a href="{{ route('materials.create') }}" class="glass-card rounded-xl p-4 hover:border-accent-emerald transition-all group text-center">
                <div class="w-12 h-12 rounded-xl bg-accent-emerald/10 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-accent-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">{{ __('Add Material') }}</span>
            </a>

            <a href="{{ route('events.create') }}" class="glass-card rounded-xl p-4 hover:border-accent-violet transition-all group text-center">
                <div class="w-12 h-12 rounded-xl bg-accent-violet/10 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">{{ __('Create Event') }}</span>
            </a>

            <a href="{{ route('projects.create') }}" class="glass-card rounded-xl p-4 hover:border-accent-cyan transition-all group text-center">
                <div class="w-12 h-12 rounded-xl bg-accent-cyan/10 flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>
                    </svg>
                </div>
                <span class="text-sm font-medium">{{ __('New Project') }}</span>
            </a>
        </div>
    </div>
</x-app-layout>
