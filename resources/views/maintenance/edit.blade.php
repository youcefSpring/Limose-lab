<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('maintenance.show', $log) }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Edit Maintenance Log') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Update the maintenance log details') }}</p>
            </div>
        </div>
    </header>

    <div class="w-full">
        <form method="POST" action="{{ route('maintenance.update', $log) }}">
            @csrf
            @method('PUT')

            <div class="glass-card rounded-2xl p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-1">{{ __('Maintenance Information') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Update the maintenance details') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Material Selection - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="material_id" class="block text-sm font-medium mb-2">
                            {{ __('Select Equipment') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="material_id" id="material_id" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-coral/50 focus:border-accent-coral transition-all @error('material_id') border-accent-rose @enderror">
                            <option value="">{{ __('Select equipment') }}</option>
                            @foreach($materials ?? [] as $material)
                                <option value="{{ $material->id }}" {{ old('material_id', $log->material_id) == $material->id ? 'selected' : '' }}>
                                    {{ $material->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('material_id')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Maintenance Type -->
                    <div>
                        <label for="maintenance_type" class="block text-sm font-medium mb-2">
                            {{ __('Maintenance Type') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="maintenance_type" id="maintenance_type" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-coral/50 focus:border-accent-coral transition-all @error('maintenance_type') border-accent-rose @enderror">
                            <option value="preventive" {{ old('maintenance_type', $log->maintenance_type) == 'preventive' ? 'selected' : '' }}>{{ __('Preventive') }}</option>
                            <option value="corrective" {{ old('maintenance_type', $log->maintenance_type) == 'corrective' ? 'selected' : '' }}>{{ __('Corrective') }}</option>
                            <option value="inspection" {{ old('maintenance_type', $log->maintenance_type) == 'inspection' ? 'selected' : '' }}>{{ __('Inspection') }}</option>
                            <option value="calibration" {{ old('maintenance_type', $log->maintenance_type) == 'calibration' ? 'selected' : '' }}>{{ __('Calibration') }}</option>
                        </select>
                        @error('maintenance_type')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Scheduled Date -->
                    <div>
                        <label for="scheduled_date" class="block text-sm font-medium mb-2">
                            {{ __('Scheduled Date') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="date" name="scheduled_date" id="scheduled_date" required
                            value="{{ old('scheduled_date', $log->scheduled_date?->format('Y-m-d')) }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-coral/50 focus:border-accent-coral transition-all @error('scheduled_date') border-accent-rose @enderror">
                        @error('scheduled_date')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Completed Date -->
                    <div>
                        <label for="completed_date" class="block text-sm font-medium mb-2">
                            {{ __('Completed Date') }}
                        </label>
                        <input type="date" name="completed_date" id="completed_date"
                            value="{{ old('completed_date', $log->completed_date?->format('Y-m-d')) }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-coral/50 focus:border-accent-coral transition-all @error('completed_date') border-accent-rose @enderror">
                        @error('completed_date')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">
                            {{ __('Status') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-coral/50 focus:border-accent-coral transition-all @error('status') border-accent-rose @enderror">
                            <option value="scheduled" {{ old('status', $log->status) == 'scheduled' ? 'selected' : '' }}>{{ __('Scheduled') }}</option>
                            <option value="in_progress" {{ old('status', $log->status) == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                            <option value="completed" {{ old('status', $log->status) == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                            <option value="cancelled" {{ old('status', $log->status) == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Technician -->
                    <div>
                        <label for="technician_id" class="block text-sm font-medium mb-2">
                            {{ __('Technician') }}
                        </label>
                        <select name="technician_id" id="technician_id"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-coral/50 focus:border-accent-coral transition-all @error('technician_id') border-accent-rose @enderror">
                            <option value="">{{ __('Select technician') }}</option>
                            @foreach($technicians ?? [] as $technician)
                                <option value="{{ $technician->id }}" {{ old('technician_id', $log->technician_id) == $technician->id ? 'selected' : '' }}>
                                    {{ $technician->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('technician_id')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cost -->
                    <div>
                        <label for="cost" class="block text-sm font-medium mb-2">
                            {{ __('Cost') }} ({{ __('USD') }})
                        </label>
                        <input type="number" name="cost" id="cost" step="0.01" min="0"
                            value="{{ old('cost', $log->cost) }}"
                            placeholder="0.00"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-coral/50 focus:border-accent-coral transition-all font-mono @error('cost') border-accent-rose @enderror">
                        @error('cost')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="description" class="block text-sm font-medium mb-2">
                            {{ __('Description') }} <span class="text-accent-rose">*</span>
                        </label>
                        <textarea name="description" id="description" rows="3" required
                            placeholder="{{ __('Describe the maintenance activity...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-coral/50 focus:border-accent-coral transition-all resize-none @error('description') border-accent-rose @enderror">{{ old('description', $log->description) }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="notes" class="block text-sm font-medium mb-2">
                            {{ __('Additional Notes') }}
                        </label>
                        <textarea name="notes" id="notes" rows="2"
                            placeholder="{{ __('Any additional information...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-coral/50 focus:border-accent-coral transition-all resize-none @error('notes') border-accent-rose @enderror">{{ old('notes', $log->notes) }}</textarea>
                        @error('notes')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between gap-3 mt-6">
                <div>
                    @can('delete', $log)
                        <button type="button" onclick="if(confirm('{{ __('Are you sure you want to delete this maintenance log?') }}')) { document.getElementById('delete-form').submit(); }"
                            class="px-5 py-2.5 rounded-xl text-accent-rose hover:bg-accent-rose/10 text-sm font-medium transition-all">
                            {{ __('Delete Log') }}
                        </button>
                    @endcan
                </div>
                <div class="flex items-center gap-3">
                    <x-ui.button variant="secondary" href="{{ route('maintenance.show', $log) }}" size="md">
                        {{ __('Cancel') }}
                    </x-ui.button>
                    <x-ui.button variant="success" type="submit" size="md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('Update Log') }}
                    </x-ui.button>
                </div>
            </div>
        </form>

        @can('delete', $log)
            <form id="delete-form" action="{{ route('maintenance.destroy', $log) }}" method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endcan
    </div>
</x-app-layout>
