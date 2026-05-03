<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('messages.Rooms') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('messages.Manage laboratory and office rooms') }}</p>
        </div>
        @can('create', App\Models\Room::class)
            <a href="{{ route('rooms.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('messages.Add Room') }}
            </a>
        @endcan
    </header>

    <!-- Results Count -->
    @if(isset($rooms) && $rooms->total() > 0)
        <div class="glass-card rounded-xl px-4 py-3 mb-6">
            <span class="text-sm text-zinc-600 dark:text-zinc-300">
                Found <strong class="font-semibold text-zinc-900 dark:text-white">{{ $rooms->total() }}</strong> rooms
            </span>
        </div>
    @endif

    <!-- Rooms Table -->
    @if($rooms->count() > 0)
        <div class="glass-card rounded-2xl overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-surface-800/50 border-b border-black/5 dark:border-white/5">
                        <tr>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('messages.Room') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('messages.Number') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('messages.Type') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('messages.Capacity') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('messages.Floor') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('messages.Status') }}</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">{{ __('messages.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5">
                        @foreach($rooms as $room)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-white/5 transition-colors">
                                <!-- Room Name -->
                                <td class="px-6 py-4">
                                    <p class="font-medium">{{ $room->name }}</p>
                                    @if($room->description)
                                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1 line-clamp-1">{{ $room->description }}</p>
                                    @endif
                                </td>

                                <!-- Room Number -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-accent-teal/10 text-accent-teal font-mono">
                                        {{ $room->room_number }}
                                    </span>
                                </td>

                                <!-- Type -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 capitalize">
                                        {{ str_replace('_', ' ', $room->roomType->name) }}
                                    </p>
                                </td>

                                <!-- Capacity -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300 font-mono">
                                        {{ $room->capacity ?? '-' }}
                                    </p>
                                </td>

                                <!-- Floor -->
                                <td class="px-6 py-4">
                                    <p class="text-sm text-zinc-600 dark:text-zinc-300">
                                        {{ $room->floor ?? '-' }}
                                    </p>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium
                                        {{ $room->status === 'available' ? 'bg-accent-emerald/10 text-accent-emerald' : '' }}
                                        {{ $room->status === 'occupied' ? 'bg-accent-amber/10 text-accent-amber' : '' }}
                                        {{ $room->status === 'maintenance' ? 'bg-accent-rose/10 text-accent-rose' : '' }}
                                        {{ $room->status === 'reserved' ? 'bg-accent-cyan/10 text-accent-cyan' : '' }}">
                                        @if($room->status === 'available')
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                        @endif
                                        {{ __(ucfirst($room->status)) }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <x-ui.action-button
                                            variant="view"
                                            :href="route('rooms.show', $room)"
                                            :title="__('messages.View')"
                                        />
                                        @can('update', $room)
                                            <x-ui.action-button
                                                variant="edit"
                                                :href="route('rooms.edit', $room)"
                                                :title="__('messages.Edit')"
                                            />
                                        @endcan
                                        @can('delete', $room)
                                            <form method="POST" action="{{ route('rooms.destroy', $room) }}" class="inline-block" onsubmit="return confirm('{{ __('messages.Are you sure you want to delete this room?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <x-ui.action-button
                                                    variant="delete"
                                                    type="submit"
                                                    :title="__('messages.Delete')"
                                                />
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
                Showing <span class="font-medium">{{ $rooms->firstItem() }}</span>
                to <span class="font-medium">{{ $rooms->lastItem() }}</span>
                of <span class="font-medium">{{ $rooms->total() }}</span> rooms
            </div>
            <div>
                {{ $rooms->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent-teal/10 mb-6">
                <svg class="w-10 h-10 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ __('messages.No rooms found') }}</h3>
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 max-w-md mx-auto">
                {{ __('messages.Get started by adding your first room.') }}
            </p>
            @can('create', App\Models\Room::class)
                <a href="{{ route('rooms.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('messages.Add Room') }}
                </a>
            @endcan
        </div>
    @endif
</x-app-layout>
