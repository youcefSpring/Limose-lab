<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('events.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ $event->title ?? __('Event Details') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1 font-mono">{{ $event->date?->format('l, F d, Y \a\t g:i A') }}</p>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium
            {{ $event->type === 'seminar' ? 'bg-accent-violet/10 text-accent-violet' : '' }}
            {{ $event->type === 'workshop' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
            {{ $event->type === 'conference' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
            {{ $event->type === 'meeting' ? 'bg-accent-amber/10 text-accent-amber' : '' }}">
            {{ __(ucfirst($event->type ?? 'seminar')) }}
        </span>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Event Banner -->
            @if($event->image)
                <div class="glass-card rounded-2xl p-3">
                    <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}"
                        class="w-full h-64 object-cover rounded-xl">
                </div>
            @endif

            <!-- Event Description -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('About This Event') }}</h2>
                <div class="prose dark:prose-invert max-w-none">
                    <p class="text-zinc-700 dark:text-zinc-300 whitespace-pre-line leading-relaxed">{{ $event->description }}</p>
                </div>
            </div>

            <!-- Agenda -->
            @if($event->agenda)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Agenda') }}</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        <p class="text-zinc-700 dark:text-zinc-300 whitespace-pre-line leading-relaxed">{{ $event->agenda }}</p>
                    </div>
                </div>
            @endif

            <!-- Attendees -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">
                    {{ __('Attendees') }} (<span class="font-mono">{{ $event->attendees?->count() ?? 0 }}</span>@if($event->max_attendees)/<span class="font-mono">{{ $event->max_attendees }}</span>@endif)
                </h2>

                @if($event->attendees && $event->attendees->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($event->attendees as $attendee)
                            <div class="flex items-center gap-3 p-3 glass rounded-xl">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-accent-violet to-accent-rose flex items-center justify-center text-white font-semibold flex-shrink-0">
                                    {{ strtoupper(substr($attendee->name, 0, 2)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium truncate">{{ $attendee->name }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ $attendee->email }}</p>
                                </div>
                                @if($attendee->pivot->status ?? '' === 'confirmed')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-accent-emerald/10 text-accent-emerald flex-shrink-0">
                                        ✓
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-zinc-500 dark:text-zinc-400 py-8">
                        {{ __('No attendees yet. Be the first to RSVP!') }}
                    </p>
                @endif
            </div>

            <!-- Comments/Discussion -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Discussion') }} ({{ $event->comments?->count() ?? 0 }})</h2>

                <!-- Add Comment Form -->
                <form method="POST" action="{{ route('events.add-comment', $event) }}" class="mb-6">
                    @csrf
                    <div class="flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-accent-violet to-accent-rose flex items-center justify-center text-sm font-semibold text-white">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <textarea name="comment" rows="2" required
                                placeholder="{{ __('Share your thoughts about this event...') }}"
                                class="w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none"></textarea>
                            <div class="mt-2">
                                <button type="submit" class="px-4 py-2 rounded-xl bg-gradient-to-r from-accent-amber to-accent-coral text-sm font-medium text-white hover:opacity-90 transition-opacity">
                                    {{ __('Post Comment') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Comments List -->
                @if($event->comments && $event->comments->count() > 0)
                    <div class="space-y-4 border-t border-black/5 dark:border-white/5 pt-5">
                        @foreach($event->comments as $comment)
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-accent-violet to-accent-rose flex items-center justify-center text-sm font-semibold text-white">
                                        {{ strtoupper(substr($comment->user?->name ?? 'U', 0, 2)) }}
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="glass rounded-xl p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <p class="text-sm font-semibold">{{ $comment->user?->name }}</p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $comment->created_at?->diffForHumans() }}</p>
                                        </div>
                                        <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-zinc-500 dark:text-zinc-400 py-8 border-t border-black/5 dark:border-white/5">
                        {{ __('No comments yet. Start the discussion!') }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- RSVP Card -->
            @if($event->date > now())
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('RSVP') }}</h2>

                    @if($event->isUserAttending ?? false)
                        <div class="text-center py-4">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-accent-emerald/10 mb-3">
                                <svg class="w-8 h-8 text-accent-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold mb-1">{{ __('You\'re attending!') }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-4">{{ __('See you there!') }}</p>
                            <form method="POST" action="{{ route('events.rsvp.cancel', $event) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                                    {{ __('Cancel RSVP') }}
                                </button>
                            </form>
                        </div>
                    @else
                        @if(!$event->max_attendees || ($event->attendees_count ?? 0) < $event->max_attendees)
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                                {{ __('Join this event and meet other researchers!') }}
                            </p>
                            <form method="POST" action="{{ route('events.rsvp', $event) }}">
                                @csrf
                                <button type="submit" class="w-full bg-gradient-to-r from-accent-emerald to-accent-cyan px-4 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                                    {{ __('RSVP Now') }}
                                </button>
                            </form>
                        @else
                            <div class="text-center py-4">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-accent-rose/10 mb-3">
                                    <svg class="w-8 h-8 text-accent-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold mb-1">{{ __('Event is Full') }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('Maximum capacity reached') }}</p>
                            </div>
                        @endif
                    @endif
                </div>
            @endif

            <!-- Event Info -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Event Information') }}</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Date & Time') }}</dt>
                        <dd class="text-sm font-medium">
                            {{ $event->date?->format('l, F d, Y') }}<br>
                            <span class="font-mono">{{ $event->date?->format('g:i A') }}</span>
                        </dd>
                    </div>

                    @if($event->location)
                        <div>
                            <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Location') }}</dt>
                            <dd class="text-sm font-medium">{{ $event->location }}</dd>
                        </div>
                    @endif

                    @if($event->organizer)
                        <div>
                            <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Organizer') }}</dt>
                            <dd class="text-sm font-medium">{{ $event->organizer->name }}</dd>
                        </div>
                    @endif

                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Type') }}</dt>
                        <dd class="mt-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                                {{ $event->type === 'seminar' ? 'bg-accent-violet/10 text-accent-violet' : '' }}
                                {{ $event->type === 'workshop' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                {{ $event->type === 'conference' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                                {{ $event->type === 'meeting' ? 'bg-accent-amber/10 text-accent-amber' : '' }}">
                                {{ __(ucfirst($event->type)) }}
                            </span>
                        </dd>
                    </div>

                    @if($event->max_attendees)
                        <div>
                            <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Capacity') }}</dt>
                            <dd class="text-sm font-medium mb-2">
                                <span class="font-mono">{{ $event->attendees_count ?? 0 }}</span> / <span class="font-mono">{{ $event->max_attendees }}</span>
                            </dd>
                            <div class="w-full bg-black/5 dark:bg-white/5 rounded-full h-2 overflow-hidden">
                                <div class="bg-gradient-to-r from-accent-violet to-accent-rose h-2 rounded-full transition-all duration-300"
                                    style="width: {{ $event->max_attendees > 0 ? (($event->attendees_count ?? 0) / $event->max_attendees * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @endif

                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Created') }}</dt>
                        <dd class="text-sm font-medium font-mono">{{ $event->created_at?->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Actions -->
            @can('update', $event)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Actions') }}</h2>
                    <div class="space-y-2">
                        <a href="{{ route('events.edit', $event) }}" class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-accent-amber to-accent-coral px-4 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            {{ __('Edit Event') }}
                        </a>
                        @can('delete', $event)
                            <form method="POST" action="{{ route('events.destroy', $event) }}"
                                onsubmit="return confirm('{{ __('Are you sure you want to delete this event?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 font-medium text-sm transition-all">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    {{ __('Delete Event') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            @endcan
        </div>
    </div>
</x-app-layout>
