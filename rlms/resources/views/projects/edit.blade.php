<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
            <a href="{{ route('projects.show', $project) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Project') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-card>
            <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Project Title') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $project->title) }}"
                        placeholder="{{ __('Enter project title...') }}"
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
                        placeholder="{{ __('Provide a detailed description of the research project...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $project->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Objectives -->
                <div>
                    <label for="objectives" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Research Objectives') }}
                    </label>
                    <textarea name="objectives" id="objectives" rows="3"
                        placeholder="{{ __('List the main objectives of this research project...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('objectives') border-red-500 @enderror">{{ old('objectives', $project->objectives) }}</textarea>
                    @error('objectives')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Methodology -->
                <div>
                    <label for="methodology" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Methodology') }}
                    </label>
                    <textarea name="methodology" id="methodology" rows="3"
                        placeholder="{{ __('Describe the research methodology and approach...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('methodology') border-red-500 @enderror">{{ old('methodology', $project->methodology) }}</textarea>
                    @error('methodology')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Start Date') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="start_date" id="start_date" required
                            value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Expected End Date') }}
                        </label>
                        <input type="date" name="end_date" id="end_date"
                            value="{{ old('end_date', $project->end_date?->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Project Status') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                        <option value="active" {{ old('status', $project->status) == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                        <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>{{ __('On Hold') }}</option>
                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Budget and Funding -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="budget" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Budget') }} ({{ __('USD') }})
                        </label>
                        <input type="number" name="budget" id="budget" step="0.01" min="0"
                            value="{{ old('budget', $project->budget) }}"
                            placeholder="0.00"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('budget') border-red-500 @enderror">
                        @error('budget')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="funding_source" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Funding Source') }}
                        </label>
                        <input type="text" name="funding_source" id="funding_source"
                            value="{{ old('funding_source', $project->funding_source) }}"
                            placeholder="{{ __('e.g., NSF, Private Grant, University...') }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('funding_source') border-red-500 @enderror">
                        @error('funding_source')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Principal Investigator -->
                <div>
                    <label for="principal_investigator_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Principal Investigator') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="principal_investigator_id" id="principal_investigator_id" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('principal_investigator_id') border-red-500 @enderror">
                        <option value="">{{ __('Select Principal Investigator') }}</option>
                        @foreach($researchers ?? [] as $researcher)
                            <option value="{{ $researcher->id }}" {{ old('principal_investigator_id', $project->principal_investigator_id) == $researcher->id ? 'selected' : '' }}>
                                {{ $researcher->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('principal_investigator_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Progress -->
                <div>
                    <label for="progress" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Progress') }} (%)
                    </label>
                    <div class="mt-1 flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                        <input type="number" name="progress" id="progress" min="0" max="100"
                            value="{{ old('progress', $project->progress) }}"
                            class="block w-24 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('progress') border-red-500 @enderror">
                        <div class="flex-1">
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                                <div id="progress-bar" class="bg-blue-600 h-4 rounded-full transition-all duration-300"
                                    style="width: {{ old('progress', $project->progress) ?? 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                    @error('progress')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Update project progress percentage (0-100)') }}
                    </p>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('projects.show', $project) }}">
                        <x-button variant="outline" type="button">{{ __('Cancel') }}</x-button>
                    </a>
                    <x-button variant="primary" type="submit">
                        {{ __('Update Project') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const progressInput = document.getElementById('progress');
            const progressBar = document.getElementById('progress-bar');

            if (progressInput && progressBar) {
                progressInput.addEventListener('input', function() {
                    const value = Math.min(Math.max(this.value, 0), 100);
                    progressBar.style.width = value + '%';
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
