{{--
    File Viewer Component - Simple Test Page
    Used with test routes to quickly verify component functionality
--}}

<x-app-layout>
    <div class="max-w-5xl mx-auto">
        <!-- Page Header -->
        <div class="glass-card rounded-xl p-6 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">{{ $title ?? 'File Viewer Test' }}</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Type: <span class="font-mono text-accent-amber">{{ $type ?? 'auto' }}</span>
                    </p>
                </div>
                <a href="{{ route('file-viewer.demo') }}" class="px-4 py-2 rounded-xl glass hover:glass-card transition-all text-sm font-medium">
                    View Full Demo
                </a>
            </div>
        </div>

        <!-- File Viewer Component -->
        <x-file-viewer
            :files="$files"
            :type="$type ?? 'auto'"
            :title="$title ?? null"
            :showDownload="$showDownload ?? true"
            :showFullscreen="$showFullscreen ?? true"
            :maxHeight="$maxHeight ?? '600px'"
        />

        <!-- Info Card -->
        <div class="glass-card rounded-xl p-6 mt-6">
            <h2 class="text-lg font-semibold mb-4">Test Information</h2>
            <div class="space-y-2 text-sm">
                <div class="flex">
                    <span class="font-semibold w-32">Files:</span>
                    <span class="font-mono text-zinc-600 dark:text-zinc-400">
                        {{ is_array($files) ? count($files) . ' files' : '1 file' }}
                    </span>
                </div>
                <div class="flex">
                    <span class="font-semibold w-32">Type:</span>
                    <span class="font-mono text-zinc-600 dark:text-zinc-400">{{ $type ?? 'auto' }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold w-32">Max Height:</span>
                    <span class="font-mono text-zinc-600 dark:text-zinc-400">{{ $maxHeight ?? '600px' }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold w-32">Download:</span>
                    <span class="font-mono text-zinc-600 dark:text-zinc-400">{{ $showDownload ?? true ? 'enabled' : 'disabled' }}</span>
                </div>
                <div class="flex">
                    <span class="font-semibold w-32">Fullscreen:</span>
                    <span class="font-mono text-zinc-600 dark:text-zinc-400">{{ $showFullscreen ?? true ? 'enabled' : 'disabled' }}</span>
                </div>
            </div>

            @if(is_array($files))
                <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                    <h3 class="font-semibold mb-2">File List:</h3>
                    <ul class="space-y-1 text-sm">
                        @foreach($files as $index => $file)
                            <li class="flex items-center gap-2">
                                <span class="text-zinc-500">{{ $index + 1 }}.</span>
                                <span class="font-mono text-zinc-600 dark:text-zinc-400">{{ $file }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Test Navigation -->
        <div class="glass-card rounded-xl p-6 mt-6">
            <h2 class="text-lg font-semibold mb-4">Quick Tests</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('file-viewer.test.image') }}" class="px-4 py-3 rounded-xl glass hover:glass-card transition-all text-center text-sm font-medium">
                    Single Image
                </a>
                <a href="{{ route('file-viewer.test.gallery') }}" class="px-4 py-3 rounded-xl glass hover:glass-card transition-all text-center text-sm font-medium">
                    Gallery
                </a>
                <a href="{{ route('file-viewer.test.pdf') }}" class="px-4 py-3 rounded-xl glass hover:glass-card transition-all text-center text-sm font-medium">
                    PDF
                </a>
                <a href="{{ route('file-viewer.test.document') }}" class="px-4 py-3 rounded-xl glass hover:glass-card transition-all text-center text-sm font-medium">
                    Document
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
