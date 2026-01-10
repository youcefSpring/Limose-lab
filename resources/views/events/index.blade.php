<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Events') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Laboratory events and seminars') }}</p>
        </div>
        @can('create', App\Models\Event::class)
            <a href="{{ route('events.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('New Event') }}
            </a>
        @endcan
    </header>

    <!-- Filter Tabs -->
    <div class="glass-card rounded-2xl p-2 mb-6">
        <nav class="flex gap-2">
            <a href="{{ route('events.index') }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ !request('filter') ? 'bg-accent-amber/10 text-accent-amber' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('All Events') }}
            </a>
            <a href="{{ route('events.index', ['filter' => 'upcoming']) }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('filter') == 'upcoming' ? 'bg-accent-emerald/10 text-accent-emerald' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('Upcoming') }}
            </a>
            <a href="{{ route('events.index', ['filter' => 'past']) }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('filter') == 'past' ? 'bg-zinc-500/10 text-zinc-500' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('Past') }}
            </a>
        </nav>
    </div>

    <!-- Events List -->
    @if(isset($events) && $events->count() > 0)
        <div class="space-y-4 mb-6">
            @foreach($events as $event)
                <div class="glass-card rounded-2xl p-5 lg:p-6 hover:scale-[1.01] transition-all duration-200">
                    <div class="flex flex-col md:flex-row md:items-start gap-6">
                        <!-- Date Badge -->
                        <div class="flex-shrink-0">
                            <div class="w-20 h-20 bg-gradient-to-br from-accent-violet to-accent-rose rounded-xl flex flex-col items-center justify-center text-white shadow-lg">
                                <div class="text-3xl font-bold font-mono">{{ $event->date?->format('d') }}</div>
                                <div class="text-xs uppercase font-semibold">{{ $event->date?->format('M') }}</div>
                            </div>
                        </div>

                        <!-- Event Details -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <h3 class="text-xl font-semibold">{{ $event->title }}</h3>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                                    {{ $event->type === 'seminar' ? 'bg-accent-violet/10 text-accent-violet' : '' }}
                                    {{ $event->type === 'workshop' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                    {{ $event->type === 'conference' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                                    {{ $event->type === 'meeting' ? 'bg-accent-amber/10 text-accent-amber' : '' }}">
                                    {{ __(ucfirst($event->type)) }}
                                </span>
                                @if($event->date < now())
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium bg-zinc-500/10 text-zinc-500">
                                        {{ __('Past') }}
                                    </span>
                                @elseif($event->date->isToday())
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium bg-accent-amber/10 text-accent-amber">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                        {{ __('Today') }}
                                    </span>
                                @endif
                            </div>

                            <p class="text-sm text-zinc-600 dark:text-zinc-300 mb-3 line-clamp-2">
                                {{ $event->description }}
                            </p>

                            <!-- Event Meta -->
                            <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                <!-- Time -->
                                <div class="flex items-center gap-1.5">
                                    <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-mono text-xs">{{ $event->date?->format('g:i A') }}</span>
                                </div>

                                <!-- Location -->
                                @if($event->location)
                                    <div class="flex items-center gap-1.5">
                                        <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span>{{ $event->location }}</span>
                                    </div>
                                @endif

                                <!-- Attendees -->
                                <div class="flex items-center gap-1.5">
                                    <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    <span class="font-mono">{{ $event->attendees_count ?? 0 }}</span>/{{ $event->max_attendees ? '<span class="font-mono">' . $event->max_attendees . '</span>' : '∞' }} {{ __('attendees') }}
                                </div>

                                <!-- Organizer -->
                                @if($event->organizer)
                                    <div class="flex items-center gap-1.5">
                                        <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>{{ __('By') }} {{ $event->organizer->name }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-wrap items-center gap-2">
                                <a href="{{ route('events.show', $event) }}" class="px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                                    {{ __('View Details') }}
                                </a>

                                @if($event->date > now())
                                    @if($event->isUserAttending ?? false)
                                        <form method="POST" action="{{ route('events.rsvp.cancel', $event) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-4 py-2 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 text-sm font-medium transition-all">
                                                {{ __('Cancel RSVP') }}
                                            </button>
                                        </form>
                                    @else
                                        @if(!$event->max_attendees || ($event->attendees_count ?? 0) < $event->max_attendees)
                                            <form method="POST" action="{{ route('events.rsvp', $event) }}">
                                                @csrf
                                                <button type="submit" class="px-4 py-2 rounded-xl bg-accent-emerald/10 text-accent-emerald hover:bg-accent-emerald/20 text-sm font-medium transition-all">
                                                    {{ __('RSVP') }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-accent-rose/10 text-accent-rose">
                                                {{ __('Full') }}
                                            </span>
                                        @endif
                                    @endif
                                @endif

                                @can('update', $event)
                                    <a href="{{ route('events.edit', $event) }}" class="p-2 rounded-xl bg-accent-violet/10 text-accent-violet hover:bg-accent-violet/20 transition-all inline-flex items-center justify-center">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $events->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent-amber/10 mb-6">
                <svg class="w-10 h-10 text-accent-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ __('No events found') }}</h3>
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 max-w-md mx-auto">
                @if(request('filter') == 'upcoming')
                    {{ __('No upcoming events scheduled.') }}
                @elseif(request('filter') == 'past')
                    {{ __('No past events to display.') }}
                @else
                    {{ __('Get started by creating a new event.') }}
                @endif
            </p>
            @can('create', App\Models\Event::class)
                <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Create First Event') }}
                </a>
            @endcan
        </div>
    @endif
</x-app-layout>
