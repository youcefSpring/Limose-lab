<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('events.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('messages.Create New Event') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('messages.Organize seminars, workshops, and laboratory events') }}</p>
            </div>
        </div>
    </header>

    <div class="w-full">
        <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Event Information -->
            <div class="glass-card rounded-2xl p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-1">{{ __('messages.Event Information') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Basic details about your event') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Event Title (Full Width) -->
                    <div class="lg:col-span-3">
                        <label for="title" class="block text-sm font-medium mb-2">
                            {{ __('messages.Event Title') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('title') border-accent-rose @enderror"
                            placeholder="{{ __('messages.e.g., Machine Learning Workshop 2024') }}">
                        @error('title')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

<!-- Event Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium mb-2">
                            {{ __('messages.Event Type') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="type" id="type" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('type') border-accent-rose @error">
                            <option value="seminar" {{ old('type', 'seminar') == 'seminar' ? 'selected' : '' }}>{{ __('messages.Seminar') }}</option>
                            <option value="workshop" {{ old('type') == 'workshop' ? 'selected' : '' }}>{{ __('messages.Workshop') }}</option>
                            <option value="conference" {{ old('type') == 'conference' ? 'selected' : '' }}>{{ __('messages.Conference') }}</option>
                            <option value="meeting" {{ old('type') == 'meeting' ? 'selected' : '' }}>{{ __('messages.Meeting') }}</option>
                            <option value="training" {{ old('type') == 'training' ? 'selected' : '' }}>{{ __('messages.Training') }}</option>
                            <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>{{ __('messages.Other') }}</option>
                        </select>
                        @error('type')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="event_date" class="block text-sm font-medium mb-2">
                            {{ __('messages.Date') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="date" name="event_date" id="event_date" required min="{{ date('Y-m-d') }}" value="{{ old('event_date') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('event_date') border-accent-rose @enderror">
                        @error('event_date')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

<!-- Time -->
                    <div>
                        <label for="event_time" class="block text-sm font-medium mb-2">
                            {{ __('messages.Time') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="time" name="event_time" id="event_time" required value="{{ old('event_time') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('event_time') border-accent-rose @enderror">
                        @error('event_time')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium mb-2">
                            {{ __('messages.Date') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="date" name="date" id="date" required min="{{ date('Y-m-d') }}" value="{{ old('date') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('date') border-accent-rose @enderror">
                        @error('date')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Time -->
                    <div>
                        <label for="time" class="block text-sm font-medium mb-2">
                            {{ __('messages.Time') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="time" name="time" id="time" required value="{{ old('time') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('time') border-accent-rose @enderror">
                        @error('time')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="lg:col-span-2">
                        <label for="location" class="block text-sm font-medium mb-2">
                            {{ __('messages.Location') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="text" name="location" id="location" required value="{{ old('location') }}"
                            placeholder="{{ __('messages.e.g., Lab Room 301 or Online via Zoom') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('location') border-accent-rose @enderror">
                        @error('location')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

<!-- Max Attendees -->
                    <div>
                        <label for="capacity" class="block text-sm font-medium mb-2">
                            {{ __('messages.Maximum Attendees') }}
                        </label>
                        <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all font-mono @error('capacity') border-accent-rose @enderror"
                            placeholder="{{ __('messages.Unlimited') }}">
                        @error('capacity')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description (Full Width) -->
                    <div class="lg:col-span-3">
                        <label for="description" class="block text-sm font-medium mb-2">
                            {{ __('messages.Description') }} <span class="text-accent-rose">*</span>
                        </label>
                        <textarea name="description" id="description" rows="3" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('description') border-accent-rose @enderror"
                            placeholder="{{ __('messages.Provide a detailed description of the event...') }}">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Agenda (Full Width) -->
                    <div class="lg:col-span-3">
                        <label for="agenda" class="block text-sm font-medium mb-2">
                            {{ __('messages.Agenda') }}
                        </label>
                        <textarea name="agenda" id="agenda" rows="3"
                            placeholder="{{ __('messages.Outline the event agenda and schedule...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('agenda') border-accent-rose @enderror">{{ old('agenda') }}</textarea>
                        @error('agenda')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                            {{ __('messages.Optional: Provide a detailed schedule or agenda for the event') }}
                        </p>
                    </div>

                    <!-- Image Upload (Full Width) -->
                    <div class="lg:col-span-3">
                        <x-file-upload
                            name="image"
                            label="{{ __('messages.Event Image') }}"
                            accept="image/*,.pdf"
                            maxSize="10MB"
                            :currentFile="null"
                        />
                    </div>

                    <!-- Info Box (Full Width) -->
                    <div class="lg:col-span-3">
                        <div class="glass rounded-xl p-4 border border-accent-cyan/20">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 text-sm">
                                    <p class="font-medium mb-2">{{ __('messages.Event Guidelines') }}:</p>
                                    <ul class="space-y-1 text-zinc-600 dark:text-zinc-400 text-xs">
                                        <li class="flex gap-2">
                                            <span class="text-accent-cyan">•</span>
                                            <span>{{ __('messages.Ensure all event information is accurate and complete') }}</span>
                                        </li>
                                        <li class="flex gap-2">
                                            <span class="text-accent-cyan">•</span>
                                            <span>{{ __('messages.Attendees will be notified via email once they RSVP') }}</span>
                                        </li>
                                        <li class="flex gap-2">
                                            <span class="text-accent-cyan">•</span>
                                            <span>{{ __('messages.You can edit event details anytime before the event date') }}</span>
                                        </li>
                                        <li class="flex gap-2">
                                            <span class="text-accent-cyan">•</span>
                                            <span>{{ __('messages.Consider setting a maximum capacity for physical events') }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between gap-3 mt-6">
                <a href="{{ route('events.index') }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('messages.Cancel') }}
                </a>
                <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-emerald to-accent-cyan px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('messages.Create Event') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
