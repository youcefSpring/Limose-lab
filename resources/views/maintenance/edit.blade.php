<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
            <a href="{{ route('maintenance.show', $log) }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Maintenance Log') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <x-card>
            <form method="POST" action="{{ route('maintenance.update', $log) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Material Selection -->
                <div>
                    <label for="material_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Select Equipment') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="material_id" id="material_id" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('material_id') border-red-500 @enderror">
                        <option value="">{{ __('Select equipment') }}</option>
                        @foreach($materials ?? [] as $material)
                            <option value="{{ $material->id }}" {{ old('material_id', $log->material_id) == $material->id ? 'selected' : '' }}>
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
                    <label for="maintenance_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Maintenance Type') }} <span class="text-red-500">*</span>
                    </label>
                    <select name="maintenance_type" id="maintenance_type" required
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('maintenance_type') border-red-500 @enderror">
                        <option value="preventive" {{ old('maintenance_type', $log->maintenance_type) == 'preventive' ? 'selected' : '' }}>{{ __('Preventive') }}</option>
                        <option value="corrective" {{ old('maintenance_type', $log->maintenance_type) == 'corrective' ? 'selected' : '' }}>{{ __('Corrective') }}</option>
                        <option value="inspection" {{ old('maintenance_type', $log->maintenance_type) == 'inspection' ? 'selected' : '' }}>{{ __('Inspection') }}</option>
                        <option value="calibration" {{ old('maintenance_type', $log->maintenance_type) == 'calibration' ? 'selected' : '' }}>{{ __('Calibration') }}</option>
                    </select>
                    @error('maintenance_type')
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
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $log->description) }}</textarea>
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
                            value="{{ old('scheduled_date', $log->scheduled_date?->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('scheduled_date') border-red-500 @enderror">
                        @error('scheduled_date')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="completed_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Completed Date') }}
                        </label>
                        <input type="date" name="completed_date" id="completed_date"
                            value="{{ old('completed_date', $log->completed_date?->format('Y-m-d')) }}"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('completed_date') border-red-500 @enderror">
                        @error('completed_date')
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
                        <option value="scheduled" {{ old('status', $log->status) == 'scheduled' ? 'selected' : '' }}>{{ __('Scheduled') }}</option>
                        <option value="in_progress" {{ old('status', $log->status) == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                        <option value="completed" {{ old('status', $log->status) == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                        <option value="cancelled" {{ old('status', $log->status) == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
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
                                <option value="{{ $technician->id }}" {{ old('technician_id', $log->technician_id) == $technician->id ? 'selected' : '' }}>
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
                            value="{{ old('cost', $log->cost) }}"
                            placeholder="0.00"
                            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('cost') border-red-500 @enderror">
                        @error('cost')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Additional Notes') }}
                    </label>
                    <textarea name="notes" id="notes" rows="2"
                        placeholder="{{ __('Any additional information...') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes', $log->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-between space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }} pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                        @can('delete', $log)
                            <button type="button" onclick="if(confirm('{{ __('Are you sure you want to delete this maintenance log?') }}')) { document.getElementById('delete-form').submit(); }"
                                class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                {{ __('Delete Log') }}
                            </button>
                        @endcan
                    </div>
                    <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                        <a href="{{ route('maintenance.show', $log) }}">
                            <x-button variant="outline" type="button">{{ __('Cancel') }}</x-button>
                        </a>
                        <x-button variant="primary" type="submit">
                            {{ __('Update Log') }}
                        </x-button>
                    </div>
                </div>
            </form>

            @can('delete', $log)
                <form id="delete-form" action="{{ route('maintenance.destroy', $log) }}" method="POST" class="hidden">
                    @csrf
                    @method('DELETE')
                </form>
            @endcan
        </x-card>
    </div>
</x-app-layout>
