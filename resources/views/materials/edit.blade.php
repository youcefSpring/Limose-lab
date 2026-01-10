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

    <div class="max-w-4xl">
        <form method="POST" action="{{ route('materials.update', $material) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Basic Information') }}</h2>

                <!-- Material Name -->
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium mb-2">
                        {{ __('Material Name') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $material->name) }}" required
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
                        placeholder="{{ __('Provide a detailed description of the material...') }}">{{ old('description', $material->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
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
                                <option value="{{ $category->id }}" {{ old('category_id', $material->category_id) == $category->id ? 'selected' : '' }}>
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
                            <option value="available" {{ old('status', $material->status) == 'available' ? 'selected' : '' }}>{{ __('Available') }}</option>
                            <option value="maintenance" {{ old('status', $material->status) == 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                            <option value="retired" {{ old('status', $material->status) == 'retired' ? 'selected' : '' }}>{{ __('Retired') }}</option>
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
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $material->quantity) }}" min="1" max="9999" required
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
                        <input type="text" name="location" id="location" value="{{ old('location', $material->location) }}" required
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
                        <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $material->serial_number) }}"
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
                        <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $material->purchase_date?->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}"
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
                        <option value="weekly" {{ old('maintenance_schedule', $material->maintenance_schedule) == 'weekly' ? 'selected' : '' }}>{{ __('Weekly') }}</option>
                        <option value="monthly" {{ old('maintenance_schedule', $material->maintenance_schedule) == 'monthly' ? 'selected' : '' }}>{{ __('Monthly') }}</option>
                        <option value="quarterly" {{ old('maintenance_schedule', $material->maintenance_schedule) == 'quarterly' ? 'selected' : '' }}>{{ __('Quarterly') }}</option>
                        <option value="yearly" {{ old('maintenance_schedule', $material->maintenance_schedule) == 'yearly' ? 'selected' : '' }}>{{ __('Yearly') }}</option>
                    </select>
                    @error('maintenance_schedule')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Image Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Material Image') }}</h2>

                <!-- Current Image -->
                @if($material->image)
                    <div class="mb-5">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-3">{{ __('Current Image') }}</p>
                        <div class="inline-block glass-card rounded-xl p-3">
                            <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->name }}"
                                class="h-32 w-32 object-cover rounded-lg">
                        </div>
                    </div>
                @endif

                <!-- Upload New Image -->
                <div>
                    <label for="image" class="block text-sm font-medium mb-3">
                        {{ $material->image ? __('Update Image (Optional)') : __('Upload Image') }}
                    </label>
                    <div class="flex items-center gap-3">
                        <label for="image" class="flex-1 cursor-pointer">
                            <div class="flex items-center gap-3 px-4 py-3 glass-card rounded-xl hover:scale-[1.01] transition-all">
                                <div class="w-10 h-10 rounded-lg bg-accent-violet/10 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">{{ __('Choose a file') }}</p>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('PNG, JPG up to 2MB') }}</p>
                                </div>
                                <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                            </div>
                            <input id="image" name="image" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                        </label>
                    </div>
                    @error('image')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
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
