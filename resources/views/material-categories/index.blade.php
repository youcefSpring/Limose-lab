<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('messages.Material Categories') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('messages.Manage material categories and classifications') }}</p>
        </div>
        @can('create', App\Models\MaterialCategory::class)
            <button x-data @click="$dispatch('open-modal', 'create-category-modal')" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('messages.Add Category') }}
            </button>
        @endcan
    </header>

    <!-- Results Count -->
    @if(isset($categories) && $categories->total() > 0)
        <div class="glass-card rounded-xl px-4 py-3 mb-6">
            <span class="text-sm text-zinc-600 dark:text-zinc-300">
                Found <strong class="font-semibold text-zinc-900 dark:text-white">{{ $categories->total() }}</strong> categories
            </span>
        </div>
    @endif

    <!-- Categories Table -->
    @if($categories->count() > 0)
        <div class="glass-card rounded-2xl overflow-hidden mb-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-surface-800/50 border-b border-black/5 dark:border-white/5">
                        <tr>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('messages.Category') }}</th>
                            <th class="px-6 py-4 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">{{ __('messages.Description') }}</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">{{ __('messages.Materials Count') }}</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">{{ __('messages.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5">
                        @foreach($categories as $category)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-white/5 transition-colors">
                                <!-- Category Name -->
                                <td class="px-6 py-4">
                                    <p class="font-medium">{{ $category->name }}</p>
                                </td>

                                <!-- Description -->
                                <td class="px-6 py-4">
                                    @if($category->description)
                                        <p class="text-sm text-zinc-600 dark:text-zinc-300 line-clamp-2">{{ $category->description }}</p>
                                    @else
                                        <span class="text-zinc-400 text-sm">-</span>
                                    @endif
                                </td>

                                <!-- Materials Count -->
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent-cyan/10 text-accent-cyan font-mono">
                                        {{ $category->materials_count }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        @can('manage', App\Models\MaterialCategory::class)
                                            <button 
                                                x-data
                                                @click="$dispatch('open-modal', 'edit-category-modal-{{ $category->id }}')"
                                                class="p-2 rounded-lg hover:bg-accent-violet/10 text-accent-violet transition-colors"
                                                title="{{ __('messages.Edit') }}">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </button>
                                            <button 
                                                x-data
                                                @click="$dispatch('open-modal', 'delete-category-modal-{{ $category->id }}')"
                                                class="p-2 rounded-lg hover:bg-accent-rose/10 text-accent-rose transition-colors"
                                                title="{{ __('messages.Delete') }}">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-sm text-zinc-600 dark:text-zinc-400">
                Showing <span class="font-medium">{{ $categories->firstItem() }}</span>
                to <span class="font-medium">{{ $categories->lastItem() }}</span>
                of <span class="font-medium">{{ $categories->total() }}</span> categories
            </div>
            <div>
                {{ $categories->appends(request()->query())->links() }}
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent-cyan/10 mb-6">
                <svg class="w-10 h-10 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ __('messages.No categories found') }}</h3>
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 max-w-md mx-auto">
                {{ __('messages.Get started by creating your first material category.') }}
            </p>
            @can('create', App\Models\MaterialCategory::class)
                <button x-data @click="$dispatch('open-modal', 'create-category-modal')" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('messages.Add Category') }}
                </button>
            @endcan
        </div>
    @endif

    <!-- Create Category Modal -->
    @can('create', App\Models\MaterialCategory::class)
    <x-modal name="create-category-modal" :show="false" maxWidth="lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold">{{ __('messages.Add New Category') }}</h2>
                <button x-data @click="$dispatch('close-modal', 'create-category-modal')" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-surface-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('material-categories.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="create-name" class="block text-sm font-medium mb-2">
                        {{ __('messages.Category Name') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="text" name="name" id="create-name" value="{{ old('name') }}" required
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all @error('name') border-accent-rose @enderror"
                        placeholder="{{ __('messages.e.g., Microscopes, Lab Equipment, Chemicals') }}">
                    @error('name')
                        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="create-description" class="block text-sm font-medium mb-2">
                        {{ __('messages.Description') }}
                    </label>
                    <textarea name="description" id="create-description" rows="3"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none @error('description') border-accent-rose @enderror"
                        placeholder="{{ __('messages.Provide a brief description of this category...') }}">{{ old('description') }}</textarea>
                    <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Optional: Describe what type of materials belong to this category') }}</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <button type="button" x-data @click="$dispatch('close-modal', 'create-category-modal')" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                        {{ __('messages.Cancel') }}
                    </button>
                    <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('messages.Create Category') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>
    @endcan

    <!-- Edit Category Modals -->
    @can('manage', App\Models\MaterialCategory::class)
    @foreach($categories as $category)
    <x-modal name="edit-category-modal-{{ $category->id }}" :show="false" maxWidth="lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold">{{ __('messages.Edit Category') }}</h2>
                <button x-data @click="$dispatch('close-modal', 'edit-category-modal-{{ $category->id }}')" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-surface-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('material-categories.update', $category) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="edit-name-{{ $category->id }}" class="block text-sm font-medium mb-2">
                        {{ __('messages.Category Name') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="text" name="name" id="edit-name-{{ $category->id }}" value="{{ old('name', $category->name) }}" required
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                        placeholder="{{ __('messages.e.g., Microscopes, Lab Equipment, Chemicals') }}">
                </div>

                <div>
                    <label for="edit-description-{{ $category->id }}" class="block text-sm font-medium mb-2">
                        {{ __('messages.Description') }}
                    </label>
                    <textarea name="description" id="edit-description-{{ $category->id }}" rows="3"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all resize-none"
                        placeholder="{{ __('messages.Provide a brief description of this category...') }}">{{ old('description', $category->description) }}</textarea>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-2 gap-4 p-4 glass-card rounded-xl">
                    <div class="text-center">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Materials in this category') }}</p>
                        <p class="text-2xl font-bold mt-1">{{ $category->materials()->count() }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('messages.Available materials') }}</p>
                        <p class="text-2xl font-bold mt-1">{{ $category->materials()->where('status', 'available')->count() }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <button type="button" x-data @click="$dispatch('close-modal', 'edit-category-modal-{{ $category->id }}')" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                        {{ __('messages.Cancel') }}
                    </button>
                    <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ __('messages.Update Category') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Delete Category Modal -->
    <x-modal name="delete-category-modal-{{ $category->id }}" :show="false" maxWidth="md">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold">{{ __('messages.Delete Category') }}</h2>
                <button x-data @click="$dispatch('close-modal', 'delete-category-modal-{{ $category->id }}')" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-surface-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <p class="text-zinc-600 dark:text-zinc-300 mb-6">
                {{ __('messages.Are you sure you want to delete this category? Categories with materials cannot be deleted.') }}
            </p>

            <div class="flex items-center justify-end gap-3">
                <button type="button" x-data @click="$dispatch('close-modal', 'delete-category-modal-{{ $category->id }}')" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                    {{ __('messages.Cancel') }}
                </button>
                <form method="POST" action="{{ route('material-categories.destroy', $category) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex items-center gap-2 bg-accent-rose px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        {{ __('messages.Delete') }}
                    </button>
                </form>
            </div>
        </div>
    </x-modal>
    @endforeach
    @endcan
</x-app-layout>