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
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Edit Room') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Update room information') }}</p>
            </div>
        </div>
    </header>

    <div class="w-full">
        <form method="POST" action="{{ route('rooms.update', $room) }}">
            @csrf
            @method('PUT')

            <div class="glass-card rounded-2xl p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-1">{{ __('Room Information') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Update the room details') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Room Name -->
                    <x-ui.input
                        name="name"
                        :label="__('Room Name')"
                        :value="$room->name"
                        :placeholder="__('e.g., Conference Room A')"
                        :required="true"
                    />

                    <!-- Room Number -->
                    <x-ui.input
                        name="room_number"
                        :label="__('Room Number')"
                        :value="$room->room_number"
                        :placeholder="__('e.g., A-101')"
                        :required="true"
                    />

                    <!-- Room Type -->
                    <x-ui.select
                        name="room_type_id"
                        :label="__('Room Type')"
                        :placeholder="__('Select room type')"
                        :required="true"
                    >
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>
                                {{ __(ucfirst(str_replace('_', ' ', $type->name))) }}
                            </option>
                        @endforeach
                    </x-ui.select>

                    <!-- Status -->
                    <x-ui.select
                        name="status"
                        :label="__('Status')"
                        :required="true"
                    >
                        <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>{{ __('Available') }}</option>
                        <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>{{ __('Occupied') }}</option>
                        <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                        <option value="reserved" {{ old('status', $room->status) == 'reserved' ? 'selected' : '' }}>{{ __('Reserved') }}</option>
                    </x-ui.select>

                    <!-- Capacity -->
                    <x-ui.input
                        name="capacity"
                        type="number"
                        :label="__('Capacity')"
                        :value="$room->capacity"
                        :placeholder="__('e.g., 20')"
                        min="1"
                    />

                    <!-- Floor -->
                    <x-ui.input
                        name="floor"
                        :label="__('Floor')"
                        :value="$room->floor"
                        :placeholder="__('e.g., 1st Floor, Ground Floor')"
                    />

                    <!-- Description - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <x-ui.textarea
                            name="description"
                            :label="__('Description')"
                            :value="$room->description"
                            :placeholder="__('Provide additional details about the room...')"
                            rows="3"
                        />
                    </div>

                    <!-- Equipment - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <x-ui.textarea
                            name="equipment"
                            :label="__('Equipment')"
                            :value="$room->equipment"
                            :placeholder="__('List available equipment (e.g., projector, whiteboard, computer...)')"
                            rows="3"
                        />
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 mt-6">
                <x-ui.button variant="secondary" href="{{ route('rooms.index') }}" size="md">
                    {{ __('Cancel') }}
                </x-ui.button>
                <x-ui.button variant="success" type="submit" size="md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('Update Room') }}
                </x-ui.button>
            </div>
        </form>
    </div>
</x-app-layout>
