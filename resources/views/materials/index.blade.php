<x-app-layout>
    <!-- Header -->
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Materials & Equipment') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Browse and search available laboratory equipment') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <!-- Filter Button -->
            <button @click="$dispatch('open-modal', 'filter-modal')" class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <span class="hidden sm:inline">{{ __('Filter') }}</span>
                @if(request()->has('search') || request()->has('status') || request()->has('category'))
                    <span class="w-2 h-2 rounded-full bg-accent-amber"></span>
                @endif
            </button>

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

    <!-- Filter Modal -->
    <x-modal name="filter-modal" :show="false" maxWidth="lg">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold">{{ __('Filter Materials') }}</h2>
                <button @click="$dispatch('close-modal', 'filter-modal')" class="p-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-surface-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <form method="GET" action="{{ route('materials.index') }}" class="space-y-4">
                <!-- Search Input -->
                <div>
                    <label for="modal-search" class="block text-sm font-medium mb-2">{{ __('Search') }}</label>
                    <input
                        type="text"
                        name="search"
                        id="modal-search"
                        value="{{ request('search') }}"
                        placeholder="{{ __('Search by name or serial number...') }}"
                        class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                    >
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Category Filter -->
                    <div>
                        <label for="modal-category" class="block text-sm font-medium mb-2">{{ __('Category') }}</label>
                        <select
                            name="category"
                            id="modal-category"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
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
                        <label for="modal-status" class="block text-sm font-medium mb-2">{{ __('Status') }}</label>
                        <select
                            name="status"
                            id="modal-status"
                            class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-2.5 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-amber/50 focus:border-accent-amber transition-all"
                        >
                            <option value="">{{ __('All Status') }}</option>
                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>{{ __('Available') }}</option>
                            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                            <option value="retired" {{ request('status') == 'retired' ? 'selected' : '' }}>{{ __('Retired') }}</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 pt-4 border-t border-black/5 dark:border-white/5">
                    <a href="{{ route('materials.index') }}" class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                        {{ __('Clear Filters') }}
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-accent-amber to-accent-coral text-white text-sm font-medium hover:opacity-90 transition-opacity">
                        {{ __('Apply Filters') }}
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Results Count -->
    @if(isset($materials))
        <div class="glass-card rounded-xl px-4 py-3 mb-6">
            <div class="flex items-center justify-between text-sm">
                <span class="text-zinc-500 dark:text-zinc-400">
                    {{ __('Found') }} <span class="font-semibold text-zinc-800 dark:text-white">{{ $materials->total() }}</span> {{ __('materials') }}
                </span>
                @if(request()->has('search') || request()->has('status') || request()->has('category'))
                    <a href="{{ route('materials.index') }}" class="text-accent-rose hover:underline">
                        {{ __('Clear all filters') }}
                    </a>
                @endif
            </div>
        </div>
    @endif

    <!-- Materials Table -->
    @if(isset($materials) && $materials->count() > 0)
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-surface-800/50">
                        <tr>
                            <th class="px-4 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">
                                {{ __('Image') }}
                            </th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">
                                {{ __('Name') }}
                            </th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">
                                {{ __('Category') }}
                            </th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">
                                {{ __('Status') }}
                            </th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">
                                {{ __('Quantity') }}
                            </th>
                            <th class="px-4 py-3 text-{{ app()->getLocale() === 'ar' ? 'right' : 'left' }} text-xs font-semibold uppercase tracking-wider">
                                {{ __('Location') }}
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 dark:divide-white/5">
                        @foreach($materials as $material)
                            <tr class="hover:bg-zinc-50/50 dark:hover:bg-surface-800/30 transition-colors">
                                <!-- Image -->
                                <td class="px-4 py-3">
                                    <div class="w-12 h-12 rounded-lg overflow-hidden bg-gradient-to-br from-zinc-100 to-zinc-200 dark:from-surface-700 dark:to-surface-600">
                                        @if($material->image)
                                            <img src="{{ asset('storage/' . $material->image) }}" alt="{{ $material->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-full">
                                                <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>

                                <!-- Name -->
                                <td class="px-4 py-3">
                                    <div class="flex flex-col">
                                        <a href="{{ route('materials.show', $material) }}" class="font-semibold hover:text-accent-amber transition-colors">
                                            {{ $material->name }}
                                        </a>
                                        @if($material->serial_number)
                                            <span class="text-xs text-zinc-500 dark:text-zinc-400 font-mono mt-0.5">
                                                {{ $material->serial_number }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Category -->
                                <td class="px-4 py-3">
                                    <span class="text-sm">{{ $material->category->name ?? __('Uncategorized') }}</span>
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-3">
                                    @if($material->status === 'available')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-accent-emerald/10 text-accent-emerald">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ __('Available') }}
                                        </span>
                                    @elseif($material->status === 'maintenance')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-accent-amber/10 text-accent-amber">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ __('Maintenance') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-zinc-500/10 text-zinc-500">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ __('Retired') }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Quantity -->
                                <td class="px-4 py-3">
                                    <span class="font-mono font-semibold">{{ $material->quantity }}</span>
                                </td>

                                <!-- Location -->
                                <td class="px-4 py-3">
                                    <span class="text-sm">{{ $material->location }}</span>
                                </td>

                                <!-- Actions -->
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('materials.show', $material) }}" class="p-1.5 rounded-lg hover:bg-zinc-200 dark:hover:bg-surface-700 transition-colors" title="{{ __('View') }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>

                                        @if($material->status === 'available')
                                            <a href="{{ route('reservations.create', ['material' => $material->id]) }}" class="p-1.5 rounded-lg hover:bg-accent-violet/10 text-accent-violet transition-colors" title="{{ __('Reserve') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </a>
                                        @endif

                                        @can('update', $material)
                                            <a href="{{ route('materials.edit', $material) }}" class="p-1.5 rounded-lg hover:bg-accent-cyan/10 text-accent-cyan transition-colors" title="{{ __('Edit') }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endcan

                                        @can('delete', $material)
                                            <form action="{{ route('materials.destroy', $material) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this material?') }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-lg hover:bg-accent-rose/10 text-accent-rose transition-colors" title="{{ __('Delete') }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                </button>
                                            </form>
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
        <div class="flex items-center justify-between mt-6">
            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                {{ __('Showing') }} <span class="font-semibold text-zinc-800 dark:text-white">{{ $materials->firstItem() }}</span>
                {{ __('to') }} <span class="font-semibold text-zinc-800 dark:text-white">{{ $materials->lastItem() }}</span>
                {{ __('of') }} <span class="font-semibold text-zinc-800 dark:text-white">{{ $materials->total() }}</span>
                {{ __('materials') }}
            </div>
            <div>
                {{ $materials->appends(request()->query())->links() }}
            </div>
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
