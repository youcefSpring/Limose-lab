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
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('messages.Add New Room') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('messages.Create a new room in the system') }}</p>
            </div>
        </div>
    </header>

    <div class="w-full">
        <form method="POST" action="{{ route('rooms.store') }}">
            @csrf

            <div class="glass-card rounded-2xl p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-1">{{ __('messages.Room Information') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Fill in the details for the new room') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Room Name -->
                    <x-ui.input
                        name="name"
                        :label="__('messages.Room Name')"
                        :placeholder="__('messages.e.g., Conference Room A')"
                        :required="true"
                    />

                    <!-- Room Number -->
                    <x-ui.input
                        name="room_number"
                        :label="__('messages.Room Number')"
                        :placeholder="__('messages.e.g., A-101')"
                        :required="true"
                    />

                    <!-- Room Type -->
                    <div>
                        <label for="room_type_id" class="block text-sm font-medium mb-2">
                            {{ __('messages.Room Type') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="room_type_id" id="room_type_id" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all @error('room_type_id') border-accent-rose @enderror">
                            <option value="">{{ __('messages.Select room type') }}</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ __(ucfirst(str_replace('_', ' ', $type->name))) }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_type_id')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">
                            {{ __('messages.Status') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all @error('status') border-accent-rose @enderror">
                            <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>{{ __('messages.Available') }}</option>
                            <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>{{ __('messages.Occupied') }}</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>{{ __('messages.Maintenance') }}</option>
                            <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>{{ __('messages.Reserved') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacity -->
                    <x-ui.input
                        name="capacity"
                        type="number"
                        :label="__('messages.Capacity')"
                        :placeholder="__('messages.e.g., 20')"
                        min="1"
                    />

                    <!-- Floor -->
                    <x-ui.input
                        name="floor"
                        :label="__('messages.Floor')"
                        :placeholder="__('messages.e.g., 1st Floor, Ground Floor')"
                    />

                    <!-- Description - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="description" class="block text-sm font-medium mb-2">
                            {{ __('messages.Description') }}
                        </label>
                        <textarea name="description" id="description" rows="3"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all resize-none @error('description') border-accent-rose @enderror"
                            placeholder="{{ __('messages.Provide additional details about the room...') }}">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Equipment - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="equipment" class="block text-sm font-medium mb-2">
                            {{ __('messages.Equipment') }}
                        </label>
                        <textarea name="equipment" id="equipment" rows="3"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all resize-none @error('equipment') border-accent-rose @enderror"
                            placeholder="{{ __('messages.List available equipment (e.g., projector, whiteboard, computer...)') }}">{{ old('equipment') }}</textarea>
                        @error('equipment')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 mt-6">
                <a href="{{ route('rooms.index') }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('messages.Cancel') }}
                </a>
                <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-emerald to-accent-cyan px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('messages.Create Room') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
