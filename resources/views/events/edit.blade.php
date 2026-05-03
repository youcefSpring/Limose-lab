<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('events.show', $event) }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('messages.Edit Event') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('messages.Update event details and information') }}</p>
            </div>
        </div>
    </header>

    <div>
        <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Event Information -->
            <div class="glass-card rounded-2xl p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-1">{{ __('messages.Event Information') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Update details about your event') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Event Title (Full Width) -->
                    <div class="lg:col-span-3">
                        <label for="title" class="block text-sm font-medium mb-2">
                            {{ __('messages.Event Title') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" required
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
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('type') border-accent-rose @enderror">
                            <option value="seminar" {{ old('type', $event->type) == 'seminar' ? 'selected' : '' }}>{{ __('messages.Seminar') }}</option>
                            <option value="workshop" {{ old('type', $event->type) == 'workshop' ? 'selected' : '' }}>{{ __('messages.Workshop') }}</option>
                            <option value="conference" {{ old('type', $event->type) == 'conference' ? 'selected' : '' }}>{{ __('messages.Conference') }}</option>
                            <option value="meeting" {{ old('type', $event->type) == 'meeting' ? 'selected' : '' }}>{{ __('messages.Meeting') }}</option>
                            <option value="training" {{ old('type', $event->type) == 'training' ? 'selected' : '' }}>{{ __('messages.Training') }}</option>
                            <option value="other" {{ old('type', $event->type) == 'other' ? 'selected' : '' }}>{{ __('messages.Other') }}</option>
                        </select>
                        @error('type')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium mb-2">
                            {{ __('messages.Date') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="date" name="date" id="date" required min="{{ date('Y-m-d') }}" value="{{ old('date', $event->date?->format('Y-m-d')) }}"
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
                        <input type="time" name="time" id="time" required value="{{ old('time', $event->date?->format('H:i')) }}"
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
                        <input type="text" name="location" id="location" required value="{{ old('location', $event->location) }}"
                            placeholder="{{ __('messages.e.g., Lab Room 301 or Online via Zoom') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('location') border-accent-rose @enderror">
                        @error('location')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Attendees -->
                    <div>
                        <label for="max_attendees" class="block text-sm font-medium mb-2">
                            {{ __('messages.Maximum Attendees') }}
                        </label>
                        <input type="number" name="max_attendees" id="max_attendees" min="1" value="{{ old('max_attendees', $event->max_attendees) }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all font-mono @error('max_attendees') border-accent-rose @enderror"
                            placeholder="{{ __('messages.Unlimited') }}">
                        @error('max_attendees')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                            {{ __('messages.Current attendees') }}: {{ $event->attendees_count ?? 0 }}
                        </p>
                    </div>

                    <!-- Description (Full Width) -->
                    <div class="lg:col-span-3">
                        <label for="description" class="block text-sm font-medium mb-2">
                            {{ __('messages.Description') }} <span class="text-accent-rose">*</span>
                        </label>
                        <textarea name="description" id="description" rows="3" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('description') border-accent-rose @enderror"
                            placeholder="{{ __('messages.Provide a detailed description of the event...') }}">{{ old('description', $event->description) }}</textarea>
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
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('agenda') border-accent-rose @enderror">{{ old('agenda', $event->agenda) }}</textarea>
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
                            :currentFile="isset($event) && $event->image ? asset('storage/' . $event->image) : null"
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
                                    <p class="font-medium mb-2">{{ __('messages.Update Guidelines') }}:</p>
                                    <ul class="space-y-1 text-zinc-600 dark:text-zinc-400 text-xs">
                                        <li class="flex gap-2">
                                            <span class="text-accent-cyan">•</span>
                                            <span>{{ __('messages.All registered attendees will be notified of any changes') }}</span>
                                        </li>
                                        <li class="flex gap-2">
                                            <span class="text-accent-cyan">•</span>
                                            <span>{{ __('messages.Ensure all event information remains accurate and complete') }}</span>
                                        </li>
                                        <li class="flex gap-2">
                                            <span class="text-accent-cyan">•</span>
                                            <span>{{ __('messages.Major changes should be communicated well in advance') }}</span>
                                        </li>
                                        <li class="flex gap-2">
                                            <span class="text-accent-cyan">•</span>
                                            <span>{{ __('messages.Current attendees') }}: {{ $event->attendees_count ?? 0 }}</span>
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
                <a href="{{ route('events.show', $event) }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('messages.Cancel') }}
                </a>
                <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-emerald to-accent-cyan px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('messages.Update Event') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
