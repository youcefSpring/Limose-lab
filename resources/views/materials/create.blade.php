<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('materials.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Add New Material') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Add equipment to the laboratory inventory') }}</p>
            </div>
        </div>
    </header>

    <div class="max-w-4xl">
        <form method="POST" action="{{ route('materials.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Basic Information') }}</h2>

                <!-- Material Name -->
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium mb-2">
                        {{ __('Material Name') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('name') border-accent-rose @enderror"
                        placeholder="{{ __('e.g., Microscope Model X200') }}">
                    @error('name')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium mb-2">
                        {{ __('Description') }} <span class="text-accent-rose">*</span>
                    </label>
                    <textarea name="description" id="description" rows="4" required
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('description') border-accent-rose @enderror"
                        placeholder="{{ __('Provide a detailed description of the material...') }}">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Provide a detailed description of the material') }}</p>
                </div>
            </div>

            <!-- Classification Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Classification') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium mb-2">
                            {{ __('Category') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="category_id" id="category_id" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('category_id') border-accent-rose @enderror">
                            <option value="">{{ __('Select a category') }}</option>
                            @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium mb-2">
                            {{ __('Status') }} <span class="text-accent-rose">*</span>
                        </label>
                        <select name="status" id="status" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('status') border-accent-rose @enderror">
                            <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>{{ __('Available') }}</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                            <option value="retired" {{ old('status') == 'retired' ? 'selected' : '' }}>{{ __('Retired') }}</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Inventory Details Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Inventory Details') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium mb-2">
                            {{ __('Quantity') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" min="1" max="9999" required
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all font-mono @error('quantity') border-accent-rose @enderror">
                        @error('quantity')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium mb-2">
                            {{ __('Location') }} <span class="text-accent-rose">*</span>
                        </label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}" required
                            placeholder="{{ __('e.g., Lab A - Shelf 3') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('location') border-accent-rose @enderror">
                        @error('location')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Additional Information') }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <!-- Serial Number -->
                    <div>
                        <label for="serial_number" class="block text-sm font-medium mb-2">
                            {{ __('Serial Number') }}
                        </label>
                        <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}"
                            placeholder="{{ __('e.g., SN-2024-001') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all font-mono @error('serial_number') border-accent-rose @enderror">
                        @error('serial_number')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Purchase Date -->
                    <div>
                        <label for="purchase_date" class="block text-sm font-medium mb-2">
                            {{ __('Purchase Date') }}
                        </label>
                        <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date') }}" max="{{ date('Y-m-d') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('purchase_date') border-accent-rose @enderror">
                        @error('purchase_date')
                            <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Maintenance Schedule -->
                <div>
                    <label for="maintenance_schedule" class="block text-sm font-medium mb-2">
                        {{ __('Maintenance Schedule') }}
                    </label>
                    <select name="maintenance_schedule" id="maintenance_schedule"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('maintenance_schedule') border-accent-rose @enderror">
                        <option value="">{{ __('No scheduled maintenance') }}</option>
                        <option value="weekly" {{ old('maintenance_schedule') == 'weekly' ? 'selected' : '' }}>{{ __('Weekly') }}</option>
                        <option value="monthly" {{ old('maintenance_schedule') == 'monthly' ? 'selected' : '' }}>{{ __('Monthly') }}</option>
                        <option value="quarterly" {{ old('maintenance_schedule') == 'quarterly' ? 'selected' : '' }}>{{ __('Quarterly') }}</option>
                        <option value="yearly" {{ old('maintenance_schedule') == 'yearly' ? 'selected' : '' }}>{{ __('Yearly') }}</option>
                    </select>
                    @error('maintenance_schedule')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image Upload Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Material Image') }}</h2>

                <div class="flex justify-center px-6 pt-8 pb-8 border-2 border-dashed border-black/10 dark:border-white/10 rounded-xl hover:border-accent-violet/50 dark:hover:border-accent-violet/50 transition-colors bg-white dark:bg-surface-700/30">
                    <div class="space-y-3 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-accent-violet/10 mb-2">
                            <svg class="w-8 h-8 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="flex text-sm justify-center">
                            <label for="image" class="relative cursor-pointer rounded-md font-medium text-accent-violet hover:text-accent-rose transition-colors px-2">
                                <span>{{ __('Upload a file') }}</span>
                                <input id="image" name="image" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                            </label>
                            <p class="text-zinc-500 dark:text-zinc-400">{{ __('or drag and drop') }}</p>
                        </div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('PNG, JPG up to 2MB') }}</p>
                    </div>
                </div>
                @error('image')
                    <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('materials.index') }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('Create Material') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
