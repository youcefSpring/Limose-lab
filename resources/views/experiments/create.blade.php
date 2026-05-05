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
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('experiments.create_new_experiment') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('experiments.record_new_experiment') }}</p>
            </div>
        </div>
    </header>

    <div class="w-full">
        <form method="POST" action="{{ route('experiments.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="glass-card rounded-2xl p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-1">{{ __('experiments.experiment_information') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('experiments.fill_experiment_details') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Project Selection - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="project_id" class="block text-sm font-medium mb-2">
                            {{ __('experiments.project') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="project_id" id="project_id" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all @error('project_id') border-accent-rose @enderror">
                            <option value="">{{ __('experiments.select_project') }}</option>
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
                            {{ __('experiments.experiment_title') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}"
                            placeholder="{{ __('experiments.enter_experiment_title') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all @error('title') border-accent-rose @enderror">
                        @error('title')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Experiment Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium mb-2">
                            {{ __('experiments.experiment_date') }} <span class="text-accent-rose">*</span>
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
                            {{ __('experiments.status') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all @error('status') border-accent-rose @enderror">
<option value="planned" {{ old('status', 'planned') == 'planned' ? 'selected' : '' }}>{{ __('experiments.planned') }}</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>{{ __('experiments.in_progress') }}</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('experiments.completed') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration" class="block text-sm font-medium mb-2">
                            {{ __('experiments.duration') }} ({{ __('experiments.hours') }})
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
                            {{ __('experiments.description') }} <span class="text-accent-rose">*</span>
                        </label>
                        <textarea name="description" id="description" rows="4" required
                            placeholder="{{ __('experiments.provide_detailed_description') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all resize-none @error('description') border-accent-rose @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hypothesis - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="hypothesis" class="block text-sm font-medium mb-2">
                            {{ __('experiments.hypothesis') }}
                        </label>
                        <textarea name="hypothesis" id="hypothesis" rows="3"
                            placeholder="{{ __('experiments.state_your_hypothesis') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all resize-none @error('hypothesis') border-accent-rose @enderror">{{ old('hypothesis') }}</textarea>
                        @error('hypothesis')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Procedure - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="procedure" class="block text-sm font-medium mb-2">
                            {{ __('experiments.procedure') }}
                        </label>
                        <textarea name="procedure" id="procedure" rows="5"
                            placeholder="{{ __('experiments.describe_procedure') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-purple/50 focus:border-accent-purple transition-all resize-none @error('procedure') border-accent-rose @enderror">{{ old('procedure') }}</textarea>
                        @error('procedure')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Upload - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <x-file-upload
                            name="file"
                            label="{{ __('experiments.experiment_file') }}"
                            accept="image/*,.pdf,.doc,.docx,.odt,.txt"
                            maxSize="10MB"
                        />
                    </div>
                </div>
            </div>

            <!-- Important Information -->
            <div class="mt-6">
                <x-alert type="info" :dismissible="false">
                    <strong>{{ __('experiments.experiment_guidelines') }}:</strong>
                    <ul class="list-disc {{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }} mt-2 text-sm space-y-1">
                        <li>{{ __('experiments.provide_detailed_information') }}</li>
                        <li>{{ __('experiments.add_results_after') }}</li>
                        <li>{{ __('experiments.multiple_files') }}</li>
                        <li>{{ __('experiments.team_notified') }}</li>
                    </ul>
                </x-alert>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 mt-6">
                <x-ui.button variant="secondary" href="{{ route('experiments.index') }}" size="md">
                    {{ __('experiments.cancel') }}
                </x-ui.button>
                <x-ui.button variant="success" type="submit" size="md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('experiments.create_experiment') }}
                </x-ui.button>
            </div>
        </form>
    </div>
</x-app-layout>
