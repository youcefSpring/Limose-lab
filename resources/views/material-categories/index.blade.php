<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Material Categories') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Manage material categories and classifications') }}</p>
        </div>
        <div class="flex items-center gap-2">
            @can('create', App\Models\MaterialCategory::class)
                <a href="{{ route('material-categories.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-cyan to-accent-teal px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add Category') }}
                </a>
            @endcan
        </div>
    </header>

    <!-- Categories List -->
    @if($categories->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
            @foreach($categories as $category)
                <div class="glass-card rounded-2xl p-5 lg:p-6 hover:scale-[1.02] transition-all duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold mb-2">{{ $category->name }}</h3>
                            @if($category->description)
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 line-clamp-2">{{ $category->description }}</p>
                            @endif
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-accent-cyan/10 text-accent-cyan">
                            {{ $category->materials_count }} {{ __('items') }}
                        </span>
                    </div>

                    <div class="flex items-center gap-2 pt-4 border-t border-black/10 dark:border-white/10">
                        @can('update', $category)
                            <a href="{{ route('material-categories.edit', $category) }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                {{ __('Edit') }}
                            </a>
                        @endcan
                        @can('delete', $category)
                            <x-delete-confirmation-modal
                                :action="route('material-categories.destroy', $category)"
                                :title="__('Delete Category')"
                                :message="__('Are you sure you want to delete this category? This action cannot be undone.')">
                                <x-slot name="trigger">{{ __('Delete') }}</x-slot>
                            </x-delete-confirmation-modal>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
            </svg>
            <h3 class="mt-4 text-lg font-medium">{{ __('No categories found') }}</h3>
            <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400">{{ __('Get started by creating your first material category.') }}</p>
            @can('create', App\Models\MaterialCategory::class)
                <div class="mt-6">
                    <a href="{{ route('material-categories.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-cyan to-accent-teal px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('Add Category') }}
                    </a>
                </div>
            @endcan
        </div>
    @endif
</x-app-layout>
