<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('projects.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ $project->title ?? __('Project Details') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Project') }} #{{ $project->id ?? '---' }}</p>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-medium
            {{ $project->status === 'active' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
            {{ $project->status === 'completed' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
            {{ $project->status === 'on_hold' ? 'bg-accent-amber/10 text-accent-amber' : '' }}">
            <span class="w-2 h-2 rounded-full bg-current"></span>
            {{ __(ucfirst($project->status ?? 'active')) }}
        </span>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Project Overview -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Project Overview') }}</h2>
                <div class="space-y-5">
                    <div>
                        <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Description') }}</h3>
                        <p class="text-zinc-900 dark:text-zinc-100 whitespace-pre-line leading-relaxed">{{ $project->description }}</p>
                    </div>

                    @if($project->objectives)
                        <div>
                            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Objectives') }}</h3>
                            <p class="text-zinc-900 dark:text-zinc-100 whitespace-pre-line leading-relaxed">{{ $project->objectives }}</p>
                        </div>
                    @endif

                    @if($project->methodology)
                        <div>
                            <h3 class="text-sm font-medium text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Methodology') }}</h3>
                            <p class="text-zinc-900 dark:text-zinc-100 whitespace-pre-line leading-relaxed">{{ $project->methodology }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Progress Tracking -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Project Progress') }}</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between mb-3">
                            <span class="text-sm font-medium">{{ __('Overall Progress') }}</span>
                            <span class="text-sm font-bold font-mono text-accent-violet">{{ $project->progress ?? 0 }}%</span>
                        </div>
                        <div class="w-full bg-black/5 dark:bg-white/5 rounded-full h-4 overflow-hidden">
                            <div class="bg-gradient-to-r from-accent-violet to-accent-rose h-4 rounded-full transition-all duration-300 flex items-center justify-center"
                                style="width: {{ $project->progress ?? 0 }}%">
                                @if(($project->progress ?? 0) > 10)
                                    <span class="text-xs font-semibold text-white">{{ $project->progress }}%</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Milestones -->
                    @if($project->milestones && $project->milestones->count() > 0)
                        <div class="pt-5 border-t border-black/5 dark:border-white/5">
                            <h4 class="text-sm font-semibold mb-4">{{ __('Milestones') }}</h4>
                            <div class="space-y-3">
                                @foreach($project->milestones as $milestone)
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 mt-1">
                                            @if($milestone->completed)
                                                <div class="h-5 w-5 rounded-full bg-accent-emerald/10 flex items-center justify-center">
                                                    <svg class="h-3 w-3 text-accent-emerald" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="h-5 w-5 rounded-full border-2 border-black/10 dark:border-white/10"></div>
                                            @endif
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium {{ $milestone->completed ? 'line-through text-zinc-500 dark:text-zinc-400' : '' }}">
                                                {{ $milestone->title }}
                                            </p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 flex items-center gap-1">
                                                <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                {{ __('Due') }}: {{ $milestone->due_date?->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Team Members -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-semibold">{{ __('Team Members') }} ({{ $project->members?->count() ?? 0 }})</h2>
                    @can('manage-members', $project)
                        <a href="{{ route('projects.members', $project) }}" class="px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                            {{ __('Manage Members') }}
                        </a>
                    @endcan
                </div>

                @if($project->members && $project->members->count() > 0)
                    <div class="space-y-3">
                        @foreach($project->members as $member)
                            <div class="flex items-center justify-between p-4 glass rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-gradient-to-br from-accent-violet to-accent-rose flex items-center justify-center text-sm font-semibold text-white">
                                        {{ strtoupper(substr($member->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium">{{ $member->name }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $member->email }}</p>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-accent-amber/10 text-accent-amber">
                                    {{ __(ucfirst($member->pivot->role ?? 'member')) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-zinc-500 dark:text-zinc-400 py-8">
                        {{ __('No team members assigned yet') }}
                    </p>
                @endif
            </div>

            <!-- Related Experiments -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <div class="flex justify-between items-center mb-5">
                    <h2 class="text-lg font-semibold">{{ __('Experiments') }} ({{ $project->experiments?->count() ?? 0 }})</h2>
                    @can('create-experiment', $project)
                        <a href="{{ route('experiments.create', ['project' => $project->id]) }}" class="flex items-center gap-2 px-4 py-2 rounded-xl bg-accent-emerald/10 text-accent-emerald hover:bg-accent-emerald/20 text-sm font-medium transition-all">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            {{ __('New Experiment') }}
                        </a>
                    @endcan
                </div>

                @if($project->experiments && $project->experiments->count() > 0)
                    <div class="space-y-2">
                        @foreach($project->experiments as $experiment)
                            <a href="{{ route('experiments.show', $experiment) }}"
                                class="block p-4 glass rounded-xl hover:glass-card transition-all">
                                <div class="flex justify-between items-start gap-3">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium truncate">{{ $experiment->title }}</p>
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 flex items-center gap-2">
                                            <span class="font-mono">{{ $experiment->date?->format('M d, Y') }}</span>
                                            <span>•</span>
                                            <span>{{ __('By') }} {{ $experiment->researcher?->name }}</span>
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                                        {{ $experiment->status === 'completed' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                        {{ $experiment->status === 'in_progress' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                        {{ $experiment->status === 'planned' ? 'bg-accent-amber/10 text-accent-amber' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        {{ __(ucfirst($experiment->status)) }}
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-zinc-500 dark:text-zinc-400 py-8">
                        {{ __('No experiments recorded yet') }}
                    </p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Project Information -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Project Information') }}</h2>
                <dl class="space-y-4">
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Principal Investigator') }}</dt>
                        <dd class="text-sm font-medium">{{ $project->principal_investigator?->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Start Date') }}</dt>
                        <dd class="text-sm font-medium font-mono">{{ $project->start_date?->format('M d, Y') }}</dd>
                    </div>
                    @if($project->end_date)
                        <div>
                            <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('End Date') }}</dt>
                            <dd class="text-sm font-medium font-mono">{{ $project->end_date->format('M d, Y') }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Duration') }}</dt>
                        <dd class="text-sm font-medium">
                            <span class="font-mono">{{ $project->start_date?->diffInDays($project->end_date ?? now()) }}</span> {{ __('days') }}
                        </dd>
                    </div>
                    @if($project->budget)
                        <div>
                            <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Budget') }}</dt>
                            <dd class="text-sm font-medium font-mono">{{ number_format($project->budget, 2) }} {{ __('USD') }}</dd>
                        </div>
                    @endif
                    @if($project->funding_source)
                        <div>
                            <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Funding Source') }}</dt>
                            <dd class="text-sm font-medium">{{ $project->funding_source }}</dd>
                        </div>
                    @endif
                    <div>
                        <dt class="text-xs font-medium text-zinc-500 dark:text-zinc-400 mb-1">{{ __('Created At') }}</dt>
                        <dd class="text-sm font-medium font-mono">{{ $project->created_at?->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Quick Stats -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Quick Stats') }}</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Team Members') }}</span>
                        <span class="text-xl font-bold font-mono text-accent-rose">{{ $project->members?->count() ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Experiments') }}</span>
                        <span class="text-xl font-bold font-mono text-accent-emerald">{{ $project->experiments?->count() ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Publications') }}</span>
                        <span class="text-xl font-bold font-mono text-accent-violet">{{ $project->publications_count ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @can('update', $project)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Actions') }}</h2>
                    <div class="space-y-2">
                        <a href="{{ route('projects.edit', $project) }}" class="flex items-center justify-center gap-2 w-full bg-gradient-to-r from-accent-amber to-accent-coral px-4 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            {{ __('Edit Project') }}
                        </a>
                        @can('delete', $project)
                            <form method="POST" action="{{ route('projects.destroy', $project) }}"
                                onsubmit="return confirm('{{ __('Are you sure you want to delete this project?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 font-medium text-sm transition-all">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    {{ __('Delete Project') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            @endcan
        </div>
    </div>
</x-app-layout>
