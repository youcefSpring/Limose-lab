<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
            <a href="{{ route('experiments.show', $experiment) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Experiment') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-card>
            <form method="POST" action="{{ route('experiments.update', $experiment) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Project Selection -->
                <div>
                    <label for="project_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Project') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="project_id" id="project_id" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('project_id') border-red-500 @enderror">
                        <option value="">{{ __('Select a project') }}</option>
                        @foreach($projects ?? [] as $project)
                            <option value="{{ $project->id }}" {{ old('project_id', $experiment->project_id) == $project->id ? 'selected' : '' }}>
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
                    <input type="text" name="title" id="title" required value="{{ old('title', $experiment->title) }}"
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
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $experiment->description) }}</textarea>
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
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('hypothesis') border-red-500 @enderror">{{ old('hypothesis', $experiment->hypothesis) }}</textarea>
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
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('procedure') border-red-500 @enderror">{{ old('procedure', $experiment->procedure) }}</textarea>
                    @error('procedure')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Results -->
                <div>
                    <label for="results" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Results') }}
                    </label>
                    <textarea name="results" id="results" rows="5"
                        placeholder="{{ __('Document the experiment results...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('results') border-red-500 @enderror">{{ old('results', $experiment->results) }}</textarea>
                    @error('results')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Conclusions -->
                <div>
                    <label for="conclusions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Conclusions') }}
                    </label>
                    <textarea name="conclusions" id="conclusions" rows="4"
                        placeholder="{{ __('Summarize your conclusions and findings...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('conclusions') border-red-500 @enderror">{{ old('conclusions', $experiment->conclusions) }}</textarea>
                    @error('conclusions')
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
                            value="{{ old('date', $experiment->date?->format('Y-m-d')) }}"
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
                            value="{{ old('duration', $experiment->duration) }}"
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
                        <option value="planned" {{ old('status', $experiment->status) == 'planned' ? 'selected' : '' }}>{{ __('Planned') }}</option>
                        <option value="in_progress" {{ old('status', $experiment->status) == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                        <option value="completed" {{ old('status', $experiment->status) == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="cancelled" {{ old('status', $experiment->status) == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('experiments.show', $experiment) }}">
                        <x-button variant="outline" type="button">{{ __('Cancel') }}</x-button>
                    </a>
                    <x-button variant="primary" type="submit">
                        {{ __('Update Experiment') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
