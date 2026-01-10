<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('materials.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ $material->name ?? __('Material Details') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ $material->category->name ?? __('Uncategorized') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @can('update', $material)
                <a href="{{ route('materials.edit', $material) }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('Edit') }}
                </a>
            @endcan
            @if($material->status === 'available')
                <a href="{{ route('reservations.create', ['material' => $material->id]) }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ __('Reserve Now') }}
                </a>
            @endif
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-4 lg:space-y-6">
            <!-- Material Image -->
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="relative h-80 lg:h-96 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-surface-700 dark:to-surface-600">
                    @if($material->image)
                        <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->name }}" class="w-full h-full object-contain p-6">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <svg class="h-32 w-32 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Description -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('Description') }}</h2>
                <p class="text-zinc-600 dark:text-zinc-300 whitespace-pre-line leading-relaxed">{{ $material->description }}</p>
            </div>

            <!-- Specifications -->
            @if($material->serial_number || $material->purchase_date)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-5">{{ __('Specifications') }}</h2>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        @if($material->serial_number)
                            <div class="glass-card rounded-xl p-4">
                                <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Serial Number') }}</dt>
                                <dd class="text-base font-semibold font-mono">{{ $material->serial_number }}</dd>
                            </div>
                        @endif
                        @if($material->purchase_date)
                            <div class="glass-card rounded-xl p-4">
                                <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Purchase Date') }}</dt>
                                <dd class="text-base font-semibold">{{ $material->purchase_date->format('d M Y') }}</dd>
                            </div>
                        @endif
                        @if($material->maintenance_schedule)
                            <div class="glass-card rounded-xl p-4">
                                <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Maintenance Schedule') }}</dt>
                                <dd class="text-base font-semibold">{{ __(ucfirst($material->maintenance_schedule)) }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>
            @endif

            <!-- Recent Reservations -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-lg font-semibold">{{ __('Recent Reservations') }}</h2>
                    <a href="{{ route('reservations.index', ['material' => $material->id]) }}" class="text-sm text-accent-violet hover:text-accent-rose transition-colors">
                        {{ __('View all') }} →
                    </a>
                </div>

                @if(isset($recentReservations) && $recentReservations->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentReservations as $reservation)
                            <div class="flex items-center justify-between p-4 glass-card rounded-xl hover:scale-[1.01] transition-all">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-accent-violet to-accent-rose flex items-center justify-center">
                                            <span class="text-sm font-semibold text-white">
                                                {{ substr($reservation->user->name ?? 'U', 0, 2) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium">
                                                {{ $reservation->user->name ?? __('Unknown User') }}
                                            </p>
                                            <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                                {{ $reservation->start_date?->format('d M Y') }} - {{ $reservation->end_date?->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                                    {{ $reservation->status === 'approved' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                    {{ $reservation->status === 'pending' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                    {{ $reservation->status === 'rejected' ? 'bg-accent-rose/10 text-accent-rose' : '' }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ __(ucfirst($reservation->status)) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-accent-cyan/10 mb-4">
                            <svg class="w-8 h-8 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <p class="text-zinc-500 dark:text-zinc-400">{{ __('No reservations yet') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-4 lg:space-y-6">
            <!-- Status Card -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('Status') }}</h2>
                <div class="space-y-4">
                    <div>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Current Status') }}</span>
                        <div class="mt-2">
                            @if($material->status === 'available')
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium bg-accent-emerald/10 text-accent-emerald">
                                    <span class="w-2 h-2 rounded-full bg-current"></span>
                                    {{ __('Available') }}
                                </span>
                            @elseif($material->status === 'maintenance')
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium bg-accent-amber/10 text-accent-amber">
                                    <span class="w-2 h-2 rounded-full bg-current"></span>
                                    {{ __('Maintenance') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium bg-zinc-500/10 text-zinc-500">
                                    <span class="w-2 h-2 rounded-full bg-current"></span>
                                    {{ __('Retired') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 border-t border-black/5 dark:border-white/5">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Available Quantity') }}</span>
                            <span class="text-2xl font-bold font-mono">{{ $material->quantity }}</span>
                        </div>
                        <div class="w-full bg-zinc-200 dark:bg-surface-700 rounded-full h-2.5">
                            <div class="bg-gradient-to-r from-accent-emerald to-accent-cyan h-2.5 rounded-full transition-all" style="width: {{ min(($material->quantity / 10) * 100, 100) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Location Card -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('Location') }}</h2>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-accent-rose/10 flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5 text-accent-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-medium">{{ $material->location }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ __('Storage Location') }}</p>
                    </div>
                </div>
            </div>

            <!-- Category Card -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('Category') }}</h2>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-xl bg-accent-violet/10 flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-base font-medium">{{ $material->category->name ?? __('Uncategorized') }}</p>
                        @if($material->category?->description)
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ $material->category->description }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Maintenance Card -->
            @if($material->maintenance_schedule)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Maintenance') }}</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Schedule') }}</span>
                            <span class="text-sm font-semibold">{{ __(ucfirst($material->maintenance_schedule)) }}</span>
                        </div>
                        @if(isset($lastMaintenance))
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Last Maintenance') }}</span>
                                <span class="text-sm font-semibold">{{ $lastMaintenance->completed_date?->format('d M Y') }}</span>
                            </div>
                        @endif
                        @can('create', App\Models\MaintenanceLog::class)
                            <div class="pt-3 border-t border-black/5 dark:border-white/5">
                                <a href="{{ route('maintenance.create', ['material' => $material->id]) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{ __('Schedule Maintenance') }}
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>
            @endif

            <!-- Actions Card -->
            @canany(['update', 'delete'], $material)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Actions') }}</h2>
                    <div class="space-y-3">
                        @can('update', $material)
                            <a href="{{ route('materials.edit', $material) }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                {{ __('Edit Material') }}
                            </a>
                        @endcan
                        @can('delete', $material)
                            <form method="POST" action="{{ route('materials.destroy', $material) }}"
                                onsubmit="return confirm('{{ __('Are you sure you want to delete this material?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 text-sm font-medium transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    {{ __('Delete Material') }}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            @endcanany
        </div>
    </div>
</x-app-layout>
