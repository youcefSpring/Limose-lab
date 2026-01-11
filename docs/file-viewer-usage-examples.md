# File Viewer Component - Usage Examples Collection

## Table of Contents
1. [Basic Examples](#basic-examples)
2. [Publications Module](#publications-module)
3. [Events Module](#events-module)
4. [Projects Module](#projects-module)
5. [Materials Module](#materials-module)
6. [Advanced Examples](#advanced-examples)

---

## Basic Examples

### 1. Single Image
```blade
{{-- Simplest usage --}}
<x-file-viewer :files="'storage/images/photo.jpg'" />
```

### 2. Multiple Images
```blade
{{-- Image gallery --}}
<x-file-viewer
    :files="[
        'storage/images/photo1.jpg',
        'storage/images/photo2.jpg',
        'storage/images/photo3.jpg'
    ]"
/>
```

### 3. PDF Document
```blade
{{-- PDF with title --}}
<x-file-viewer
    :files="'storage/documents/report.pdf'"
    type="pdf"
    title="Annual Report 2026"
/>
```

### 4. Document File
```blade
{{-- Word document --}}
<x-file-viewer
    :files="'storage/documents/proposal.docx'"
    title="Project Proposal"
/>
```

---

## Publications Module

### Show Page - Full Example
```blade
{{-- resources/views/publications/show.blade.php --}}

<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        {{-- Header Card --}}
        <div class="glass-card rounded-xl p-8">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $publication->title }}</h1>
                    <p class="text-sm text-zinc-500 dark:text-zinc-400">
                        {{ __('Published on') }}: {{ $publication->published_at->format('M d, Y') }}
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('publications.edit', $publication) }}" class="px-4 py-2 rounded-xl glass hover:glass-card">
                        {{ __('Edit') }}
                    </a>
                    <a href="{{ route('publications.index') }}" class="px-4 py-2 rounded-xl glass hover:glass-card">
                        {{ __('Back') }}
                    </a>
                </div>
            </div>

            {{-- Abstract --}}
            <div class="prose dark:prose-invert max-w-none">
                <h2>{{ __('Abstract') }}</h2>
                <p>{{ $publication->abstract }}</p>
            </div>
        </div>

        {{-- Images Gallery --}}
        @if($publication->images && count($publication->images) > 0)
            <div class="glass-card rounded-xl p-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('Publication Images') }}</h2>
                <x-file-viewer
                    :files="$publication->images"
                    type="image"
                    :showFullscreen="true"
                    :showDownload="true"
                    maxHeight="600px"
                />
            </div>
        @endif

        {{-- Full Paper PDF --}}
        @if($publication->pdf_file)
            <div class="glass-card rounded-xl p-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('Full Paper') }}</h2>
                <x-file-viewer
                    :files="$publication->pdf_file"
                    type="pdf"
                    title="{{ $publication->title }} - {{ __('Full Paper') }}"
                    :showDownload="true"
                    maxHeight="800px"
                />
            </div>
        @endif

        {{-- Additional Documents --}}
        @if($publication->supplementary_files && count($publication->supplementary_files) > 0)
            <div class="glass-card rounded-xl p-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('Supplementary Materials') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($publication->supplementary_files as $file)
                        <x-file-viewer
                            :files="$file"
                            maxHeight="400px"
                            :showDownload="true"
                        />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
```

### Index Page - Thumbnail Previews
```blade
{{-- resources/views/publications/index.blade.php --}}

<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($publications as $publication)
                <div class="glass-card rounded-xl overflow-hidden hover:shadow-xl transition-all">
                    {{-- Featured Image Preview --}}
                    @if($publication->featured_image)
                        <x-file-viewer
                            :files="$publication->featured_image"
                            maxHeight="250px"
                            :showDownload="false"
                            :showFullscreen="false"
                        />
                    @endif

                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2">{{ $publication->title }}</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4 line-clamp-3">
                            {{ $publication->abstract }}
                        </p>
                        <a href="{{ route('publications.show', $publication) }}" class="text-accent-amber hover:text-accent-coral">
                            {{ __('Read more') }} →
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
```

---

## Events Module

### Event Show Page
```blade
{{-- resources/views/events/show.blade.php --}}

<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        {{-- Event Details --}}
        <div class="glass-card rounded-xl p-8">
            <h1 class="text-3xl font-bold mb-4">{{ $event->title }}</h1>
            <div class="flex gap-6 text-sm mb-6">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $event->date->format('F d, Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>{{ $event->location }}</span>
                </div>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">{{ $event->description }}</p>
        </div>

        {{-- Event Poster --}}
        @if($event->poster)
            <div class="glass-card rounded-xl p-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('Event Poster') }}</h2>
                <x-file-viewer
                    :files="$event->poster"
                    :showFullscreen="true"
                    :showDownload="true"
                    maxHeight="700px"
                />
            </div>
        @endif

        {{-- Event Gallery --}}
        @if($event->images && count($event->images) > 0)
            <div class="glass-card rounded-xl p-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('Event Gallery') }}</h2>
                <x-file-viewer
                    :files="$event->images"
                    type="image"
                    :showFullscreen="true"
                    maxHeight="600px"
                />
            </div>
        @endif

        {{-- Event Schedule PDF --}}
        @if($event->schedule_pdf)
            <div class="glass-card rounded-xl p-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('Event Schedule') }}</h2>
                <x-file-viewer
                    :files="$event->schedule_pdf"
                    type="pdf"
                    title="{{ __('Event Schedule') }}"
                    maxHeight="600px"
                />
            </div>
        @endif
    </div>
</x-app-layout>
```

---

## Projects Module

### Project Show Page
```blade
{{-- resources/views/projects/show.blade.php --}}

<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-6">
        {{-- Project Info --}}
        <div class="glass-card rounded-xl p-8">
            <div class="flex items-start justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold mb-2">{{ $project->title }}</h1>
                    <div class="flex items-center gap-3 text-sm">
                        <span class="px-3 py-1 rounded-full bg-accent-emerald/20 text-accent-emerald">
                            {{ $project->status }}
                        </span>
                        <span class="text-zinc-500">{{ $project->start_date->format('M Y') }} - {{ $project->end_date ? $project->end_date->format('M Y') : 'Present' }}</span>
                    </div>
                </div>
            </div>
            <p class="text-zinc-600 dark:text-zinc-400">{{ $project->description }}</p>
        </div>

        {{-- Project Images --}}
        @if($project->images && count($project->images) > 0)
            <div class="glass-card rounded-xl p-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('Project Images') }}</h2>
                <x-file-viewer
                    :files="$project->images"
                    type="image"
                    maxHeight="500px"
                />
            </div>
        @endif

        {{-- Project Documentation --}}
        @if($project->documents && count($project->documents) > 0)
            <div class="glass-card rounded-xl p-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('Project Documentation') }}</h2>
                <div class="space-y-6">
                    @foreach($project->documents as $document)
                        <x-file-viewer
                            :files="$document"
                            :showDownload="true"
                            maxHeight="500px"
                        />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
```

---

## Materials Module

### Material Show Page
```blade
{{-- resources/views/materials/show.blade.php --}}

<x-app-layout>
    <div class="max-w-5xl mx-auto space-y-6">
        <div class="glass-card rounded-xl p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Material Image --}}
                <div>
                    @if($material->image)
                        <x-file-viewer
                            :files="$material->image"
                            :showFullscreen="true"
                            maxHeight="500px"
                        />
                    @endif
                </div>

                {{-- Material Details --}}
                <div>
                    <h1 class="text-3xl font-bold mb-4">{{ $material->name }}</h1>
                    <div class="space-y-4">
                        <div>
                            <span class="font-semibold">{{ __('Category') }}:</span>
                            <span>{{ $material->category->name }}</span>
                        </div>
                        <div>
                            <span class="font-semibold">{{ __('Status') }}:</span>
                            <span class="px-3 py-1 rounded-full bg-accent-emerald/20 text-accent-emerald">
                                {{ $material->status }}
                            </span>
                        </div>
                        <div>
                            <span class="font-semibold">{{ __('Description') }}:</span>
                            <p class="mt-2">{{ $material->description }}</p>
                        </div>

                        {{-- User Manual --}}
                        @if($material->manual_pdf)
                            <div class="pt-4">
                                <a href="#manual" class="flex items-center gap-2 text-accent-amber hover:text-accent-coral">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    {{ __('View User Manual') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- User Manual Section --}}
        @if($material->manual_pdf)
            <div id="manual" class="glass-card rounded-xl p-8">
                <h2 class="text-2xl font-bold mb-6">{{ __('User Manual') }}</h2>
                <x-file-viewer
                    :files="$material->manual_pdf"
                    type="pdf"
                    title="{{ $material->name }} - {{ __('User Manual') }}"
                    maxHeight="700px"
                />
            </div>
        @endif
    </div>
</x-app-layout>
```

---

## Advanced Examples

### 1. In a Modal
```blade
{{-- Button to open modal --}}
<button
    @click="$dispatch('open-modal', 'view-images')"
    class="px-4 py-2 rounded-xl glass hover:glass-card"
>
    {{ __('View Images') }}
</button>

{{-- Modal with file viewer --}}
<x-modal name="view-images" maxWidth="6xl">
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-6">{{ $publication->title }}</h2>
        <x-file-viewer
            :files="$publication->images"
            :showFullscreen="false"
            maxHeight="70vh"
        />
        <div class="flex justify-end mt-6">
            <button
                @click="$dispatch('close-modal', 'view-images')"
                class="px-4 py-2 rounded-xl glass hover:glass-card"
            >
                {{ __('Close') }}
            </button>
        </div>
    </div>
</x-modal>
```

### 2. Conditional Display
```blade
{{-- Show different viewers based on file type --}}
@if($publication->has_images)
    <x-file-viewer
        :files="$publication->images"
        type="image"
        title="{{ __('Images') }}"
    />
@endif

@if($publication->has_pdf)
    <x-file-viewer
        :files="$publication->pdf_file"
        type="pdf"
        title="{{ __('Full Paper') }}"
    />
@endif
```

### 3. Side-by-Side Viewers
```blade
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Before Image --}}
    <div class="glass-card rounded-xl p-6">
        <h3 class="text-lg font-bold mb-4">{{ __('Before') }}</h3>
        <x-file-viewer
            :files="$experiment->before_image"
            maxHeight="400px"
            :showDownload="false"
        />
    </div>

    {{-- After Image --}}
    <div class="glass-card rounded-xl p-6">
        <h3 class="text-lg font-bold mb-4">{{ __('After') }}</h3>
        <x-file-viewer
            :files="$experiment->after_image"
            maxHeight="400px"
            :showDownload="false"
        />
    </div>
</div>
```

### 4. Dynamic Height Based on Content
```blade
{{-- Adjust height based on number of images --}}
@php
    $height = count($publication->images) > 5 ? '800px' : '500px';
@endphp

<x-file-viewer
    :files="$publication->images"
    :maxHeight="$height"
/>
```

### 5. With Custom Classes
```blade
<x-file-viewer
    :files="$images"
    class="shadow-2xl border-2 border-accent-amber rounded-2xl overflow-hidden"
    maxHeight="600px"
/>
```

### 6. Disabled Features
```blade
{{-- Disable download for protected content --}}
<x-file-viewer
    :files="$protectedDocument"
    :showDownload="false"
    :showFullscreen="false"
    title="{{ __('Preview Only') }}"
/>
```

### 7. Multiple Viewers on Same Page
```blade
{{-- Each viewer has unique ID, no conflicts --}}
<div class="space-y-8">
    <x-file-viewer :files="$publication->images" title="{{ __('Images') }}" />
    <x-file-viewer :files="$publication->pdf_file" type="pdf" title="{{ __('PDF') }}" />
    <x-file-viewer :files="$publication->supplementary" title="{{ __('Supplementary') }}" />
</div>
```

### 8. With Loading State
```blade
<div x-data="{ loading: true }">
    <div x-show="loading" class="text-center py-12">
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-accent-amber mx-auto"></div>
        <p class="mt-4 text-zinc-500">{{ __('Loading...') }}</p>
    </div>

    <div x-show="!loading" @load="loading = false">
        <x-file-viewer :files="$images" />
    </div>
</div>
```

### 9. From External URL (if allowed)
```blade
{{-- If Storage::url() returns full URL --}}
<x-file-viewer
    :files="Storage::url('publications/image.jpg')"
/>
```

### 10. Empty State Handling
```blade
{{-- Gracefully handle empty/null files --}}
<x-file-viewer
    :files="$publication->images ?? []"
    title="{{ __('Publication Images') }}"
/>
{{-- Component will show empty state if no files --}}
```

---

## Controller Integration Examples

### Publications Controller
```php
public function show(Publication $publication)
{
    return view('publications.show', [
        'publication' => $publication,
    ]);
}
```

### Events Controller
```php
public function show(Event $event)
{
    // Load relationships if needed
    $event->load('images', 'documents');

    return view('events.show', compact('event'));
}
```

### Materials Controller
```php
public function show(Material $material)
{
    return view('materials.show', [
        'material' => $material,
    ]);
}
```

---

## Tips & Best Practices

1. **Always check for file existence** before displaying viewer
2. **Use appropriate maxHeight** for your layout
3. **Enable fullscreen** for galleries, disable for thumbnails
4. **Disable download** for protected content
5. **Use type="auto"** for flexibility (default)
6. **Add title** for better UX
7. **Test with different file types**
8. **Consider mobile experience** (smaller maxHeight on mobile)
9. **Use grid layouts** for multiple viewers
10. **Handle empty states** gracefully

---

## Common Patterns

### Pattern 1: Card with Preview
```blade
<div class="glass-card rounded-xl overflow-hidden">
    <x-file-viewer :files="$image" maxHeight="300px" :showDownload="false" />
    <div class="p-6">
        <h3>{{ $title }}</h3>
        <p>{{ $description }}</p>
    </div>
</div>
```

### Pattern 2: Full-Page Viewer
```blade
<x-app-layout>
    <x-file-viewer
        :files="$files"
        :title="$title"
        maxHeight="calc(100vh - 200px)"
    />
</x-app-layout>
```

### Pattern 3: Tabbed Viewers
```blade
<div x-data="{ tab: 'images' }">
    <div class="flex gap-2 mb-4">
        <button @click="tab = 'images'" :class="tab === 'images' ? 'active' : ''">Images</button>
        <button @click="tab = 'pdf'" :class="tab === 'pdf' ? 'active' : ''">PDF</button>
    </div>

    <div x-show="tab === 'images'">
        <x-file-viewer :files="$images" type="image" />
    </div>

    <div x-show="tab === 'pdf'">
        <x-file-viewer :files="$pdf" type="pdf" />
    </div>
</div>
```

---

**Version**: v1.0.0 (2026-01-11)
**Component Path**: `resources/views/components/file-viewer.blade.php`
