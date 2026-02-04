@props([
    'id' => 'panel1',
])

<div
    x-show="activeTab === '{{ $id }}'"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    style="display: none;"
    {{ $attributes }}
>
    {{ $slot }}
</div>
