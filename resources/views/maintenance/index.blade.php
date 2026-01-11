<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Maintenance Logs') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Track equipment maintenance and service records') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <button @click="$dispatch('open-modal', 'filter-modal')" class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all relative">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span class="hidden sm:inline">{{ __('Filter') }}</span>
                @if(request()->has('search') || request()->has('status') || request()->has('type') || request()->has('material') || request()->has('technician'))
                    <span class="absolute -top-1 {{ app()->getLocale() === 'ar' ? '-left-1' : '-right-1' }} w-2 h-2 rounded-full bg-accent-amber"></span>
                @endif
            </button>
            @can('create', App\Models\MaintenanceLog::class)
                <a href="{{ route('maintenance.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Log Maintenance') }}
                </a>
            @endcan
        </div>
    </header>

    <!-- Filter Modal -->
    <x-modal name="filter-modal" :show="false" maxWidth="lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-6">{{ __('Filter Maintenance Logs') }}</h2>
            <form method="GET" action="{{ route('maintenance.index') }}" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Search') }}</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="{{ __('Search by description or notes...') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Status') }}</label>
                    <select name="status"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                        <option value="">{{ __('All Statuses') }}</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>{{ __('Scheduled') }}</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-2">{{ __('Type') }}</label>
                    <select name="type"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all">
                        <option value="">{{ __('All Types') }}</option>
                        <option value="preventive" {{ request('type') == 'preventive' ? 'selected' : '' }}>{{ __('Preventive') }}</option>
                        <option value="corrective" {{ request('type') == 'corrective' ? 'selected' : '' }}>{{ __('Corrective') }}</option>
                        <option value="inspection" {{ request('type') == 'inspection' ? 'selected' : '' }}>{{ __('Inspection') }}</option>
                        <option value="calibration" {{ request('type') == 'calibration' ? 'selected' : '' }}>{{ __('Calibration') }}</option>
                    </select>
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-accent-amber to-accent-coral px-4 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                        {{ __('Apply Filters') }}
                    </button>
                    <a href="{{ route('maintenance.index') }}" class="flex-1 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium text-center transition-all">
                        {{ __('Clear') }}
                    </a>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Results Count -->
    @if(isset($logs) && $logs->total() > 0)
        <div class="glass-card rounded-xl px-4 py-3 mb-6 flex items-center justify-between">
            <span class="text-sm text-zinc-600 dark:text-zinc-300">
                {{ __('Found') }} <strong class="font-semibold text-zinc-900 dark:text-white">{{ $logs->total() }}</strong> {{ __('maintenance logs') }}
            </span>
            @if(request()->hasAny(['search', 'status', 'type', 'material', 'technician']))
                <a href="{{ route('maintenance.index') }}" class="text-sm text-accent-amber hover:text-accent-coral transition-colors font-medium">
                    {{ __('Clear all filters') }}
                </a>
            @endif
        </div>
    @endif

    <!-- Maintenance Logs Table -->
    @if(isset($logs) && $logs->count() > 0)
        <div class="glass-card rounded-2xl overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-surface-800/50 border-b border-black/5 dark:border-white/5">
                        <tr>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Material') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Type') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Scheduled Date') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Technician') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Cost') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('Status') }}</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5">
                        @foreach($logs as $log)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-white/5 transition-colors">
                                <!-- Material -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex-shrink-0 h-12 w-12 rounded-lg overflow-hidden bg-gradient-to-br from-accent-coral to-accent-amber">
                                            @if($log->material?->image)
                                                <img src="{{ asset('storage/' . $log->material->image) }}"
                                                    alt="{{ $log->material->name }}" class="h-full w-full object-cover">
                                            @else
                                                <div class="flex items-center justify-center h-full">
                                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-medium truncate">{{ $log->material?->name ?? __('Material') }}</p>
                                            @if($log->description)
                                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-1">{{ $log->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- Type -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-accent-cyan/10 text-accent-cyan capitalize">
                                        {{ __(ucfirst($log->maintenance_type)) }}
                                    </span>
                                </td>

                                <!-- Scheduled Date -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-zinc-600 dark:text-zinc-300">
                                        <div class="font-mono">{{ $log->scheduled_date?->format('d M Y') ?? '-' }}</div>
                                        @if($log->completed_date)
                                            <div class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">
                                                {{ __('Completed') }}: {{ $log->completed_date->format('d M Y') }}
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Technician -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 truncate max-w-xs">
                                        {{ $log->technician?->name ?? '-' }}
                                    </p>
                                </td>

                                <!-- Cost -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 font-mono">
                                        @if($log->cost)
                                            ${{ number_format($log->cost, 2) }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $log->status === 'completed' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                        {{ $log->status === 'scheduled' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                        {{ $log->status === 'in_progress' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                        {{ $log->status === 'cancelled' ? 'bg-zinc-500/10 text-zinc-500' : '' }}">
                                        @if($log->status === 'completed')
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        @endif
                                        {{ __(ucfirst(str_replace('_', ' ', $log->status))) }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('maintenance.show', $log) }}"
                                            class="p-2 rounded-lg hover:bg-accent-cyan/10 text-accent-cyan transition-colors"
                                            title="{{ __('View') }}">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        @if(in_array($log->status, ['scheduled', 'in_progress']))
                                            @can('update', $log)
                                                <a href="{{ route('maintenance.edit', $log) }}"
                                                    class="p-2 rounded-lg hover:bg-accent-violet/10 text-accent-violet transition-colors"
                                                    title="{{ __('Edit') }}">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                </a>
                                            @endcan
                                        @endif
                                        @can('delete', $log)
                                            <form method="POST" action="{{ route('maintenance.destroy', $log) }}" class="inline-block" onsubmit="return confirm('{{ __('Are you sure you want to delete this maintenance log?') }}')">
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
                {{ __('Showing') }} <span class="font-medium">{{ $logs->firstItem() }}</span>
                {{ __('to') }} <span class="font-medium">{{ $logs->lastItem() }}</span>
                {{ __('of') }} <span class="font-medium">{{ $logs->total() }}</span> {{ __('logs') }}
            </div>
            <div>
                {{ $logs->appends(request()->query())->links() }}
            </div>
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
                @if(request()->hasAny(['search', 'status', 'type', 'material', 'technician']))
                    {{ __('No logs match your current filters. Try adjusting your search criteria.') }}
                @else
                    {{ __('Get started by logging your first maintenance activity.') }}
                @endif
            </p>
            @if(request()->hasAny(['search', 'status', 'type', 'material', 'technician']))
                <a href="{{ route('maintenance.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl glass hover:glass-card font-medium transition-all">
                    {{ __('Clear Filters') }}
                </a>
            @else
                @can('create', App\Models\MaintenanceLog::class)
                    <a href="{{ route('maintenance.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('Log First Maintenance') }}
                    </a>
                @endcan
            @endif
        </div>
    @endif
</x-app-layout>
