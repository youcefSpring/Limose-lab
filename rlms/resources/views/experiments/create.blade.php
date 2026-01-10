<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
            <a href="{{ route('experiments.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Create New Experiment') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-card>
            <form method="POST" action="{{ route('experiments.store') }}" enctype="multipart/form-data" class="space-y-6" x-data="experimentForm()">
                @csrf

                <!-- Project Selection -->
                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Project') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="project_id" id="project_id" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('project_id') border-red-500 @enderror">
                        <option value="">{{ __('Select a project') }}</option>
                        @foreach($projects ?? [] as $project)
                            <option value="{{ $project->id }}" {{ old('project_id', request('project')) == $project->id ? 'selected' : '' }}>
                                {{ $project->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('project_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Experiment Title') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}"
                        placeholder="{{ __('Enter experiment title...') }}"
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
                        placeholder="{{ __('Provide a detailed description of the experiment...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hypothesis -->
                <div>
                    <label for="hypothesis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Hypothesis') }}
                    </label>
                    <textarea name="hypothesis" id="hypothesis" rows="3"
                        placeholder="{{ __('State your hypothesis...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('hypothesis') border-red-500 @enderror">{{ old('hypothesis') }}</textarea>
                    @error('hypothesis')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Procedure -->
                <div>
                    <label for="procedure" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Procedure') }}
                    </label>
                    <textarea name="procedure" id="procedure" rows="5"
                        placeholder="{{ __('Describe the experimental procedure step by step...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('procedure') border-red-500 @enderror">{{ old('procedure') }}</textarea>
                    @error('procedure')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date and Duration -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Experiment Date') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="date" id="date" required
                            value="{{ old('date', date('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('date') border-red-500 @enderror">
                        @error('date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Duration') }} ({{ __('hours') }})
                        </label>
                        <input type="number" name="duration" id="duration" step="0.5" min="0"
                            value="{{ old('duration') }}"
                            placeholder="2.5"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('duration') border-red-500 @enderror">
                        @error('duration')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Status') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                        <option value="planned" {{ old('status', 'planned') == 'planned' ? 'selected' : '' }}>{{ __('Planned') }}</option>
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('Attach Files') }}
                    </label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:border-gray-400 dark:hover:border-gray-500 transition-colors">
                        <input type="file" name="files[]" id="files" multiple accept=".pdf,.doc,.docx,.xls,.xlsx,.png,.jpg,.jpeg,.txt"
                            @change="handleFiles($event)"
                            class="hidden">
                        <label for="files" class="cursor-pointer">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Click to upload or drag and drop') }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                {{ __('PDF, DOC, XLS, PNG, JPG up to 10MB each') }}
                            </p>
                        </label>
                    </div>

                    <!-- File List -->
                    <div x-show="files.length > 0" class="mt-3">
                        <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Selected Files') }}:</p>
                        <ul class="space-y-1">
                            <template x-for="(file, index) in files" :key="index">
                                <li class="text-sm text-gray-600 dark:text-gray-400 flex items-center space-x-2 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span x-text="file.name"></span>
                                    <span class="text-xs" x-text="'(' + (file.size / 1024).toFixed(2) + ' KB)'"></span>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>

                <!-- Important Information -->
                <x-alert type="info" :dismissible="false">
                    <strong>{{ __('Experiment Guidelines') }}:</strong>
                    <ul class="list-disc {{ app()->getLocale() === 'ar' ? 'mr-4' : 'ml-4' }} mt-2 text-sm space-y-1">
                        <li>{{ __('Provide detailed and accurate information') }}</li>
                        <li>{{ __('You can add results and conclusions after completing the experiment') }}</li>
                        <li>{{ __('Multiple files can be attached (max 10MB each)') }}</li>
                        <li>{{ __('Team members will be notified of new experiments') }}</li>
                    </ul>
                </x-alert>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('experiments.index') }}">
                        <x-button variant="outline" type="button">{{ __('Cancel') }}</x-button>
                    </a>
                    <x-button variant="primary" type="submit">
                        {{ __('Create Experiment') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>

    @push('scripts')
    <script>
        function experimentForm() {
            return {
                files: [],

                handleFiles(event) {
                    this.files = Array.from(event.target.files);
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
