<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Publications') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Manage research publications and papers') }}</p>
        </div>
        <div class="flex items-center gap-2">
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

    <!-- Search and Filters -->
    <div class="glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <form method="GET" action="{{ route('publications.index') }}" id="filter-form" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div>
                    <label for="search" class="block text-sm font-medium mb-2">{{ __('Search') }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="{{ __('Search by title or authors...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'pr-10 text-right' : 'pl-10' }} py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all"
                        >
                    </div>
                </div>

                <!-- Type Filter -->
                <div>
                    <label for="type" class="block text-sm font-medium mb-2">{{ __('Type') }}</label>
                    <select
                        name="type"
                        id="type"
                        onchange="document.getElementById('filter-form').submit()"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all"
                    >
                        <option value="">{{ __('All Types') }}</option>
                        <option value="journal" {{ request('type') == 'journal' ? 'selected' : '' }}>{{ __('Journal') }}</option>
                        <option value="conference" {{ request('type') == 'conference' ? 'selected' : '' }}>{{ __('Conference') }}</option>
                        <option value="book" {{ request('type') == 'book' ? 'selected' : '' }}>{{ __('Book') }}</option>
                        <option value="chapter" {{ request('type') == 'chapter' ? 'selected' : '' }}>{{ __('Chapter') }}</option>
                        <option value="thesis" {{ request('type') == 'thesis' ? 'selected' : '' }}>{{ __('Thesis') }}</option>
                        <option value="preprint" {{ request('type') == 'preprint' ? 'selected' : '' }}>{{ __('Preprint') }}</option>
                    </select>
                </div>

                <!-- Year Filter -->
                <div>
                    <label for="year" class="block text-sm font-medium mb-2">{{ __('Year') }}</label>
                    <select
                        name="year"
                        id="year"
                        onchange="document.getElementById('filter-form').submit()"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all"
                    >
                        <option value="">{{ __('All Years') }}</option>
                        @for($y = date('Y'); $y >= date('Y') - 10; $y--)
                            <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium mb-2">{{ __('Status') }}</label>
                    <select
                        name="status"
                        id="status"
                        onchange="document.getElementById('filter-form').submit()"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all"
                    >
                        <option value="">{{ __('All Status') }}</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>{{ __('Published') }}</option>
                        <option value="in_press" {{ request('status') == 'in_press' ? 'selected' : '' }}>{{ __('In Press') }}</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>{{ __('Submitted') }}</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>{{ __('Draft') }}</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 pt-2">
                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __('Found') }} <span class="font-semibold text-zinc-800 dark:text-white">{{ $publications->total() ?? 0 }}</span> {{ __('publications') }}
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('publications.index') }}" class="px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                        {{ __('Clear') }}
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-accent-indigo/10 text-accent-indigo hover:bg-accent-indigo/20 text-sm font-medium transition-all">
                        {{ __('Apply Filters') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Publications List -->
    @if(isset($publications) && $publications->count() > 0)
        <div class="space-y-4">
            @foreach($publications as $publication)
                <div class="glass-card rounded-2xl p-5 lg:p-6 hover:scale-[1.01] transition-all duration-300">
                    <div class="flex flex-col lg:flex-row gap-4 justify-between">
                        <div class="flex-1 space-y-3">
                            <!-- Title and Badges -->
                            <div class="flex items-start gap-3">
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold">
                                        <a href="{{ route('publications.show', $publication) }}" class="hover:text-accent-indigo transition-colors">
                                            {{ $publication->title }}
                                        </a>
                                    </h3>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $publication->authors }}</p>
                                </div>
                                <div class="flex gap-2 flex-wrap">
                                    <!-- Type Badge -->
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-accent-violet/10 text-accent-violet">
                                        {{ ucfirst($publication->type) }}
                                    </span>
                                    <!-- Status Badge -->
                                    @if($publication->visibility === 'pending')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-accent-amber/10 text-accent-amber">
                                            {{ __('Pending') }}
                                        </span>
                                    @elseif($publication->visibility === 'public')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-accent-emerald/10 text-accent-emerald">
                                            {{ __('Public') }}
                                        </span>
                                    @endif
                                    @if($publication->is_featured)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-accent-rose/10 text-accent-rose">
                                            ⭐ {{ __('Featured') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Publication Details -->
                            <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-zinc-600 dark:text-zinc-400">
                                @if($publication->journal)
                                    <span>📰 {{ $publication->journal }}</span>
                                @elseif($publication->conference)
                                    <span>🎤 {{ $publication->conference }}</span>
                                @endif
                                <span>📅 {{ $publication->year }}</span>
                                @if($publication->doi)
                                    <span>🔗 DOI: {{ $publication->doi }}</span>
                                @endif
                                @if($publication->is_open_access)
                                    <span class="text-accent-emerald">🔓 Open Access</span>
                                @endif
                            </div>

                            <!-- Abstract Preview -->
                            @if($publication->abstract)
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2">
                                    {{ $publication->abstract }}
                                </p>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="flex lg:flex-col gap-2">
                            <a href="{{ route('publications.show', $publication) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                {{ __('View') }}
                            </a>
                            @can('update', $publication)
                                <a href="{{ route('publications.edit', $publication) }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-accent-indigo/10 text-accent-indigo hover:bg-accent-indigo/20 text-sm font-medium transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    {{ __('Edit') }}
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $publications->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium">{{ __('No publications found') }}</h3>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Get started by adding your first publication.') }}</p>
            @can('create', App\Models\Publication::class)
                <div class="mt-6">
                    <a href="{{ route('publications.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-indigo to-accent-violet px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('Add Publication') }}
                    </a>
                </div>
            @endcan
        </div>
    @endif
</x-app-layout>
