<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Maintenance Logs') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Track equipment maintenance and service records') }}</p>
        </div>
        @can('create', App\Models\MaintenanceLog::class)
            <a href="{{ route('maintenance.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('Log Maintenance') }}
            </a>
        @endcan
    </header>

    <!-- Filter Tabs -->
    <div class="glass-card rounded-2xl p-2 mb-6">
        <nav class="flex gap-2">
            <a href="{{ route('maintenance.index') }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ !request('filter') ? 'bg-accent-cyan/10 text-accent-cyan' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('All') }}
                @if(isset($counts['all']))
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ !request('filter') ? 'bg-accent-cyan/20 text-accent-cyan' : 'bg-black/10 dark:bg-white/10' }}">
                        {{ $counts['all'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('maintenance.index', ['filter' => 'scheduled']) }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('filter') == 'scheduled' ? 'bg-accent-amber/10 text-accent-amber' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('Scheduled') }}
                @if(isset($counts['scheduled']) && $counts['scheduled'] > 0)
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-accent-amber/20 text-accent-amber">
                        {{ $counts['scheduled'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('maintenance.index', ['filter' => 'overdue']) }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('filter') == 'overdue' ? 'bg-accent-rose/10 text-accent-rose' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('Overdue') }}
                @if(isset($counts['overdue']) && $counts['overdue'] > 0)
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-accent-rose/20 text-accent-rose">
                        {{ $counts['overdue'] }}
                    </span>
                @endif
            </a>
            <a href="{{ route('maintenance.index', ['filter' => 'completed']) }}"
                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium transition-all {{ request('filter') == 'completed' ? 'bg-accent-emerald/10 text-accent-emerald' : 'hover:bg-black/5 dark:hover:bg-white/5' }}">
                {{ __('Completed') }}
            </a>
        </nav>
    </div>

    <!-- Maintenance Logs List -->
    @if(isset($logs) && $logs->count() > 0)
        <div class="space-y-4 mb-6">
            @foreach($logs as $log)
                <div class="glass-card rounded-2xl p-5 lg:p-6 hover:scale-[1.01] transition-all duration-200">
                    <div class="flex flex-col md:flex-row md:items-start gap-4">
                        <!-- Material Info with Image -->
                        <div class="flex items-start gap-4 flex-1 min-w-0">
                            <div class="flex-shrink-0 h-16 w-16 glass rounded-xl overflow-hidden">
                                @if($log->material?->image)
                                    <img src="{{ asset('storage/' . $log->material->image) }}"
                                        alt="{{ $log->material->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full bg-gradient-to-br from-accent-coral to-accent-amber">
                                        <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold truncate">
                                            {{ $log->material?->name ?? __('Material') }}
                                        </h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                            {{ __(ucfirst($log->type)) }} • <span class="font-mono">{{ $log->scheduled_date?->format('M d, Y') }}</span>
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium flex-shrink-0
                                        {{ $log->status === 'completed' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                        {{ $log->status === 'scheduled' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                        {{ $log->status === 'in_progress' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                        {{ $log->status === 'overdue' ? 'bg-accent-rose/10 text-accent-rose' : '' }}">
                                        <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        {{ __(ucfirst($log->status)) }}
                                    </span>
                                </div>

                                <p class="text-sm text-zinc-700 dark:text-zinc-300 mb-3 line-clamp-2">
                                    {{ $log->description }}
                                </p>

                                <!-- Meta Information -->
                                <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-500 dark:text-zinc-400">
                                    @if($log->technician)
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                            <span>{{ $log->technician->name }}</span>
                                        </div>
                                    @endif

                                    @if($log->cost)
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-mono">${{ number_format($log->cost, 2) }}</span>
                                        </div>
                                    @endif

                                    @if($log->completed_at)
                                        <div class="flex items-center gap-1.5">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>{{ __('Completed') }} {{ $log->completed_at->diffForHumans() }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 flex-shrink-0">
                            <a href="{{ route('maintenance.show', $log) }}" class="px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                                {{ __('View') }}
                            </a>
                            @if($log->status == 'scheduled' || $log->status == 'in_progress')
                                @can('update', $log)
                                    <form method="POST" action="{{ route('maintenance.complete', $log) }}">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 rounded-xl bg-accent-emerald/10 text-accent-emerald hover:bg-accent-emerald/20 text-sm font-medium transition-all">
                                            {{ __('Complete') }}
                                        </button>
                                    </form>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $logs->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent-coral/10 mb-6">
                <svg class="w-10 h-10 text-accent-coral" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ __('No maintenance logs found') }}</h3>
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 max-w-md mx-auto">
                @if(request('filter'))
                    {{ __('No logs match the selected filter.') }}
                @else
                    {{ __('Get started by logging your first maintenance activity.') }}
                @endif
            </p>
            @can('create', App\Models\MaintenanceLog::class)
                <a href="{{ route('maintenance.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Log First Maintenance') }}
                </a>
            @endcan
        </div>
    @endif
</x-app-layout>
