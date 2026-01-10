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
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Add New Room') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Create a new room in the system') }}</p>
            </div>
        </div>
    </header>

    <div class="max-w-3xl">
        <form method="POST" action="{{ route('rooms.store') }}" class="space-y-6">
            @csrf

            <!-- Basic Information Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Basic Information') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Room Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium mb-2">
                            {{ __('Room Name') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all @error('name') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., Conference Room A') }}">
                        @error('name')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Room Number -->
                    <div>
                        <label for="room_number" class="block text-sm font-medium mb-2">
                            {{ __('Room Number') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="text" name="room_number" id="room_number" value="{{ old('room_number') }}" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all @error('room_number') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., A-101') }}">
                        @error('room_number')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Room Type -->
                    <div>
                        <label for="room_type_id" class="block text-sm font-medium mb-2">
                            {{ __('Room Type') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="room_type_id" id="room_type_id" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all @error('room_type_id') border-accent-rose @enderror">
                            <option value="">{{ __('Select room type') }}</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ __(ucfirst(str_replace('_', ' ', $type->name))) }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_type_id')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">
                            {{ __('Status') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all @error('status') border-accent-rose @enderror">
                            <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>{{ __('Available') }}</option>
                            <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>{{ __('Occupied') }}</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                            <option value="reserved" {{ old('status') == 'reserved' ? 'selected' : '' }}>{{ __('Reserved') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Capacity -->
                    <div>
                        <label for="capacity" class="block text-sm font-medium mb-2">
                            {{ __('Capacity') }}
                        </label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" min="1"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all font-mono @error('capacity') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., 20') }}">
                        @error('capacity')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Floor -->
                    <div>
                        <label for="floor" class="block text-sm font-medium mb-2">
                            {{ __('Floor') }}
                        </label>
                        <input type="text" name="floor" id="floor" value="{{ old('floor') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all @error('floor') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., 1st Floor, Ground Floor') }}">
                        @error('floor')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-5">
                    <label for="description" class="block text-sm font-medium mb-2">
                        {{ __('Description') }}
                    </label>
                    <textarea name="description" id="description" rows="3"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all resize-none @error('description') border-accent-rose @enderror"
                        placeholder="{{ __('Provide additional details about the room...') }}">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Equipment -->
                <div class="mt-5">
                    <label for="equipment" class="block text-sm font-medium mb-2">
                        {{ __('Equipment') }}
                    </label>
                    <textarea name="equipment" id="equipment" rows="3"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all resize-none @error('equipment') border-accent-rose @enderror"
                        placeholder="{{ __('List available equipment (e.g., projector, whiteboard, computer...)') }}">{{ old('equipment') }}</textarea>
                    @error('equipment')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('rooms.index') }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-teal to-accent-cyan px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('Create Room') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
