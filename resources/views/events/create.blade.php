<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
            <a href="{{ route('events.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create New Event') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-card>
            <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Event Title') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}"
                        placeholder="{{ __('Enter event title...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Description') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="4" required
                        placeholder="{{ __('Provide a detailed description of the event...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Event Type') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="type" id="type" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('type') border-red-500 @enderror">
                        <option value="seminar" {{ old('type', 'seminar') == 'seminar' ? 'selected' : '' }}>{{ __('Seminar') }}</option>
                        <option value="workshop" {{ old('type') == 'workshop' ? 'selected' : '' }}>{{ __('Workshop') }}</option>
                        <option value="conference" {{ old('type') == 'conference' ? 'selected' : '' }}>{{ __('Conference') }}</option>
                        <option value="meeting" {{ old('type') == 'meeting' ? 'selected' : '' }}>{{ __('Meeting') }}</option>
                        <option value="training" {{ old('type') == 'training' ? 'selected' : '' }}>{{ __('Training') }}</option>
                        <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date and Time -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Date') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date" id="date" required
                            min="{{ date('Y-m-d') }}"
                            value="{{ old('date') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('date') border-red-500 @enderror">
                        @error('date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Time') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="time" id="time" required
                            value="{{ old('time') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('time') border-red-500 @enderror">
                        @error('time')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Location') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location" id="location" required value="{{ old('location') }}"
                        placeholder="{{ __('e.g., Lab Room 301 or Online via Zoom') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('location') border-red-500 @enderror">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Agenda -->
                <div>
                    <label for="agenda" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Agenda') }}
                    </label>
                    <textarea name="agenda" id="agenda" rows="5"
                        placeholder="{{ __('Outline the event agenda and schedule...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('agenda') border-red-500 @enderror">{{ old('agenda') }}</textarea>
                    @error('agenda')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Optional: Provide a detailed schedule or agenda for the event') }}
                    </p>
                </div>

                <!-- Max Attendees -->
                <div>
                    <label for="max_attendees" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Maximum Attendees') }}
                    </label>
                    <input type="number" name="max_attendees" id="max_attendees" min="1"
                        value="{{ old('max_attendees') }}"
                        placeholder="{{ __('Leave blank for unlimited') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('max_attendees') border-red-500 @enderror">
                    @error('max_attendees')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Limit the number of people who can attend this event') }}
                    </p>
                </div>

                <!-- Event Image -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Event Image') }}
                    </label>
                    <div class="mt-1 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-gray-400 dark:hover:border-gray-500 transition-colors">
                        <input id="image" name="image" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                        <label for="image" class="cursor-pointer">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Click to upload or drag and drop') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                {{ __('PNG, JPG up to 2MB') }}
                            </p>
                        </label>
                    </div>
                    @error('image')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Important Information -->
                <x-alert type="info" :dismissible="false">
                    <strong>{{ __('Event Guidelines') }}:</strong>
                    <ul class="list-disc {{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }} mt-2 text-sm space-y-1">
                        <li>{{ __('Ensure all event information is accurate and complete') }}</li>
                        <li>{{ __('Attendees will be notified via email once they RSVP') }}</li>
                        <li>{{ __('You can edit event details anytime before the event date') }}</li>
                        <li>{{ __('Consider setting a maximum capacity for physical events') }}</li>
                    </ul>
                </x-alert>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('events.index') }}">
                        <x-button variant="outline" type="button">{{ __('Cancel') }}</x-button>
                    </a>
                    <x-button variant="primary" type="submit">
                        {{ __('Create Event') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
