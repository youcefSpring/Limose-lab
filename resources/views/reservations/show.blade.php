<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('reservations.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Reservation Details') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Reservation') }} #{{ $reservation->id ?? '---' }}</p>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-medium
            {{ $reservation->status === 'approved' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
            {{ $reservation->status === 'pending' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
            {{ $reservation->status === 'rejected' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
            {{ $reservation->status === 'completed' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
            {{ $reservation->status === 'cancelled' ? 'bg-zinc-500/10 text-zinc-500' : '' }}">
            <span class="w-2 h-2 rounded-full bg-current"></span>
            {{ __(ucfirst($reservation->status ?? 'pending')) }}
        </span>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-4 lg:space-y-6">
            <!-- Material Info -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('Reserved Material') }}</h2>
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0 h-24 w-24 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-surface-700 dark:to-surface-600 rounded-xl overflow-hidden">
                        @if($reservation->material?->image)
                            <img src="{{ asset('storage/' . $reservation->material->image) }}"
                                alt="{{ $reservation->material->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <svg class="h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold">
                            {{ $reservation->material?->name ?? __('Material') }}
                        </h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $reservation->material?->category->name ?? __('Uncategorized') }}
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('materials.show', $reservation->material) }}" class="text-sm text-accent-violet hover:text-accent-rose transition-colors">
                                {{ __('View material details') }} →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservation Details -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Reservation Information') }}</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="glass-card rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Start Date') }}</dt>
                        <dd class="text-base font-semibold">{{ $reservation->start_date?->format('l, d M Y') }}</dd>
                    </div>
                    <div class="glass-card rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('End Date') }}</dt>
                        <dd class="text-base font-semibold">{{ $reservation->end_date?->format('l, d M Y') }}</dd>
                    </div>
                    <div class="glass-card rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Duration') }}</dt>
                        <dd class="text-base font-semibold font-mono">{{ $reservation->start_date?->diffInDays($reservation->end_date) }} {{ __('days') }}</dd>
                    </div>
                    <div class="glass-card rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Quantity') }}</dt>
                        <dd class="text-base font-semibold font-mono">{{ $reservation->quantity }}</dd>
                    </div>
                    <div class="glass-card rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Created At') }}</dt>
                        <dd class="text-base font-semibold">{{ $reservation->created_at?->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="glass-card rounded-xl p-4">
                        <dt class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ __('Status') }}</dt>
                        <dd>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium
                                {{ $reservation->status === 'approved' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                {{ $reservation->status === 'pending' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                {{ $reservation->status === 'rejected' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                                {{ $reservation->status === 'completed' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}
                                {{ $reservation->status === 'cancelled' ? 'bg-zinc-500/10 text-zinc-500' : '' }}">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                {{ __(ucfirst($reservation->status)) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>

            <!-- Purpose -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('Purpose') }}</h2>
                <p class="text-zinc-600 dark:text-zinc-300 whitespace-pre-line leading-relaxed">{{ $reservation->purpose }}</p>
            </div>

            <!-- Notes -->
            @if($reservation->notes)
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Additional Notes') }}</h2>
                    <p class="text-zinc-600 dark:text-zinc-300 whitespace-pre-line leading-relaxed">{{ $reservation->notes }}</p>
                </div>
            @endif

            <!-- Rejection Reason -->
            @if($reservation->status === 'rejected' && $reservation->rejection_reason)
                <div class="glass-card rounded-2xl p-5 lg:p-6 border-{{ app()->getLocale() === 'ar' ? 'r' : 'l' }}-4 border-accent-rose">
                    <div class="flex items-start gap-3">
                        <svg class="h-5 w-5 text-accent-rose flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold mb-2">{{ __('Rejection Reason') }}</h3>
                            <p class="text-sm text-zinc-600 dark:text-zinc-300">{{ $reservation->rejection_reason }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-4 lg:space-y-6">
            <!-- Timeline -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Timeline') }}</h2>
                <div class="space-y-6">
                    <!-- Created -->
                    <div class="flex gap-4">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full bg-accent-cyan/10 flex items-center justify-center">
                                <svg class="h-5 w-5 text-accent-cyan" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            @if($reservation->validated_at)
                                <div class="absolute top-10 left-1/2 w-px h-6 bg-black/10 dark:bg-white/10"></div>
                            @endif
                        </div>
                        <div class="flex-1 pb-6">
                            <p class="text-sm font-medium">{{ __('Reservation Created') }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">{{ $reservation->created_at?->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Validated -->
                    @if($reservation->validated_at)
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full {{ $reservation->status === 'approved' ? 'bg-accent-emerald/10' : 'bg-accent-rose/10' }} flex items-center justify-center">
                                @if($reservation->status === 'approved')
                                    <svg class="h-5 w-5 text-accent-emerald" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-accent-rose" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium">
                                    {{ $reservation->status === 'approved' ? __('Approved') : __('Rejected') }}
                                </p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                                    {{ __('by') }} {{ $reservation->validator?->name ?? __('Admin') }}<br>
                                    {{ $reservation->validated_at?->format('d M Y H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- User Info -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('Reserved By') }}</h2>
                <div class="flex items-center gap-3">
                    <div class="h-12 w-12 rounded-full bg-gradient-to-br from-accent-violet to-accent-rose flex items-center justify-center">
                        <span class="text-lg font-semibold text-white">
                            {{ substr($reservation->user?->name ?? 'U', 0, 2) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-medium">{{ $reservation->user?->name ?? __('Unknown User') }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $reservation->user?->email }}</p>
                    </div>
                </div>
            </div>

            <!-- User Actions -->
            @if(in_array($reservation->status, ['pending', 'approved']) && $reservation->start_date > now())
                <div class="glass-card rounded-2xl p-5 lg:p-6">
                    <h2 class="text-lg font-semibold mb-4">{{ __('Actions') }}</h2>
                    <form method="POST" action="{{ route('reservations.cancel', $reservation) }}"
                        onsubmit="return confirm('{{ __('Are you sure you want to cancel this reservation?') }}')">
                        @csrf
                        <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 text-sm font-medium transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            {{ __('Cancel Reservation') }}
                        </button>
                    </form>
                </div>
            @endif

            <!-- Admin Actions -->
            @can('approve', $reservation)
                @if($reservation->status === 'pending')
                    <div class="glass-card rounded-2xl p-5 lg:p-6">
                        <h2 class="text-lg font-semibold mb-4">{{ __('Manager Actions') }}</h2>
                        <div class="space-y-3">
                            <form method="POST" action="{{ route('reservations.approve', $reservation) }}">
                                @csrf
                                <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-accent-emerald/10 text-accent-emerald hover:bg-accent-emerald/20 text-sm font-medium transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    {{ __('Approve Reservation') }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('reservations.reject', $reservation) }}"
                                onsubmit="return confirm('{{ __('Are you sure you want to reject this reservation?') }}')">
                                @csrf
                                <textarea name="rejection_reason" rows="2" placeholder="{{ __('Rejection reason (optional)') }}"
                                    class="w-full mb-2 py-2 px-3 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none text-sm"></textarea>
                                <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-accent-rose/10 text-accent-rose hover:bg-accent-rose/20 text-sm font-medium transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    {{ __('Reject Reservation') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endcan
        </div>
    </div>
</x-app-layout>
