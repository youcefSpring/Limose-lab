<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div class="flex items-center gap-3">
            <a href="{{ route('material-categories.index') }}" class="p-2 rounded-xl glass hover:glass-card transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                </svg>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Add New Category') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Create a new material category') }}</p>
            </div>
        </div>
    </header>

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('material-categories.store') }}" class="space-y-6">
            @csrf

            <!-- Basic Information Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('Basic Information') }}</h2>

                <!-- Category Name -->
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium mb-2">
                        {{ __('Category Name') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-cyan/50 focus:border-accent-cyan transition-all @error('name') border-accent-rose @enderror"
                        placeholder="{{ __('e.g., Microscopes, Lab Equipment, Chemicals') }}">
                    @error('name')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium mb-2">
                        {{ __('Description') }}
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-cyan/50 focus:border-accent-cyan transition-all resize-none @error('description') border-accent-rose @enderror"
                        placeholder="{{ __('Provide a brief description of this category...') }}">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Optional: Describe what type of materials belong to this category') }}</p>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('material-categories.index') }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-cyan to-accent-teal px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('Create Category') }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
