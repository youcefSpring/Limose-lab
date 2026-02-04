@props([
    'tabs' => [], // Array of ['id' => 'en', 'label' => 'English', 'icon' => '🇬🇧']
    'activeTab' => null,
])

@php
$activeTabId = $activeTab ?? ($tabs[0]['id'] ?? 'tab1');
@endphp

<div x-data="{ activeTab: '{{ $activeTabId }}' }">
    <!-- Tab Headers -->
    <div class="flex items-center gap-2 mb-4 border-b border-black/10 dark:border-white/10">
        @foreach($tabs as $tab)
            <button
                type="button"
                @click="activeTab = '{{ $tab['id'] }}'"
                :class="{
                    'border-accent-indigo text-accent-indigo dark:text-accent-indigo': activeTab === '{{ $tab['id'] }}',
                    'border-transparent text-zinc-500 dark:text-zinc-400 hover:text-zinc-700 dark:hover:text-zinc-300': activeTab !== '{{ $tab['id'] }}'
                }"
                class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium border-b-2 transition-all -mb-px"
            >
                @if(isset($tab['icon']))
                    <span>{{ $tab['icon'] }}</span>
                @endif
                <span>{{ $tab['label'] }}</span>
            </button>
        @endforeach
    </div>

    <!-- Tab Content -->
    <div class="mt-4">
        {{ $slot }}
    </div>
</div>
