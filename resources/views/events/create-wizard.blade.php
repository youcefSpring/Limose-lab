<x-app-layout>
    <!-- Breadcrumbs -->
    <x-breadcrumbs :items="[
        ['label' => __('Events'), 'url' => route('events.index')],
        ['label' => __('Create Event')]
    ]" />

    <!-- Page Header -->
    <x-ui.page-header
        :title="__('Create New Event')"
        :description="__('Organize seminars, workshops, and laboratory events')"
        :backUrl="route('events.index')"
    />

    <form method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" x-data="{ currentStep: 1, eventType: '{{ old('event_type', 'seminar') }}' }">
        @csrf

        <!-- Stepper -->
        <x-ui.stepper :steps="[
            __('Event Details'),
            __('Schedule & Location'),
            __('Description & Agenda'),
            __('Review & Submit')
        ]">
            <!-- Step 1: Event Details -->
            <x-ui.step :step="1">
                <x-ui.card>
                    <div class="space-y-6">
                        <!-- Event Title -->
                        <x-ui.input
                            label="{{ __('Event Title') }}"
                            name="title"
                            :required="true"
                            :error="$errors->first('title')"
                            placeholder="Machine Learning Workshop 2024"
                        />

                        <!-- Event Type -->
                        <x-ui.select
                            label="{{ __('Event Type') }}"
                            name="event_type"
                            :required="true"
                            :error="$errors->first('event_type')"
                            x-model="eventType"
                        >
                            <option value="seminar" {{ old('event_type', 'seminar') == 'seminar' ? 'selected' : '' }}>{{ __('Seminar') }}</option>
                            <option value="workshop" {{ old('event_type') == 'workshop' ? 'selected' : '' }}>{{ __('Workshop') }}</option>
                            <option value="conference" {{ old('event_type') == 'conference' ? 'selected' : '' }}>{{ __('Conference') }}</option>
                            <option value="meeting" {{ old('event_type') == 'meeting' ? 'selected' : '' }}>{{ __('Meeting') }}</option>
                        </x-ui.select>

                        <!-- Type Information Box -->
                        <div class="glass rounded-xl p-4 border border-accent-cyan/20" x-show="eventType">
                            <div class="flex gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 text-sm">
                                    <p class="font-medium mb-1" x-text="{
                                        'seminar': '{{ __('Seminar Event') }}',
                                        'workshop': '{{ __('Workshop Event') }}',
                                        'conference': '{{ __('Conference Event') }}',
                                        'meeting': '{{ __('Meeting Event') }}'
                                    }[eventType]"></p>
                                    <p class="text-zinc-600 dark:text-zinc-400 text-xs" x-text="{
                                        'seminar': '{{ __('Educational presentation or lecture on a specific topic') }}',
                                        'workshop': '{{ __('Interactive training session with hands-on activities') }}',
                                        'conference': '{{ __('Large academic gathering with paper submissions and presentations') }}',
                                        'meeting': '{{ __('Team meeting or group discussion') }}'
                                    }[eventType]"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-ui.card>
            </x-ui.step>

            <!-- Step 2: Schedule & Location -->
            <x-ui.step :step="2">
                <x-ui.card>
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Date -->
                            <x-ui.input
                                label="{{ __('Date') }}"
                                name="event_date"
                                type="date"
                                :required="true"
                                :error="$errors->first('event_date')"
                                :min="date('Y-m-d')"
                            />

                            <!-- Time -->
                            <x-ui.input
                                label="{{ __('Time') }}"
                                name="event_time"
                                type="time"
                                :error="$errors->first('event_time')"
                            />
                        </div>

                        <!-- Location -->
                        <x-ui.input
                            label="{{ __('Location') }}"
                            name="location"
                            :error="$errors->first('location')"
                            placeholder="Lab Room 301 or Online via Zoom"
                        />

                        <!-- Capacity -->
                        <x-ui.input
                            label="{{ __('Maximum Attendees') }}"
                            name="capacity"
                            type="number"
                            :error="$errors->first('capacity')"
                            min="1"
                            placeholder="{{ __('Unlimited') }}"
                            hint="{{ __('Leave empty for unlimited capacity') }}"
                        />
                    </div>
                </x-ui.card>
            </x-ui.step>

            <!-- Step 3: Description & Agenda -->
            <x-ui.step :step="3">
                <x-ui.card>
                    <div class="space-y-6">
                        <!-- Description -->
                        <div class="space-y-2">
                            <label for="description" class="block text-sm font-medium">
                                {{ __('Description') }} <span class="text-accent-rose">*</span>
                            </label>
                            <textarea name="description" id="description" rows="5" required
                                class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} px-4 py-2.5 bg-white dark:bg-surface-700/50 border {{ $errors->has('description') ? 'border-accent-rose' : 'border-black/10 dark:border-white/10' }} rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-indigo/50 focus:border-accent-indigo transition-all resize-none"
                                placeholder="{{ __('Provide a detailed description of the event...') }}">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-xs text-accent-rose">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Event Image -->
                        <div>
                            <x-file-upload
                                name="image"
                                label="{{ __('Event Image') }}"
                                accept="image/*"
                                maxSize="5MB"
                            />
                        </div>
                    </div>
                </x-ui.card>
            </x-ui.step>

            <!-- Step 4: Review & Submit -->
            <x-ui.step :step="4">
                <div class="space-y-6">
                    <!-- Event Summary Card -->
                    <x-ui.card padding="lg">
                        <div class="text-center py-6">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-r from-accent-emerald to-accent-cyan mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold mb-2">{{ __('Event Ready to Publish') }}</h3>
                            <p class="text-zinc-600 dark:text-zinc-400 mb-6">
                                {{ __('Review your event information and click submit to create your event.') }}
                            </p>
                        </div>
                    </x-ui.card>

                    <!-- Guidelines -->
                    <x-ui.card>
                        <div class="flex gap-3">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1 text-sm">
                                <p class="font-medium mb-2">{{ __('Event Guidelines') }}:</p>
                                <ul class="space-y-1 text-zinc-600 dark:text-zinc-400 text-xs">
                                    <li class="flex gap-2">
                                        <span class="text-accent-cyan">•</span>
                                        <span>{{ __('Ensure all event information is accurate and complete') }}</span>
                                    </li>
                                    <li class="flex gap-2">
                                        <span class="text-accent-cyan">•</span>
                                        <span>{{ __('Attendees will be notified via email once they RSVP') }}</span>
                                    </li>
                                    <li class="flex gap-2">
                                        <span class="text-accent-cyan">•</span>
                                        <span>{{ __('You can edit event details anytime before the event date') }}</span>
                                    </li>
                                    <li class="flex gap-2">
                                        <span class="text-accent-cyan">•</span>
                                        <span>{{ __('Consider setting a maximum capacity for physical events') }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </x-ui.card>
                </div>
            </x-ui.step>
        </x-ui.stepper>
    </form>
</x-app-layout>
