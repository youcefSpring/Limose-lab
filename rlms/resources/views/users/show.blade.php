<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('users.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('User Profile') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ $user->name }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @can('update', $user)
                <a href="{{ route('users.edit', $user) }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('Edit User') }}
                </a>
            @endcan
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - User Info -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Profile Card -->
            <div class="glass-card rounded-2xl p-6">
                <div class="flex flex-col items-center text-center">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover mb-4">
                    @else
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-accent-violet to-accent-cyan flex items-center justify-center text-white text-3xl font-semibold mb-4">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                    @endif

                    <h2 class="text-xl font-semibold mb-1">{{ $user->name }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">{{ $user->email }}</p>

                    <!-- Status Badge -->
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                        {{ $user->status === 'active' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                        {{ $user->status === 'pending' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                        {{ $user->status === 'suspended' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                        {{ $user->status === 'banned' ? 'bg-red-500/10 text-red-500' : '' }}">
                        {{ __(ucfirst($user->status)) }}
                    </span>
                </div>
            </div>

            <!-- Roles Card -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('Roles') }}</h3>
                <div class="flex flex-wrap gap-2">
                    @forelse($user->roles as $role)
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-accent-violet/10 text-accent-violet">
                            {{ __(ucfirst($role->name)) }}
                        </span>
                    @empty
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('No roles assigned') }}</p>
                    @endforelse
                </div>
            </div>

            <!-- Contact Info -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('Contact Information') }}</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Email') }}</p>
                        <p class="text-sm">{{ $user->email }}</p>
                    </div>
                    @if($user->phone)
                        <div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Phone') }}</p>
                            <p class="text-sm">{{ $user->phone }}</p>
                        </div>
                    @endif
                    @if($user->research_group)
                        <div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Research Group') }}</p>
                            <p class="text-sm">{{ $user->research_group }}</p>
                        </div>
                    @endif
                </div>
            </div>

            @if($user->bio)
                <!-- Bio -->
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold mb-3">{{ __('Bio') }}</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $user->bio }}</p>
                </div>
            @endif
        </div>

        <!-- Right Column - Activity -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Recent Reservations -->
            @if($user->reservations && $user->reservations->count() > 0)
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Recent Reservations') }}</h3>
                    <div class="space-y-3">
                        @foreach($user->reservations as $reservation)
                            <div class="p-4 glass-card rounded-xl">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="font-medium">{{ $reservation->material->name ?? __('N/A') }}</h4>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                            {{ $reservation->start_date->format('M d, Y') }} - {{ $reservation->end_date->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium
                                        {{ $reservation->status === 'approved' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                        {{ $reservation->status === 'pending' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                        {{ $reservation->status === 'rejected' ? 'bg-accent-rose/10 text-accent-rose' : '' }}">
                                        {{ __(ucfirst($reservation->status)) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recent Projects -->
            @if($user->createdProjects && $user->createdProjects->count() > 0)
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Recent Projects') }}</h3>
                    <div class="space-y-3">
                        @foreach($user->createdProjects as $project)
                            <div class="p-4 glass-card rounded-xl">
                                <h4 class="font-medium">{{ $project->title }}</h4>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-2">{{ $project->description }}</p>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-2">{{ $project->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recent Experiments -->
            @if($user->experiments && $user->experiments->count() > 0)
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Recent Experiments') }}</h3>
                    <div class="space-y-3">
                        @foreach($user->experiments as $experiment)
                            <div class="p-4 glass-card rounded-xl">
                                <h4 class="font-medium">{{ $experiment->title }}</h4>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-2">{{ $experiment->description }}</p>
                                <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-2">{{ $experiment->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recent Events -->
            @if($user->createdEvents && $user->createdEvents->count() > 0)
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Recent Events') }}</h3>
                    <div class="space-y-3">
                        @foreach($user->createdEvents as $event)
                            <div class="p-4 glass-card rounded-xl">
                                <h4 class="font-medium">{{ $event->title }}</h4>
                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                    {{ $event->start_date->format('M d, Y h:i A') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Account Information -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-lg font-semibold mb-4">{{ __('Account Information') }}</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Member Since') }}</p>
                        <p class="text-sm font-medium">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Last Updated') }}</p>
                        <p class="text-sm font-medium">{{ $user->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
