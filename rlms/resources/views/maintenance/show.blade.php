<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                <a href="{{ route('maintenance.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ app()->getLocale() === 'ar' ? 'M9 5l7 7-7 7' : 'M15 19l-7-7 7-7' }}"/>
                    </svg>
                </a>
                <div>
                    <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ __('Maintenance Log Details') }}
                    </h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        {{ __('Log') }} #{{ $log->id ?? '---' }}
                    </p>
                </div>
            </div>
            <x-badge :status="$log->status ?? 'scheduled'" size="lg">
                {{ __(ucfirst($log->status ?? 'scheduled')) }}
            </x-badge>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Material Info -->
                <x-card>
                    <x-slot name="title">{{ __('Equipment') }}</x-slot>
                    <div class="flex items-start space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                        <div class="flex-shrink-0 h-20 w-20 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden">
                            @if($log->material?->image)
                                <img src="{{ asset('storage/' . $log->material->image) }}"
                                    alt="{{ $log->material->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full">
                                    <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $log->material?->name ?? __('Material') }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $log->material?->category->name ?? __('Uncategorized') }}
                            </p>
                            <a href="{{ route('materials.show', $log->material) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline mt-2 inline-block">
                                {{ __('View material details') }} →
                            </a>
                        </div>
                    </div>
                </x-card>

                <!-- Maintenance Details -->
                <x-card>
                    <x-slot name="title">{{ __('Maintenance Details') }}</x-slot>
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Type') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ __(ucfirst($log->type)) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Scheduled Date') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $log->scheduled_date?->format('l, M d, Y') }}</dd>
                        </div>
                        @if($log->completed_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Completed At') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $log->completed_at->format('M d, Y H:i') }}</dd>
                            </div>
                        @endif
                        @if($log->cost)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Cost') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ number_format($log->cost, 2) }} {{ __('USD') }}</dd>
                            </div>
                        @endif
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Description') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $log->description }}</dd>
                        </div>
                    </dl>
                </x-card>

                <!-- Work Performed -->
                @if($log->work_performed)
                    <x-card>
                        <x-slot name="title">{{ __('Work Performed') }}</x-slot>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $log->work_performed }}</p>
                    </x-card>
                @endif

                <!-- Notes -->
                @if($log->notes)
                    <x-card>
                        <x-slot name="title">{{ __('Additional Notes') }}</x-slot>
                        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $log->notes }}</p>
                    </x-card>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Technician Info -->
                @if($log->technician)
                    <x-card>
                        <x-slot name="title">{{ __('Technician') }}</x-slot>
                        <div class="flex items-center space-x-3 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
                            <div class="h-12 w-12 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                <span class="text-lg font-medium text-gray-700 dark:text-gray-300">
                                    {{ substr($log->technician->name, 0, 2) }}
                                </span>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $log->technician->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $log->technician->email }}</p>
                            </div>
                        </div>
                    </x-card>
                @endif

                <!-- Actions -->
                @if($log->status != 'completed')
                    @can('update', $log)
                        <x-card>
                            <x-slot name="title">{{ __('Actions') }}</x-slot>
                            <div class="space-y-2">
                                <form method="POST" action="{{ route('maintenance.complete', $log) }}">
                                    @csrf
                                    <x-button variant="success" type="submit" class="w-full">
                                        <svg class="h-4 w-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ __('Mark as Complete') }}
                                    </x-button>
                                </form>
                                <a href="{{ route('maintenance.edit', $log) }}">
                                    <x-button variant="outline" class="w-full">
                                        <svg class="h-4 w-4 {{ app()->getLocale() === 'ar' ? 'ml-2' : 'mr-2' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        {{ __('Edit Log') }}
                                    </x-button>
                                </a>
                            </div>
                        </x-card>
                    @endcan
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
