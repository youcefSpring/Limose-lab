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

    <div class="w-full">
        <x-card>
            <form method="POST" action="{{ route('experiments.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Primary Information Grid (3 columns) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
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

                    <!-- Experiment Date -->
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
                </div>

                <!-- Title (Full Width) -->
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

                <!-- Secondary Information Grid (3 columns) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Description (2 columns) -->
                    <div class="md:col-span-2">
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

                    <!-- Duration -->
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

                <!-- Hypothesis and Procedure Grid (3 columns) -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Hypothesis (2 columns) -->
                    <div class="md:col-span-2">
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

                    <!-- File Upload -->
                    <div>
                        <x-file-upload
                            name="file"
                            label="{{ __('Experiment File') }}"
                            accept="image/*,.pdf,.doc,.docx,.odt,.txt"
                            maxSize="10MB"
                        />
                    </div>
                </div>

                <!-- Procedure (Full Width) -->
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
</x-app-layout>
