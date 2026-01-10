<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Experiments') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('View and manage laboratory experiments') }}</p>
        </div>
        @can('create', App\Models\Experiment::class)
            <a href="{{ route('experiments.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('New Experiment') }}
            </a>
        @endcan
    </header>

    <!-- Search and Filters -->
    <div class="glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <form method="GET" action="{{ route('experiments.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search Input -->
                <div class="md:col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('Search experiments...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'pr-10 text-right' : 'pl-10' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                    </div>
                </div>

                <!-- Project Filter -->
                <div>
                    <select name="project"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                        <option value="">{{ __('All Projects') }}</option>
                        @foreach($projects ?? [] as $project)
                            <option value="{{ $project->id }}" {{ request('project') == $project->id ? 'selected' : '' }}>
                                {{ $project->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Search Button -->
                <div>
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 py-3 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        {{ __('Search') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Experiments by Project -->
    @if(isset($experimentsByProject) && $experimentsByProject->count() > 0)
        @foreach($experimentsByProject as $projectTitle => $experiments)
            <div class="glass-card rounded-2xl p-5 lg:p-6 mb-6">
                <!-- Project Header -->
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-semibold">{{ $projectTitle }}</h2>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-accent-emerald/10 text-accent-emerald">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                        {{ $experiments->count() }} {{ __('experiments') }}
                    </span>
                </div>

                <!-- Experiments List -->
                <div class="space-y-3">
                    @foreach($experiments as $experiment)
                        <a href="{{ route('experiments.show', $experiment) }}"
                            class="block p-4 glass rounded-xl hover:glass-card transition-all">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <!-- Title and Status -->
                                    <div class="flex flex-wrap items-center gap-2 mb-2">
                                        <h3 class="text-lg font-semibold truncate">
                                            {{ $experiment->title }}
                                        </h3>
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                                            {{ $experiment->status === 'completed' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                            {{ $experiment->status === 'in_progress' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                            {{ $experiment->status === 'planned' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                            {{ $experiment->status === 'cancelled' ? 'bg-zinc-500/10 text-zinc-500' : '' }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ __(ucfirst($experiment->status)) }}
                                        </span>
                                    </div>

                                    <!-- Description -->
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 mb-3 line-clamp-2">
                                        {{ $experiment->description }}
                                    </p>

                                    <!-- Metadata -->
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-500 dark:text-zinc-400">
                                        <!-- Date -->
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="font-mono text-xs">{{ $experiment->date?->format('M d, Y') }}</span>
                                        </div>

                                        <!-- Researcher -->
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>{{ $experiment->researcher?->name }}</span>
                                        </div>

                                        <!-- Files Count -->
                                        @if($experiment->files_count ?? 0 > 0)
                                            <div class="flex items-center gap-1.5">
                                                <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <span class="font-mono">{{ $experiment->files_count }}</span> {{ __('files') }}
                                            </div>
                                        @endif

                                        <!-- Comments Count -->
                                        @if($experiment->comments_count ?? 0 > 0)
                                            <div class="flex items-center gap-1.5">
                                                <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                                </svg>
                                                <span class="font-mono">{{ $experiment->comments_count }}</span> {{ __('comments') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Quick Actions -->
                                @can('update', $experiment)
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('experiments.edit', $experiment) }}"
                                            onclick="event.stopPropagation()"
                                            class="p-2 rounded-xl bg-accent-violet/10 text-accent-violet hover:bg-accent-violet/20 transition-all inline-flex items-center justify-center">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    </div>
                                @endcan
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Pagination -->
        @if(isset($experiments) && method_exists($experiments, 'links'))
            <div class="flex justify-center">
                {{ $experiments->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent-emerald/10 mb-6">
                <svg class="w-10 h-10 text-accent-emerald" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ __('No experiments found') }}</h3>
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 max-w-md mx-auto">
                {{ request('search') ? __('Try adjusting your search or filters.') : __('Get started by creating a new experiment.') }}
            </p>
            @can('create', App\Models\Experiment::class)
                <a href="{{ route('experiments.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Create First Experiment') }}
                </a>
            @endcan
        </div>
    @endif
</x-app-layout>
