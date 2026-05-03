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
                <h1 class="text-xl sm:text-2xl font-semibold">{{ __('messages.Edit Category') }}</h1>
                <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ $materialCategory->name }}</p>
            </div>
        </div>
    </header>

    <form method="POST" action="{{ route('material-categories.update', $materialCategory) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information Section -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-5">{{ __('messages.Basic Information') }}</h2>

                <!-- Category Name -->
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium mb-2">
                        {{ __('messages.Category Name') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $materialCategory->name) }}" required
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-cyan/50 focus:border-accent-cyan transition-all @error('name') border-accent-rose @enderror"
                        placeholder="{{ __('messages.e.g., Microscopes, Lab Equipment, Chemicals') }}">
                    @error('name')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium mb-2">
                        {{ __('messages.Description') }}
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-cyan/50 focus:border-accent-cyan transition-all resize-none @error('description') border-accent-rose @enderror"
                        placeholder="{{ __('messages.Provide a brief description of this category...') }}">{{ old('description', $materialCategory->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Optional: Describe what type of materials belong to this category') }}</p>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="glass-card rounded-2xl p-5 lg:p-6">
                <h2 class="text-lg font-semibold mb-4">{{ __('messages.Statistics') }}</h2>
                <div class="flex items-center gap-4">
                    <div class="flex-1 p-4 glass-card rounded-xl">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Materials in this category') }}</p>
                        <p class="text-2xl font-bold mt-1">{{ $materialCategory->materials()->count() }}</p>
                    </div>
                    <div class="flex-1 p-4 glass-card rounded-xl">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Available materials') }}</p>
                        <p class="text-2xl font-bold mt-1">{{ $materialCategory->materials()->where('status', 'available')->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('material-categories.index') }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('messages.Cancel') }}
                </a>
                <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-cyan to-accent-teal px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ __('messages.Update Category') }}
                </button>
            </div>
        </form>
</x-app-layout>
