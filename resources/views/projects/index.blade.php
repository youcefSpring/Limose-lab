<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Research Projects') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Manage and collaborate on research projects') }}</p>
        </div>
        @can('create', App\Models\Project::class)
            <a href="{{ route('projects.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('New Project') }}
            </a>
        @endcan
    </header>

    <!-- Search and Filters -->
    <div class="glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <form method="GET" action="{{ route('projects.index') }}" class="space-y-4">
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
                            placeholder="{{ __('Search projects...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'pr-10 text-right' : 'pl-10' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <select name="status"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                        <option value="">{{ __('All Status') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>{{ __('On Hold') }}</option>
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

    <!-- Projects Grid -->
    @if(isset($projects) && $projects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            @foreach($projects as $project)
                <div class="glass-card rounded-2xl p-5 lg:p-6 hover:scale-[1.01] transition-all duration-200">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1 min-w-0">
                            <h3 class="text-xl font-semibold mb-2 truncate">
                                {{ $project->title }}
                            </h3>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                                    {{ $project->status === 'active' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                    {{ $project->status === 'completed' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                    {{ $project->status === 'on_hold' ? 'bg-accent-amber/10 text-accent-amber' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ __(ucfirst(str_replace('_', ' ', $project->status))) }}
                                </span>
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">•</span>
                                <span class="text-sm text-zinc-600 dark:text-zinc-400 truncate">
                                    {{ __('PI') }}: {{ $project->principal_investigator?->name }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-zinc-600 dark:text-zinc-300 mb-4 line-clamp-2">
                        {{ $project->description }}
                    </p>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-3 gap-4 mb-4 py-4 border-t border-b border-black/5 dark:border-white/5">
                        <div class="text-center">
                            <p class="text-2xl font-bold font-mono text-accent-rose">{{ $project->members_count ?? 0 }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ __('Members') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold font-mono text-accent-emerald">{{ $project->experiments_count ?? 0 }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ __('Experiments') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold font-mono text-accent-violet">{{ $project->progress ?? 0 }}%</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ __('Progress') }}</p>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="w-full bg-black/5 dark:bg-white/5 rounded-full h-2 overflow-hidden">
                            <div class="bg-gradient-to-r from-accent-violet to-accent-rose h-2 rounded-full transition-all duration-300"
                                style="width: {{ $project->progress ?? 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Dates and Members -->
                    <div class="flex flex-wrap items-center justify-between text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                        <div class="flex items-center gap-2">
                            <svg class="h-4 w-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-mono text-xs">{{ $project->start_date?->format('M d, Y') }}</span>
                            @if($project->end_date)
                                <span>→</span>
                                <span class="font-mono text-xs">{{ $project->end_date->format('M d, Y') }}</span>
                            @endif
                        </div>

                        <!-- Member Avatars -->
                        @if($project->members && $project->members->count() > 0)
                            <div class="flex {{ app()->getLocale() === 'ar' ? '-space-x-2 space-x-reverse' : '-space-x-2' }}">
                                @foreach($project->members->take(3) as $member)
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-accent-violet to-accent-rose border-2 border-white dark:border-surface-800 flex items-center justify-center text-xs font-semibold text-white shadow-lg"
                                        title="{{ $member->name }}">
                                        {{ strtoupper(substr($member->name, 0, 2)) }}
                                    </div>
                                @endforeach
                                @if($project->members->count() > 3)
                                    <div class="h-8 w-8 rounded-full bg-black/20 dark:bg-white/20 border-2 border-white dark:border-surface-800 flex items-center justify-center text-xs font-semibold shadow-lg">
                                        +{{ $project->members->count() - 3 }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <a href="{{ route('projects.show', $project) }}" class="flex-1 px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium text-center transition-all">
                            {{ __('View Details') }}
                        </a>
                        @can('update', $project)
                            <a href="{{ route('projects.edit', $project) }}" class="px-4 py-2 rounded-xl bg-accent-violet/10 text-accent-violet hover:bg-accent-violet/20 text-sm font-medium transition-all">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $projects->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent-rose/10 mb-6">
                <svg class="w-10 h-10 text-accent-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ __('No projects found') }}</h3>
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 max-w-md mx-auto">
                {{ request('search') ? __('Try adjusting your search or filters.') : __('Get started by creating a new research project.') }}
            </p>
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Create First Project') }}
                </a>
            @endcan
        </div>
    @endif
</x-app-layout>
