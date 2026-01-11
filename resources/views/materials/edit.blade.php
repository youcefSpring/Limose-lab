<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('materials.show', $material) }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Edit Material') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ $material->name }}</p>
            </div>
        </div>
    </header>

    <div class="w-full">
        <form method="POST" action="{{ route('materials.update', $material) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="glass-card rounded-2xl p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-1">{{ __('Material Information') }}</h2>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('Update the material details') }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <!-- Material Name - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="name" class="block text-sm font-medium mb-2">
                            {{ __('Material Name') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $material->name) }}" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('name') border-accent-rose @enderror"
                            placeholder="{{ __('e.g., Microscope Model X200') }}">
                        @error('name')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium mb-2">
                            {{ __('Category') }}
                        </label>
                        <select name="category_id" id="category_id"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('category_id') border-accent-rose @enderror">
                            <option value="">{{ __('Select category') }}</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $material->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">
                            {{ __('Status') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('status') border-accent-rose @enderror">
                            <option value="available" {{ old('status', $material->status) == 'available' ? 'selected' : '' }}>{{ __('Available') }}</option>
                            <option value="maintenance" {{ old('status', $material->status) == 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                            <option value="retired" {{ old('status', $material->status) == 'retired' ? 'selected' : '' }}>{{ __('Retired') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium mb-2">
                            {{ __('Quantity') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $material->quantity) }}" min="0" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all font-mono @error('quantity') border-accent-rose @enderror">
                        @error('quantity')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Min Quantity -->
                    <div>
                        <label for="min_quantity" class="block text-sm font-medium mb-2">
                            {{ __('Min. Quantity') }}
                        </label>
                        <input type="number" name="min_quantity" id="min_quantity" value="{{ old('min_quantity', $material->min_quantity) }}" min="0"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all font-mono @error('min_quantity') border-accent-rose @enderror">
                        @error('min_quantity')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location - Span 2 columns -->
                    <div class="md:col-span-2">
                        <label for="location" class="block text-sm font-medium mb-2">
                            {{ __('Location') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="text" name="location" id="location" value="{{ old('location', $material->location) }}" required
                            placeholder="{{ __('e.g., Lab A - Shelf 3') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('location') border-accent-rose @enderror">
                        @error('location')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Serial Number -->
                    <div>
                        <label for="serial_number" class="block text-sm font-medium mb-2">
                            {{ __('Serial Number') }}
                        </label>
                        <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $material->serial_number) }}"
                            placeholder="{{ __('e.g., SN-2024-001') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all font-mono @error('serial_number') border-accent-rose @enderror">
                        @error('serial_number')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Purchase Date -->
                    <div>
                        <label for="purchase_date" class="block text-sm font-medium mb-2">
                            {{ __('Purchase Date') }}
                        </label>
                        <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $material->purchase_date?->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('purchase_date') border-accent-rose @enderror">
                        @error('purchase_date')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Maintenance Schedule -->
                    <div>
                        <label for="maintenance_schedule" class="block text-sm font-medium mb-2">
                            {{ __('Maintenance Schedule') }}
                        </label>
                        <select name="maintenance_schedule" id="maintenance_schedule"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('maintenance_schedule') border-accent-rose @enderror">
                            <option value="">{{ __('No scheduled maintenance') }}</option>
                            <option value="weekly" {{ old('maintenance_schedule', $material->maintenance_schedule) == 'weekly' ? 'selected' : '' }}>{{ __('Weekly') }}</option>
                            <option value="monthly" {{ old('maintenance_schedule', $material->maintenance_schedule) == 'monthly' ? 'selected' : '' }}>{{ __('Monthly') }}</option>
                            <option value="quarterly" {{ old('maintenance_schedule', $material->maintenance_schedule) == 'quarterly' ? 'selected' : '' }}>{{ __('Quarterly') }}</option>
                            <option value="yearly" {{ old('maintenance_schedule', $material->maintenance_schedule) == 'yearly' ? 'selected' : '' }}>{{ __('Yearly') }}</option>
                        </select>
                        @error('maintenance_schedule')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description - Full Width -->
                    <div class="md:col-span-2 lg:col-span-3">
                        <label for="description" class="block text-sm font-medium mb-2">
                            {{ __('Description') }}
                        </label>
                        <textarea name="description" id="description" rows="3"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('description') border-accent-rose @enderror"
                            placeholder="{{ __('Brief description...') }}">{{ old('description', $material->description) }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Image Upload - Full Width -->
                    <div class="lg:col-span-3">
                        <x-file-upload
                            name="image"
                            label="{{ __('Material Image') }}"
                            accept="image/*,.pdf"
                            maxSize="10MB"
                            :currentFile="isset($material) && $material->image ? asset('storage/' . $material->image) : null"
                        />
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 mt-6">
                <a href="{{ route('materials.show', $material) }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('Update Material') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
