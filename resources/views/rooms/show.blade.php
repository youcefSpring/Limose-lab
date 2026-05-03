<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('rooms.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ $room->name }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ $room->room_number }}</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            @can('update', $room)
                <a href="{{ route('rooms.edit', $room) }}" class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    {{ __('messages.Edit') }}
                </a>
            @endcan
        </div>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-4 lg:space-y-6">
            <!-- Room Image -->
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="relative h-80 lg:h-96 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-surface-700 dark:to-surface-600">
                    <div class="flex items-center justify-center h-full">
                        <svg class="h-32 w-32 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($room->description)
            <div class="glass-card rounded-2xl p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('messages.Description') }}</h2>
                <p class="text-zinc-600 dark:text-zinc-300 whitespace-pre-line">{{ $room->description }}</p>
            </div>
            @endif

            <!-- Equipment -->
            @if($room->equipment)
            <div class="glass-card rounded-2xl p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('messages.Equipment') }}</h2>
                <p class="text-zinc-600 dark:text-zinc-300 whitespace-pre-line">{{ $room->equipment }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-4 lg:space-y-6">
            <!-- Room Info -->
            <div class="glass-card rounded-2xl p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('messages.Room Information') }}</h2>
                <div class="space-y-4">
                    <!-- Status -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Status') }}</span>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium
                            @if($room->status === 'available') bg-accent-emerald/10 text-accent-emerald
                            @elseif($room->status === 'occupied') bg-accent-amber/10 text-accent-amber
                            @elseif($room->status === 'maintenance') bg-accent-rose/10 text-accent-rose
                            @else bg-accent-violet/10 text-accent-violet @endif">
                            {{ __('messages.' . ucfirst($room->status)) }}
                        </span>
                    </div>

                    <!-- Room Type -->
                    @if($room->roomType)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Room Type') }}</span>
                        <span class="text-sm font-medium">{{ $room->roomType->name }}</span>
                    </div>
                    @endif

                    <!-- Capacity -->
                    @if($room->capacity)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Capacity') }}</span>
                        <span class="text-sm font-medium">{{ $room->capacity }}</span>
                    </div>
                    @endif

                    <!-- Floor -->
                    @if($room->floor)
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Floor') }}</span>
                        <span class="text-sm font-medium">{{ $room->floor }}</span>
                    </div>
                    @endif

                    <!-- Room Number -->
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Room Number') }}</span>
                        <span class="text-sm font-medium">{{ $room->room_number }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="glass-card rounded-2xl p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('messages.Quick Actions') }}</h2>
                <div class="space-y-2">
                    <a href="{{ route('rooms.index') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                        <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <span class="text-sm">{{ __('messages.View all') }} {{ __('messages.Rooms') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>