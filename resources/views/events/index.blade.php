<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Events') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Laboratory events and seminars') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="$dispatch('open-modal', 'filter-modal')" class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all relative">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span class="hidden sm:inline">{{ __('Filter') }}</span>
                @if(request()->has('search') || request()->has('type'))
                    <span class="absolute -top-1 {{ app()->getLocale() === 'ar' ? '-left-1' : '-right-1' }} w-2 h-2 rounded-full bg-accent-amber"></span>
                @endif
            </button>
            @can('create', App\Models\Event::class)
                <a href="{{ route('events.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('New Event') }}
                </a>
            @endcan
        </div>
    </header>

    <!-- Filter Modal -->
    <x-modal name="filter-modal" :show="false" maxWidth="lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-6">{{ __('Filter Events') }}</h2>
            <form method="GET" action="{{ route('events.index') }}" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Search') }}</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="{{ __('Search events...') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Type') }}</label>
                    <select name="type"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="seminar" {{ request('type') == 'seminar' ? 'selected' : '' }}>{{ __('Seminar') }}</option>
                        <option value="workshop" {{ request('type') == 'workshop' ? 'selected' : '' }}>{{ __('Workshop') }}</option>
                        <option value="conference" {{ request('type') == 'conference' ? 'selected' : '' }}>{{ __('Conference') }}</option>
                        <option value="meeting" {{ request('type') == 'meeting' ? 'selected' : '' }}>{{ __('Meeting') }}</option>
                    </select>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-accent-amber to-accent-coral px-4 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                        {{ __('Apply Filters') }}
                    </button>
                    <a href="{{ route('events.index') }}" class="flex-1 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium text-center transition-all">
                        {{ __('Clear') }}
                    </a>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Results Count -->
    @if(isset($events) && $events->total() > 0)
        <div class="glass-card rounded-xl px-4 py-3 mb-6 flex items-center justify-between">
            <span class="text-sm text-zinc-600 dark:text-zinc-300">
                {{ __('Found') }} <strong class="font-semibold text-zinc-900 dark:text-white">{{ $events->total() }}</strong> {{ __('events') }}
            </span>
            @if(request()->hasAny(['search', 'type']))
                <a href="{{ route('events.index') }}" class="text-sm text-accent-amber hover:text-accent-coral transition-colors font-medium">
                    {{ __('Clear all filters') }}
                </a>
            @endif
        </div>
    @endif

    <!-- Events Table -->
    @if(isset($events) && $events->count() > 0)
        <div class="glass-card rounded-2xl overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-surface-800/50 border-b border-black/5 dark:border-white/5">
                        <tr>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Title') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Type') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Date/Time') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Location') }}</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">{{ __('Attendees') }}</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5">
                        @foreach($events as $event)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-white/5 transition-colors">
                                <!-- Title -->
                                <td class="px-6 py-4">
                                    <div class="min-w-0 max-w-sm">
                                        <a href="{{ route('events.show', $event) }}" class="font-medium hover:text-accent-amber transition-colors">
                                            {{ $event->title }}
                                        </a>
                                        @if($event->date < now())
                                            <span class="inline-flex items-center gap-1 ml-2 px-2 py-0.5 rounded text-xs font-medium bg-zinc-500/10 text-zinc-500">
                                                {{ __('Past') }}
                                            </span>
                                        @elseif($event->date->isToday())
                                            <span class="inline-flex items-center gap-1 ml-2 px-2 py-0.5 rounded text-xs font-medium bg-accent-amber/10 text-accent-amber">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current animate-pulse"></span>
                                                {{ __('Today') }}
                                            </span>
                                        @endif
                                        @if($event->description)
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-1">{{ $event->description }}</p>
                                        @endif
                                    </div>
                                </td>

                                <!-- Type -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $event->type === 'seminar' ? 'bg-accent-violet/10 text-accent-violet' : '' }}
                                        {{ $event->type === 'workshop' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                        {{ $event->type === 'conference' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                                        {{ $event->type === 'meeting' ? 'bg-accent-amber/10 text-accent-amber' : '' }}">
                                        {{ __(ucfirst($event->type)) }}
                                    </span>
                                </td>

                                <!-- Date/Time -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-zinc-600 dark:text-zinc-300">
                                        <div class="font-medium">{{ $event->date?->format('d M Y') ?? '-' }}</div>
                                        <div class="text-xs text-zinc-500 dark:text-zinc-400 font-mono">
                                            {{ $event->date?->format('g:i A') }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Location -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 truncate max-w-xs">
                                        {{ $event->location ?? '-' }}
                                    </p>
                                </td>

                                <!-- Attendees -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-1 text-sm text-zinc-600 dark:text-zinc-300">
                                        <svg class="h-4 w-4 flex-shrink-0 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <span class="font-mono">{{ $event->attendees_count ?? 0 }}</span>
                                        @if($event->max_attendees)
                                            <span>/</span>
                                            <span class="font-mono">{{ $event->max_attendees }}</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('events.show', $event) }}"
                                            class="p-2 rounded-lg hover:bg-accent-cyan/10 text-accent-cyan transition-colors"
                                            title="{{ __('View') }}">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @can('update', $event)
                                            <a href="{{ route('events.edit', $event) }}"
                                                class="p-2 rounded-lg hover:bg-accent-violet/10 text-accent-violet transition-colors"
                                                title="{{ __('Edit') }}">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endcan
                                        @can('delete', $event)
                                            <form method="POST" action="{{ route('events.destroy', $event) }}" class="inline-block" onsubmit="return confirm('{{ __('Are you sure you want to delete this event?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 rounded-lg hover:bg-accent-rose/10 text-accent-rose transition-colors"
                                                    title="{{ __('Delete') }}">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-zinc-600 dark:text-zinc-400">
                {{ __('Showing') }} <span class="font-medium">{{ $events->firstItem() }}</span>
                {{ __('to') }} <span class="font-medium">{{ $events->lastItem() }}</span>
                {{ __('of') }} <span class="font-medium">{{ $events->total() }}</span> {{ __('events') }}
            </div>
            <div>
                {{ $events->appends(request()->query())->links() }}
            </div>
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
                @if(request()->hasAny(['search', 'type']))
                    {{ __('No events match your current filters. Try adjusting your search criteria.') }}
                @else
                    {{ __('Get started by creating a new event.') }}
                @endif
            </p>
            @if(request()->hasAny(['search', 'type']))
                <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl glass hover:glass-card font-medium transition-all">
                    {{ __('Clear Filters') }}
                </a>
            @else
                @can('create', App\Models\Event::class)
                    <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('Create First Event') }}
                    </a>
                @endcan
            @endif
        </div>
    @endif
</x-app-layout>
