<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Research Projects') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Manage and collaborate on research projects') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="$dispatch('open-modal', 'filter-modal')" class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all relative">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span class="hidden sm:inline">{{ __('Filter') }}</span>
                @if(request()->has('search') || request()->has('status'))
                    <span class="absolute -top-1 {{ app()->getLocale() === 'ar' ? '-left-1' : '-right-1' }} w-2 h-2 rounded-full bg-accent-amber"></span>
                @endif
            </button>
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('New Project') }}
                </a>
            @endcan
        </div>
    </header>

    <!-- Filter Modal -->
    <x-modal name="filter-modal" :show="false" maxWidth="lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-6">{{ __('Filter Projects') }}</h2>
            <form method="GET" action="{{ route('projects.index') }}" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Search') }}</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="{{ __('Search by title or description...') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Status') }}</label>
                    <select name="status"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="on_hold" {{ request('status') == 'on_hold' ? 'selected' : '' }}>{{ __('On Hold') }}</option>
                    </select>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-accent-amber to-accent-coral px-4 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                        {{ __('Apply Filters') }}
                    </button>
                    <a href="{{ route('projects.index') }}" class="flex-1 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium text-center transition-all">
                        {{ __('Clear') }}
                    </a>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Results Count -->
    @if(isset($projects) && $projects->total() > 0)
        <div class="glass-card rounded-xl px-4 py-3 mb-6 flex items-center justify-between">
            <span class="text-sm text-zinc-600 dark:text-zinc-300">
                {{ __('Found') }} <strong class="font-semibold text-zinc-900 dark:text-white">{{ $projects->total() }}</strong> {{ __('projects') }}
            </span>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('projects.index') }}" class="text-sm text-accent-amber hover:text-accent-coral transition-colors font-medium">
                    {{ __('Clear all filters') }}
                </a>
            @endif
        </div>
    @endif

    <!-- Projects Table -->
    @if(isset($projects) && $projects->count() > 0)
        <div class="glass-card rounded-2xl overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-surface-800/50 border-b border-black/5 dark:border-white/5">
                        <tr>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Project') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Principal Investigator') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Progress') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Period') }}</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">{{ __('Members') }}</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5">
                        @foreach($projects as $project)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-white/5 transition-colors">
                                <!-- Project -->
                                <td class="px-6 py-4">
                                    <div class="min-w-0 max-w-sm">
                                        <a href="{{ route('projects.show', $project) }}" class="font-medium hover:text-accent-amber transition-colors">
                                            {{ $project->title }}
                                        </a>
                                        @if($project->description)
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-1">{{ $project->description }}</p>
                                        @endif
                                    </div>
                                </td>

                                <!-- Principal Investigator -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 truncate max-w-xs">
                                        {{ $project->creator?->name ?? '-' }}
                                    </p>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $project->status === 'active' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                        {{ $project->status === 'completed' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                        {{ $project->status === 'on_hold' ? 'bg-accent-amber/10 text-accent-amber' : '' }}">
                                        @if($project->status === 'active')
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        @endif
                                        {{ __(ucfirst(str_replace('_', ' ', $project->status))) }}
                                    </span>
                                </td>

                                <!-- Progress -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3 min-w-[120px]">
                                        <div class="flex-1">
                                            <div class="w-full bg-black/5 dark:bg-white/5 rounded-full h-2 overflow-hidden">
                                                <div class="bg-gradient-to-r from-accent-violet to-accent-rose h-2 rounded-full transition-all"
                                                    style="width: {{ $project->progress ?? 0 }}%"></div>
                                            </div>
                                        </div>
                                        <span class="text-xs font-mono text-zinc-600 dark:text-zinc-400 w-10 text-right">
                                            {{ $project->progress ?? 0 }}%
                                        </span>
                                    </div>
                                </td>

                                <!-- Period -->
                                <td class="px-6 py-4">
                                    <div class="text-xs text-zinc-600 dark:text-zinc-300">
                                        <div class="font-mono">{{ $project->start_date?->format('d M Y') ?? '-' }}</div>
                                        @if($project->end_date)
                                            <div class="text-zinc-400 dark:text-zinc-500">to</div>
                                            <div class="font-mono">{{ $project->end_date->format('d M Y') }}</div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Members -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center">
                                        @if($project->members && $project->members->count() > 0)
                                            <div class="flex {{ app()->getLocale() === 'ar' ? '-space-x-2 space-x-reverse' : '-space-x-2' }}">
                                                @foreach($project->members->take(3) as $member)
                                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-accent-violet to-accent-rose border-2 border-white dark:border-surface-800 flex items-center justify-center text-xs font-semibold text-white shadow"
                                                        title="{{ $member->name }}">
                                                        {{ strtoupper(substr($member->name, 0, 2)) }}
                                                    </div>
                                                @endforeach
                                                @if($project->members->count() > 3)
                                                    <div class="h-8 w-8 rounded-full bg-zinc-200 dark:bg-zinc-700 border-2 border-white dark:border-surface-800 flex items-center justify-center text-xs font-semibold shadow">
                                                        +{{ $project->members->count() - 3 }}
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-zinc-400 text-sm">-</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('projects.show', $project) }}"
                                            class="p-2 rounded-lg hover:bg-accent-cyan/10 text-accent-cyan transition-colors"
                                            title="{{ __('View') }}">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @can('update', $project)
                                            <a href="{{ route('projects.edit', $project) }}"
                                                class="p-2 rounded-lg hover:bg-accent-violet/10 text-accent-violet transition-colors"
                                                title="{{ __('Edit') }}">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endcan
                                        @can('delete', $project)
                                            <form method="POST" action="{{ route('projects.destroy', $project) }}" class="inline-block" onsubmit="return confirm('{{ __('Are you sure you want to delete this project?') }}')">
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
                {{ __('Showing') }} <span class="font-medium">{{ $projects->firstItem() }}</span>
                {{ __('to') }} <span class="font-medium">{{ $projects->lastItem() }}</span>
                {{ __('of') }} <span class="font-medium">{{ $projects->total() }}</span> {{ __('projects') }}
            </div>
            <div>
                {{ $projects->appends(request()->query())->links() }}
            </div>
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
                @if(request()->hasAny(['search', 'status']))
                    {{ __('No projects match your current filters. Try adjusting your search criteria.') }}
                @else
                    {{ __('Get started by creating a new research project.') }}
                @endif
            </p>
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl glass hover:glass-card font-medium transition-all">
                    {{ __('Clear Filters') }}
                </a>
            @else
                @can('create', App\Models\Project::class)
                    <a href="{{ route('projects.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('Create First Project') }}
                    </a>
                @endcan
            @endif
        </div>
    @endif
</x-app-layout>
