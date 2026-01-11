@props([
    'files' => [],
    'type' => 'auto',
    'title' => null,
    'showDownload' => true,
    'showFullscreen' => true,
    'maxHeight' => '600px'
])

@php
    // Normalize files to array format
    $filesList = is_array($files) ? $files : [$files];
    $filesList = array_filter($filesList); // Remove empty values

    if (empty($filesList)) {
        $filesList = [];
        $detectedType = 'empty';
    } else {
        // Auto-detect type based on first file
        if ($type === 'auto' && !empty($filesList)) {
            $firstFile = $filesList[0];
            $extension = strtolower(pathinfo($firstFile, PATHINFO_EXTENSION));

            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'bmp'])) {
                $detectedType = 'image';
            } elseif ($extension === 'pdf') {
                $detectedType = 'pdf';
            } else {
                $detectedType = 'document';
            }
        } else {
            $detectedType = $type;
        }
    }

    // Generate unique ID for this instance
    $uniqueId = 'file-viewer-' . Str::random(8);
@endphp

<!-- Swiper CSS CDN -->
@once
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
        <style>
            .swiper-button-next, .swiper-button-prev {
                color: #f59e0b;
                background: rgba(255, 255, 255, 0.9);
                width: 44px;
                height: 44px;
                border-radius: 50%;
                backdrop-filter: blur(10px);
                transition: all 0.3s ease;
            }

            .dark .swiper-button-next,
            .dark .swiper-button-prev {
                background: rgba(26, 26, 37, 0.9);
                color: #f59e0b;
            }

            .swiper-button-next:hover,
            .swiper-button-prev:hover {
                background: rgba(245, 158, 11, 0.2);
                transform: scale(1.1);
            }

            .swiper-button-next::after,
            .swiper-button-prev::after {
                font-size: 20px;
                font-weight: bold;
            }

            .swiper-pagination-bullet {
                background: #f59e0b;
                opacity: 0.5;
                width: 10px;
                height: 10px;
            }

            .swiper-pagination-bullet-active {
                opacity: 1;
                background: linear-gradient(135deg, #f59e0b, #f97316);
            }

            .swiper-slide {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .thumbnail-swiper .swiper-slide {
                cursor: pointer;
                opacity: 0.5;
                transition: all 0.3s ease;
                border-radius: 12px;
                overflow: hidden;
            }

            .thumbnail-swiper .swiper-slide-thumb-active {
                opacity: 1;
                border: 2px solid #f59e0b;
            }

            .thumbnail-swiper .swiper-slide:hover {
                opacity: 1;
            }

            .viewer-fullscreen {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 9999;
                background: rgba(0, 0, 0, 0.95);
            }

            .viewer-fullscreen .swiper {
                height: 100vh !important;
            }

            .viewer-fullscreen .thumbnail-swiper {
                display: none;
            }
        </style>
    @endpush
@endonce

<div
    x-data="{
        isFullscreen: false,
        currentIndex: 0,
        files: {{ json_encode($filesList) }},

        toggleFullscreen() {
            this.isFullscreen = !this.isFullscreen;
            if (this.isFullscreen) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = '';
            }
        },

        downloadFile(url, filename) {
            const link = document.createElement('a');
            link.href = url;
            link.download = filename || 'download';
            link.target = '_blank';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        },

        getFileName(path) {
            return path.split('/').pop();
        },

        closeFullscreen() {
            this.isFullscreen = false;
            document.body.style.overflow = '';
        }
    }"
    @keydown.escape.window="closeFullscreen()"
    :class="isFullscreen ? 'viewer-fullscreen' : ''"
    {{ $attributes->merge(['class' => 'relative']) }}
>
    @if($detectedType === 'empty')
        <!-- Empty State -->
        <div class="glass-card rounded-xl p-12 text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-zinc-100 dark:bg-surface-700 mb-4">
                <svg class="w-10 h-10 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2">{{ __('file-viewer.no_files_title') }}</h3>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">{{ __('file-viewer.no_files_description') }}</p>
        </div>

    @elseif($detectedType === 'image')
        <!-- Image Viewer with Swiper -->
        <div class="glass-card rounded-xl overflow-hidden" :class="isFullscreen ? 'rounded-none' : ''">
            <!-- Header -->
            @if($title || $showDownload || $showFullscreen)
                <div class="px-6 py-4 border-b border-black/10 dark:border-white/10 flex justify-between items-center">
                    @if($title)
                        <h3 class="text-lg font-semibold">{{ $title }}</h3>
                    @else
                        <div></div>
                    @endif

                    <div class="flex items-center gap-2">
                        @if($showDownload && count($filesList) > 0)
                            <button
                                @click="downloadFile(files[currentIndex], getFileName(files[currentIndex]))"
                                class="p-2.5 rounded-xl glass hover:glass-card transition-all hover:text-accent-amber"
                                title="{{ __('file-viewer.download') }}"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                            </button>
                        @endif

                        @if($showFullscreen)
                            <button
                                @click="toggleFullscreen()"
                                class="p-2.5 rounded-xl glass hover:glass-card transition-all hover:text-accent-violet"
                                title="{{ __('file-viewer.toggle_fullscreen') }}"
                            >
                                <svg x-show="!isFullscreen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                </svg>
                                <svg x-show="isFullscreen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-cloak>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Main Swiper -->
            <div style="max-height: {{ $maxHeight }};" :style="isFullscreen ? 'max-height: 100vh;' : ''">
                <div class="swiper main-swiper-{{ $uniqueId }}" style="height: {{ $maxHeight }};" :style="isFullscreen ? 'height: 100vh;' : ''">
                    <div class="swiper-wrapper">
                        @foreach($filesList as $file)
                            <div class="swiper-slide">
                                <img
                                    src="{{ Storage::url($file) }}"
                                    alt="{{ basename($file) }}"
                                    class="max-w-full max-h-full object-contain"
                                    style="max-height: {{ $maxHeight }};"
                                    :style="isFullscreen ? 'max-height: 100vh;' : ''"
                                >
                            </div>
                        @endforeach
                    </div>

                    @if(count($filesList) > 1)
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    @endif
                </div>
            </div>

            <!-- Thumbnail Swiper -->
            @if(count($filesList) > 1)
                <div class="px-6 py-4 border-t border-black/10 dark:border-white/10" x-show="!isFullscreen">
                    <div class="swiper thumbnail-swiper thumbnail-swiper-{{ $uniqueId }}" style="height: 80px;">
                        <div class="swiper-wrapper">
                            @foreach($filesList as $file)
                                <div class="swiper-slide">
                                    <img
                                        src="{{ Storage::url($file) }}"
                                        alt="{{ basename($file) }}"
                                        class="w-full h-full object-cover rounded-lg"
                                    >
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- File Info -->
            <div class="px-6 py-3 bg-black/5 dark:bg-white/5 text-xs text-center" x-show="!isFullscreen">
                <span class="font-medium" x-text="`${currentIndex + 1} / ${files.length}`"></span>
                <span class="mx-2 text-zinc-400">•</span>
                <span class="text-zinc-500 dark:text-zinc-400" x-text="getFileName(files[currentIndex])"></span>
            </div>
        </div>

    @elseif($detectedType === 'pdf')
        <!-- PDF Viewer -->
        <div class="glass-card rounded-xl overflow-hidden">
            <!-- Header -->
            @if($title || $showDownload)
                <div class="px-6 py-4 border-b border-black/10 dark:border-white/10 flex justify-between items-center">
                    @if($title)
                        <h3 class="text-lg font-semibold">{{ $title }}</h3>
                    @else
                        <div class="flex items-center gap-3">
                            <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-accent-rose/10">
                                <svg class="w-6 h-6 text-accent-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="font-medium">{{ basename($filesList[0]) }}</span>
                        </div>
                    @endif

                    @if($showDownload)
                        <a
                            href="{{ Storage::url($filesList[0]) }}"
                            download="{{ basename($filesList[0]) }}"
                            target="_blank"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card transition-all hover:text-accent-amber"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span class="text-sm font-medium">{{ __('file-viewer.download') }}</span>
                        </a>
                    @endif
                </div>
            @endif

            <!-- PDF Iframe -->
            <div class="relative bg-zinc-100 dark:bg-surface-800" style="height: {{ $maxHeight }};">
                <iframe
                    src="{{ Storage::url($filesList[0]) }}"
                    class="w-full h-full border-0"
                    title="{{ basename($filesList[0]) }}"
                ></iframe>
            </div>
        </div>

    @else
        <!-- Document Viewer -->
        <div class="glass-card rounded-xl overflow-hidden">
            <!-- Header -->
            @if($title || $showDownload)
                <div class="px-6 py-4 border-b border-black/10 dark:border-white/10 flex justify-between items-center">
                    @if($title)
                        <h3 class="text-lg font-semibold">{{ $title }}</h3>
                    @else
                        <div class="flex items-center gap-3">
                            <div class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-accent-cyan/10">
                                <svg class="w-6 h-6 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <span class="font-medium">{{ basename($filesList[0]) }}</span>
                        </div>
                    @endif

                    @if($showDownload)
                        <a
                            href="{{ Storage::url($filesList[0]) }}"
                            download="{{ basename($filesList[0]) }}"
                            target="_blank"
                            class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass hover:glass-card transition-all hover:text-accent-amber"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            <span class="text-sm font-medium">{{ __('file-viewer.download') }}</span>
                        </a>
                    @endif
                </div>
            @endif

            <!-- Document Iframe or Preview -->
            <div class="relative bg-zinc-100 dark:bg-surface-800" style="height: {{ $maxHeight }};">
                @php
                    $extension = strtolower(pathinfo($filesList[0], PATHINFO_EXTENSION));
                    $viewableInBrowser = in_array($extension, ['txt', 'html', 'xml', 'json', 'csv']);
                @endphp

                @if($viewableInBrowser)
                    <iframe
                        src="{{ Storage::url($filesList[0]) }}"
                        class="w-full h-full border-0"
                        title="{{ basename($filesList[0]) }}"
                    ></iframe>
                @else
                    <div class="flex flex-col items-center justify-center h-full p-8 text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 rounded-2xl bg-accent-cyan/10 mb-6">
                            <svg class="w-12 h-12 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2">{{ basename($filesList[0]) }}</h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-6">
                            {{ __('file-viewer.cannot_preview') }}
                        </p>
                        <a
                            href="{{ Storage::url($filesList[0]) }}"
                            download="{{ basename($filesList[0]) }}"
                            target="_blank"
                            class="flex items-center gap-2 px-6 py-3 rounded-xl glass hover:glass-card transition-all hover:text-accent-amber font-medium"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            {{ __('file-viewer.download_to_view') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>

<!-- Swiper JS CDN -->
@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                initializeFileViewerSwipers();
            });

            // Also initialize on Turbo navigation
            document.addEventListener('turbo:load', function() {
                initializeFileViewerSwipers();
            });

            function initializeFileViewerSwipers() {
                // Find all main swipers
                document.querySelectorAll('[class*="main-swiper-"]').forEach(function(mainSwiperEl) {
                    const uniqueId = mainSwiperEl.className.match(/main-swiper-(\w+)/)[1];
                    const thumbnailSwiperEl = document.querySelector('.thumbnail-swiper-' + uniqueId);

                    let thumbnailSwiper = null;

                    // Initialize thumbnail swiper first if it exists
                    if (thumbnailSwiperEl) {
                        thumbnailSwiper = new Swiper(thumbnailSwiperEl, {
                            spaceBetween: 10,
                            slidesPerView: 4,
                            freeMode: true,
                            watchSlidesProgress: true,
                            breakpoints: {
                                640: { slidesPerView: 6 },
                                768: { slidesPerView: 8 },
                                1024: { slidesPerView: 10 }
                            }
                        });
                    }

                    // Initialize main swiper
                    const mainSwiper = new Swiper(mainSwiperEl, {
                        spaceBetween: 10,
                        navigation: {
                            nextEl: mainSwiperEl.querySelector('.swiper-button-next'),
                            prevEl: mainSwiperEl.querySelector('.swiper-button-prev'),
                        },
                        pagination: {
                            el: mainSwiperEl.querySelector('.swiper-pagination'),
                            clickable: true,
                        },
                        thumbs: thumbnailSwiper ? {
                            swiper: thumbnailSwiper,
                        } : undefined,
                        keyboard: {
                            enabled: true,
                        },
                        on: {
                            slideChange: function() {
                                // Update Alpine.js data
                                const viewerEl = mainSwiperEl.closest('[x-data]');
                                if (viewerEl && viewerEl.__x) {
                                    viewerEl.__x.$data.currentIndex = this.activeIndex;
                                }
                            }
                        }
                    });
                });
            }
        </script>
    @endpush
@endonce

<style>
    [x-cloak] { display: none !important; }
</style>
