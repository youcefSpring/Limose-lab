<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Publications') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Manage research publications and papers') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="$dispatch('open-modal', 'filter-modal')" class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all relative">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span class="hidden sm:inline">{{ __('Filter') }}</span>
                @if(request()->has('search') || request()->has('type') || request()->has('year') || request()->has('status'))
                    <span class="absolute -top-1 {{ app()->getLocale() === 'ar' ? '-left-1' : '-right-1' }} w-2 h-2 rounded-full bg-accent-amber"></span>
                @endif
            </button>
            @can('create', App\Models\Publication::class)
                <a href="{{ route('publications.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-indigo to-accent-violet px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add Publication') }}
                </a>
            @endcan
        </div>
    </header>

    <!-- Filter Modal -->
    <x-modal name="filter-modal" :show="false" maxWidth="lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-6">{{ __('Filter Publications') }}</h2>
            <form method="GET" action="{{ route('publications.index') }}" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Search') }}</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="{{ __('Search by title or authors...') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Type') }}</label>
                        <select name="type"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all">
                            <option value="">{{ __('All Types') }}</option>
                            <option value="journal" {{ request('type') == 'journal' ? 'selected' : '' }}>{{ __('Journal') }}</option>
                            <option value="conference" {{ request('type') == 'conference' ? 'selected' : '' }}>{{ __('Conference') }}</option>
                            <option value="book" {{ request('type') == 'book' ? 'selected' : '' }}>{{ __('Book') }}</option>
                            <option value="chapter" {{ request('type') == 'chapter' ? 'selected' : '' }}>{{ __('Chapter') }}</option>
                            <option value="thesis" {{ request('type') == 'thesis' ? 'selected' : '' }}>{{ __('Thesis') }}</option>
                            <option value="preprint" {{ request('type') == 'preprint' ? 'selected' : '' }}>{{ __('Preprint') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">{{ __('Year') }}</label>
                        <select name="year"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all">
                            <option value="">{{ __('All Years') }}</option>
                            @for($y = date('Y'); $y >= date('Y') - 10; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Status') }}</label>
                    <select name="status"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all">
                        <option value="">{{ __('All Status') }}</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                        <option value="in_press" {{ request('status') == 'in_press' ? 'selected' : '' }}>{{ __('In Press') }}</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>{{ __('Submitted') }}</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                    </select>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-accent-indigo to-accent-violet px-4 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                        {{ __('Apply Filters') }}
                    </button>
                    <a href="{{ route('publications.index') }}" class="flex-1 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium text-center transition-all">
                        {{ __('Clear') }}
                    </a>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Results Count -->
    @if(isset($publications) && $publications->total() > 0)
        <div class="glass-card rounded-xl px-4 py-3 mb-6 flex items-center justify-between">
            <span class="text-sm text-zinc-600 dark:text-zinc-300">
                {{ __('Found') }} <strong class="font-semibold text-zinc-900 dark:text-white">{{ $publications->total() }}</strong> {{ __('publications') }}
            </span>
            @if(request()->hasAny(['search', 'type', 'year', 'status']))
                <a href="{{ route('publications.index') }}" class="text-sm text-accent-indigo hover:text-accent-violet transition-colors font-medium">
                    {{ __('Clear all filters') }}
                </a>
            @endif
        </div>
    @endif

    <!-- Publications Table -->
    @if(isset($publications) && $publications->count() > 0)
        <div class="glass-card rounded-2xl overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-surface-800/50 border-b border-black/5 dark:border-white/5">
                        <tr>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Title') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Authors') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Year') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Type') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5">
                        @foreach($publications as $publication)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-white/5 transition-colors">
                                <!-- Title -->
                                <td class="px-6 py-4">
                                    <div class="min-w-0 max-w-md">
                                        <a href="{{ route('publications.show', $publication) }}" class="font-medium hover:text-accent-indigo transition-colors">
                                            {{ $publication->title }}
                                        </a>
                                        @if($publication->is_featured)
                                            <span class="inline-flex items-center gap-1 ml-2 px-2 py-0.5 rounded text-xs font-medium bg-accent-rose/10 text-accent-rose">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                {{ __('Featured') }}
                                            </span>
                                        @endif
                                        @if($publication->journal || $publication->conference)
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-1 italic">
                                                {{ $publication->journal ?? $publication->conference }}
                                            </p>
                                        @endif
                                    </div>
                                </td>

                                <!-- Authors -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 truncate max-w-xs">
                                        {{ $publication->authors ?? '-' }}
                                    </p>
                                </td>

                                <!-- Year -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 font-mono">
                                        {{ $publication->year ?? '-' }}
                                    </p>
                                </td>

                                <!-- Type -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $publication->type === 'journal' ? 'bg-accent-violet/10 text-accent-violet' : '' }}
                                        {{ $publication->type === 'conference' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                        {{ $publication->type === 'book' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                                        {{ $publication->type === 'chapter' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                        {{ $publication->type === 'thesis' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                        {{ $publication->type === 'preprint' ? 'bg-accent-indigo/10 text-accent-indigo' : '' }}">
                                        {{ __(ucfirst($publication->type)) }}
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        @if($publication->visibility === 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-accent-amber/10 text-accent-amber">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                {{ __('Pending') }}
                                            </span>
                                        @elseif($publication->visibility === 'public')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-accent-emerald/10 text-accent-emerald">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                {{ __('Public') }}
                                            </span>
                                        @endif
                                        @if($publication->is_open_access)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-accent-emerald/10 text-accent-emerald">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                                </svg>
                                                {{ __('Open Access') }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('publications.show', $publication) }}"
                                            class="p-2 rounded-lg hover:bg-accent-cyan/10 text-accent-cyan transition-colors"
                                            title="{{ __('View') }}">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @can('update', $publication)
                                            <a href="{{ route('publications.edit', $publication) }}"
                                                class="p-2 rounded-lg hover:bg-accent-violet/10 text-accent-violet transition-colors"
                                                title="{{ __('Edit') }}">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endcan
                                        @can('delete', $publication)
                                            <form method="POST" action="{{ route('publications.destroy', $publication) }}" class="inline-block" onsubmit="return confirm('{{ __('Are you sure you want to delete this publication?') }}')">
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
                {{ __('Showing') }} <span class="font-medium">{{ $publications->firstItem() }}</span>
                {{ __('to') }} <span class="font-medium">{{ $publications->lastItem() }}</span>
                {{ __('of') }} <span class="font-medium">{{ $publications->total() }}</span> {{ __('publications') }}
            </div>
            <div>
                {{ $publications->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent-indigo/10 mb-6">
                <svg class="w-10 h-10 text-accent-indigo" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ __('No publications found') }}</h3>
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 max-w-md mx-auto">
                @if(request()->hasAny(['search', 'type', 'year', 'status']))
                    {{ __('No publications match your current filters. Try adjusting your search criteria.') }}
                @else
                    {{ __('Get started by adding your first publication.') }}
                @endif
            </p>
            @if(request()->hasAny(['search', 'type', 'year', 'status']))
                <a href="{{ route('publications.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl glass hover:glass-card font-medium transition-all">
                    {{ __('Clear Filters') }}
                </a>
            @else
                @can('create', App\Models\Publication::class)
                    <a href="{{ route('publications.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-indigo to-accent-violet px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('Add First Publication') }}
                    </a>
                @endcan
            @endif
        </div>
    @endif
</x-app-layout>
