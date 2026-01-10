<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Materials & Equipment') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Browse and search available laboratory equipment') }}</p>
        </div>
        <div class="flex items-center gap-2">
            @can('create', App\Models\Material::class)
                <a href="{{ route('materials.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add Material') }}
                </a>
            @endcan
        </div>
    </header>

    <!-- Search and Filters -->
    <div class="glass-card rounded-2xl p-5 lg:p-6 mb-6">
        <form method="GET" action="{{ route('materials.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Search Input -->
                <div>
                    <label for="search" class="block text-sm font-medium mb-2">{{ __('Search') }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 {{ app()->getLocale() === 'ar' ? 'right-0 pr-3' : 'left-0 pl-3' }} flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            name="search"
                            id="search"
                            value="{{ request('search') }}"
                            placeholder="{{ __('Search by name or serial number...') }}"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'pr-10 text-right' : 'pl-10' }} py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                        >
                    </div>
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium mb-2">{{ __('Category') }}</label>
                    <select
                        name="category"
                        id="category"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                    >
                        <option value="">{{ __('All Categories') }}</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status" class="block text-sm font-medium mb-2">{{ __('Status') }}</label>
                    <select
                        name="status"
                        id="status"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                    >
                        <option value="">{{ __('All Status') }}</option>
                        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>{{ __('Available') }}</option>
                        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                        <option value="retired" {{ request('status') == 'retired' ? 'selected' : '' }}>{{ __('Retired') }}</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 pt-2">
                <div class="text-sm text-zinc-500 dark:text-zinc-400">
                    {{ __('Found') }} <span class="font-semibold text-zinc-800 dark:text-white">{{ $materials->total() ?? 0 }}</span> {{ __('materials') }}
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('materials.index') }}" class="px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                        {{ __('Clear') }}
                    </a>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-accent-violet/10 text-accent-violet hover:bg-accent-violet/20 text-sm font-medium transition-all">
                        {{ __('Apply Filters') }}
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Materials Grid -->
    @if(isset($materials) && $materials->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6 mb-6">
            @foreach($materials as $material)
                <div class="glass-card rounded-2xl overflow-hidden hover:scale-[1.02] transition-all duration-300">
                    <!-- Material Image -->
                    <div class="relative h-48 bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-surface-700 dark:to-surface-600">
                        @if($material->image)
                            <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full">
                                <svg class="h-20 w-20 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                        @endif
                        <!-- Status Badge -->
                        <div class="absolute top-3 {{ app()->getLocale() === 'ar' ? 'left-3' : 'right-3' }}">
                            @if($material->status === 'available')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-accent-emerald/10 text-accent-emerald backdrop-blur-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ __('Available') }}
                                </span>
                            @elseif($material->status === 'maintenance')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-accent-amber/10 text-accent-amber backdrop-blur-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ __('Maintenance') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-zinc-500/10 text-zinc-500 backdrop-blur-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                    {{ __('Retired') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Material Info -->
                    <div class="p-5 space-y-3">
                        <div>
                            <h3 class="text-lg font-semibold line-clamp-1">{{ $material->name }}</h3>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                                {{ $material->category->name ?? __('Uncategorized') }}
                            </p>
                        </div>

                        <p class="text-sm text-zinc-600 dark:text-zinc-300 line-clamp-2">
                            {{ $material->description }}
                        </p>

                        <div class="flex items-center justify-between pt-3 border-t border-black/5 dark:border-white/5">
                            <div class="text-sm">
                                <span class="text-zinc-500 dark:text-zinc-400">{{ __('Qty') }}:</span>
                                <span class="font-semibold font-mono {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ $material->quantity }}</span>
                            </div>
                            <div class="text-sm">
                                <span class="text-zinc-500 dark:text-zinc-400">{{ __('Location') }}:</span>
                                <span class="font-semibold {{ app()->getLocale() === 'ar' ? 'mr-1' : 'ml-1' }}">{{ $material->location }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 pt-3">
                            <a href="{{ route('materials.show', $material) }}" class="flex-1 text-center px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                                {{ __('View') }}
                            </a>
                            @if($material->status === 'available')
                                <a href="{{ route('reservations.create', ['material' => $material->id]) }}" class="px-4 py-2 rounded-xl bg-accent-violet/10 text-accent-violet hover:bg-accent-violet/20 text-sm font-medium transition-all">
                                    {{ __('Reserve') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $materials->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="glass-card rounded-2xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-accent-violet/10 mb-6">
                <svg class="w-10 h-10 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ __('No materials found') }}</h3>
            <p class="text-zinc-500 dark:text-zinc-400 mb-6 max-w-md mx-auto">
                {{ __('Try adjusting your search or filter to find what you are looking for.') }}
            </p>
            @can('create', App\Models\Material::class)
                <a href="{{ route('materials.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-accent-amber to-accent-coral px-6 py-3 rounded-xl font-medium text-white hover:opacity-90 transition-opacity">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('Add First Material') }}
                </a>
            @endcan
        </div>
    @endif
</x-app-layout>
