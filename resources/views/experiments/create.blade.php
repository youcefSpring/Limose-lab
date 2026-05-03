<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('experiments.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('messages.Create New Experiment') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('messages.Record a new experiment') }}</p>
            </div>
        </div>
    </header>

    <div class="w-full">
        <form method="POST" action="{{ route('experiments.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="glass-card rounded-2xl p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-1">{{ __('messages.Experiment Information') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Fill in the experiment details') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Project Selection - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="project_id" class="block text-sm font-medium mb-2">
                            {{ __('messages.Project') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="project_id" id="project_id" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all @error('project_id') border-accent-rose @enderror">
                            <option value="">{{ __('messages.Select a project') }}</option>
                            @foreach($projects ?? [] as $project)
                                <option value="{{ $project->id }}" {{ old('project_id', request('project')) == $project->id ? 'selected' : '' }}>
                                    {{ $project->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="title" class="block text-sm font-medium mb-2">
                            {{ __('messages.Experiment Title') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}"
                            placeholder="{{ __('messages.Enter experiment title...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all @error('title') border-accent-rose @enderror">
                        @error('title')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Experiment Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium mb-2">
                            {{ __('messages.Experiment Date') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="date" name="date" id="date" required
                            value="{{ old('date', date('Y-m-d')) }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all @error('date') border-accent-rose @enderror">
                        @error('date')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">
                            {{ __('messages.Status') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all @error('status') border-accent-rose @enderror">
                            <option value="planned" {{ old('status', 'planned') == 'planned' ? 'selected' : '' }}>{{ __('messages.Planned') }}</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>{{ __('messages.In Progress') }}</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('messages.Completed') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium mb-2">
                            {{ __('messages.Duration') }} ({{ __('messages.hours') }})
                        </label>
                        <input type="number" name="duration" id="duration" step="0.5" min="0"
                            value="{{ old('duration') }}"
                            placeholder="2.5"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all font-mono @error('duration') border-accent-rose @enderror">
                        @error('duration')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="description" class="block text-sm font-medium mb-2">
                            {{ __('messages.Description') }} <span class="text-accent-rose">*</span>
                        </label>
                        <textarea name="description" id="description" rows="4" required
                            placeholder="{{ __('messages.Provide a detailed description of the experiment...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all resize-none @error('description') border-accent-rose @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hypothesis - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="hypothesis" class="block text-sm font-medium mb-2">
                            {{ __('messages.Hypothesis') }}
                        </label>
                        <textarea name="hypothesis" id="hypothesis" rows="3"
                            placeholder="{{ __('messages.State your hypothesis...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all resize-none @error('hypothesis') border-accent-rose @enderror">{{ old('hypothesis') }}</textarea>
                        @error('hypothesis')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Procedure - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="procedure" class="block text-sm font-medium mb-2">
                            {{ __('messages.Procedure') }}
                        </label>
                        <textarea name="procedure" id="procedure" rows="5"
                            placeholder="{{ __('messages.Describe the experimental procedure step by step...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all resize-none @error('procedure') border-accent-rose @enderror">{{ old('procedure') }}</textarea>
                        @error('procedure')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Upload - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <x-file-upload
                            name="file"
                            label="{{ __('messages.Experiment File') }}"
                            accept="image/*,.pdf,.doc,.docx,.odt,.txt"
                            maxSize="10MB"
                        />
                    </div>
                </div>
            </div>

            <!-- Important Information -->
            <div class="mt-6">
                <x-alert type="info" :dismissible="false">
                    <strong>{{ __('messages.Experiment Guidelines') }}:</strong>
                    <ul class="list-disc {{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }} mt-2 text-sm space-y-1">
                        <li>{{ __('messages.Provide detailed and accurate information') }}</li>
                        <li>{{ __('messages.You can add results and conclusions after completing the experiment') }}</li>
                        <li>{{ __('messages.Multiple files can be attached (max 10MB each)') }}</li>
                        <li>{{ __('messages.Team members will be notified of new experiments') }}</li>
                    </ul>
                </x-alert>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 mt-6">
                <x-ui.button variant="secondary" href="{{ route('experiments.index') }}" size="md">
                    {{ __('messages.Cancel') }}
                </x-ui.button>
                <x-ui.button variant="success" type="submit" size="md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('messages.Create Experiment') }}
                </x-ui.button>
            </div>
        </form>
    </div>
</x-app-layout>
