<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
            <a href="{{ route('maintenance.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Log Maintenance Activity') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-card>
            <form method="POST" action="{{ route('maintenance.store') }}" class="space-y-6">
                @csrf

                <!-- Material Selection -->
                <div>
                    <label for="material_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Select Equipment') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="material_id" id="material_id" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('material_id') border-red-500 @enderror">
                        <option value="">{{ __('Select equipment') }}</option>
                        @foreach($materials ?? [] as $material)
                            <option value="{{ $material->id }}" {{ old('material_id', request('material')) == $material->id ? 'selected' : '' }}>
                                {{ $material->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('material_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Maintenance Type') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="type" id="type" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('type') border-red-500 @enderror">
                        <option value="routine" {{ old('type', 'routine') == 'routine' ? 'selected' : '' }}>{{ __('Routine') }}</option>
                        <option value="repair" {{ old('type') == 'repair' ? 'selected' : '' }}>{{ __('Repair') }}</option>
                        <option value="calibration" {{ old('type') == 'calibration' ? 'selected' : '' }}>{{ __('Calibration') }}</option>
                        <option value="inspection" {{ old('type') == 'inspection' ? 'selected' : '' }}>{{ __('Inspection') }}</option>
                        <option value="upgrade" {{ old('type') == 'upgrade' ? 'selected' : '' }}>{{ __('Upgrade') }}</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Description') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="3" required
                        placeholder="{{ __('Describe the maintenance activity...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Scheduled Date and Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="scheduled_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Scheduled Date') }} <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="scheduled_date" id="scheduled_date" required
                            value="{{ old('scheduled_date', date('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('scheduled_date') border-red-500 @enderror">
                        @error('scheduled_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Status') }} <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                            <option value="scheduled" {{ old('status', 'scheduled') == 'scheduled' ? 'selected' : '' }}>{{ __('Scheduled') }}</option>
                            <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Technician and Cost -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="technician_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Technician') }}
                        </label>
                        <select name="technician_id" id="technician_id"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('technician_id') border-red-500 @enderror">
                            <option value="">{{ __('Select technician') }}</option>
                            @foreach($technicians ?? [] as $technician)
                                <option value="{{ $technician->id }}" {{ old('technician_id', auth()->id()) == $technician->id ? 'selected' : '' }}>
                                    {{ $technician->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('technician_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Cost') }} ({{ __('USD') }})
                        </label>
                        <input type="number" name="cost" id="cost" step="0.01" min="0"
                            value="{{ old('cost') }}"
                            placeholder="0.00"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('cost') border-red-500 @enderror">
                        @error('cost')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Work Performed -->
                <div>
                    <label for="work_performed" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Work Performed') }}
                    </label>
                    <textarea name="work_performed" id="work_performed" rows="4"
                        placeholder="{{ __('Detail the work that was or will be performed...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('work_performed') border-red-500 @enderror">{{ old('work_performed') }}</textarea>
                    @error('work_performed')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Additional Notes') }}
                    </label>
                    <textarea name="notes" id="notes" rows="2"
                        placeholder="{{ __('Any additional information...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} pt-6 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('maintenance.index') }}">
                        <x-button variant="outline" type="button">{{ __('Cancel') }}</x-button>
                    </a>
                    <x-button variant="primary" type="submit">
                        {{ __('Save Log') }}
                    </x-button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
