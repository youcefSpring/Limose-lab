<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Rooms') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Manage laboratory and office rooms') }}</p>
        </div>
        <div class="flex items-center gap-2">
            @can('create', App\Models\Room::class)
                <a href="{{ route('rooms.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-teal to-accent-cyan px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add Room') }}
                </a>
            @endcan
        </div>
    </header>

    <!-- Rooms List -->
    @if($rooms->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
            @foreach($rooms as $room)
                <div class="glass-card rounded-2xl p-5 lg:p-6 hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-lg font-semibold">{{ $room->name }}</h3>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-accent-teal/10 text-accent-teal">
                                    {{ $room->room_number }}
                                </span>
                            </div>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 capitalize">
                                {{ str_replace('_', ' ', $room->roomType->name) }}
                            </p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            {{ $room->status === 'available' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                            {{ $room->status === 'occupied' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                            {{ $room->status === 'maintenance' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                            {{ $room->status === 'reserved' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}">
                            {{ __(ucfirst($room->status)) }}
                        </span>
                    </div>

                    <div class="space-y-2 mb-4">
                        @if($room->capacity)
                            <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span>{{ __('Capacity') }}: {{ $room->capacity }}</span>
                            </div>
                        @endif
                        @if($room->floor)
                            <div class="flex items-center gap-2 text-sm text-zinc-600 dark:text-zinc-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span>{{ __('Floor') }}: {{ $room->floor }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 pt-4 border-t border-black/10 dark:border-white/10">
                        @can('update', $room)
                            <a href="{{ route('rooms.edit', $room) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                {{ __('Edit') }}
                            </a>
                        @endcan
                        @can('delete', $room)
                            <x-delete-confirmation-modal
                                :action="route('rooms.destroy', $room)"
                                :title="__('Delete Room')"
                                :message="__('Are you sure you want to delete this room? This action cannot be undone.')">
                                <x-slot name="trigger">{{ __('Delete') }}</x-slot>
                            </x-delete-confirmation-modal>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $rooms->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium">{{ __('No rooms found') }}</h3>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Get started by adding your first room.') }}</p>
            @can('create', App\Models\Room::class)
                <div class="mt-6">
                    <a href="{{ route('rooms.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-teal to-accent-cyan px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('Add Room') }}
                    </a>
                </div>
            @endcan
        </div>
    @endif
</x-app-layout>
