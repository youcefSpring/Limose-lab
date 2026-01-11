<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('projects.show', $project) }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Edit Project') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Update project information') }}</p>
            </div>
        </div>
    </header>

    <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Form Card -->
        <div class="glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-lg font-semibold mb-6">{{ __('Project Information') }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <!-- Title - Full Width -->
                <div class="lg:col-span-3">
                    <label for="title" class="block text-sm font-medium mb-2">
                        {{ __('Project Title') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $project->title) }}"
                        placeholder="{{ __('Enter project title...') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('title') border-accent-rose @enderror">
                    @error('title')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description - Full Width -->
                <div class="lg:col-span-3">
                    <label for="description" class="block text-sm font-medium mb-2">
                        {{ __('Description') }} <span class="text-accent-rose">*</span>
                    </label>
                    <textarea name="description" id="description" rows="4" required
                        placeholder="{{ __('Provide a detailed description of the research project...') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('description') border-accent-rose @enderror">{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Objectives - Full Width -->
                <div class="lg:col-span-3">
                    <label for="objectives" class="block text-sm font-medium mb-2">
                        {{ __('Research Objectives') }}
                    </label>
                    <textarea name="objectives" id="objectives" rows="3"
                        placeholder="{{ __('List the main objectives of this research project...') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('objectives') border-accent-rose @enderror">{{ old('objectives', $project->objectives) }}</textarea>
                    @error('objectives')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Methodology - Full Width -->
                <div class="lg:col-span-3">
                    <label for="methodology" class="block text-sm font-medium mb-2">
                        {{ __('Methodology') }}
                    </label>
                    <textarea name="methodology" id="methodology" rows="3"
                        placeholder="{{ __('Describe the research methodology and approach...') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('methodology') border-accent-rose @enderror">{{ old('methodology', $project->methodology) }}</textarea>
                    @error('methodology')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Start Date -->
                <div>
                    <label for="start_date" class="block text-sm font-medium mb-2">
                        {{ __('Start Date') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="date" name="start_date" id="start_date" required
                        value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('start_date') border-accent-rose @enderror">
                    @error('start_date')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- End Date -->
                <div>
                    <label for="end_date" class="block text-sm font-medium mb-2">
                        {{ __('Expected End Date') }}
                    </label>
                    <input type="date" name="end_date" id="end_date"
                        value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('end_date') border-accent-rose @enderror">
                    @error('end_date')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                        {{ __('Leave blank if end date is not yet determined') }}
                    </p>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium mb-2">
                        {{ __('Project Status') }} <span class="text-accent-rose">*</span>
                    </label>
                    <select name="status" id="status" required
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('status') border-accent-rose @enderror">
                        <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>{{ __('On Hold') }}</option>
                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget -->
                <div>
                    <label for="budget" class="block text-sm font-medium mb-2">
                        {{ __('Budget') }} ({{ __('USD') }})
                    </label>
                    <input type="number" name="budget" id="budget" step="0.01" min="0"
                        value="{{ old('budget', $project->budget) }}"
                        placeholder="0.00"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all font-mono @error('budget') border-accent-rose @enderror">
                    @error('budget')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Funding Source -->
                <div>
                    <label for="funding_source" class="block text-sm font-medium mb-2">
                        {{ __('Funding Source') }}
                    </label>
                    <input type="text" name="funding_source" id="funding_source"
                        value="{{ old('funding_source', $project->funding_source) }}"
                        placeholder="{{ __('e.g., NSF, Private Grant, University...') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('funding_source') border-accent-rose @enderror">
                    @error('funding_source')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Progress -->
                <div>
                    <label for="progress" class="block text-sm font-medium mb-2">
                        {{ __('Progress') }} (%)
                    </label>
                    <input type="number" name="progress" id="progress" min="0" max="100"
                        value="{{ old('progress', $project->progress) }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all font-mono @error('progress') border-accent-rose @enderror">
                    @error('progress')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-zinc-500 dark:text-zinc-400">
                        {{ __('Update project progress percentage (0-100)') }}
                    </p>
                </div>

                <!-- Principal Investigator - Full Width -->
                <div class="lg:col-span-3">
                    <label for="principal_investigator_id" class="block text-sm font-medium mb-2">
                        {{ __('Principal Investigator') }} <span class="text-accent-rose">*</span>
                    </label>
                    <select name="principal_investigator_id" id="principal_investigator_id" required
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('principal_investigator_id') border-accent-rose @enderror">
                        <option value="">{{ __('Select Principal Investigator') }}</option>
                        @foreach($researchers ?? [] as $researcher)
                            <option value="{{ $researcher->id }}" {{ old('principal_investigator_id', $project->principal_investigator_id) == $researcher->id ? 'selected' : '' }}>
                                {{ $researcher->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('principal_investigator_id')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('projects.show', $project) }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                {{ __('Cancel') }}
            </a>
            <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ __('Update Project') }}
            </button>
        </div>
    </form>
</x-app-layout>
