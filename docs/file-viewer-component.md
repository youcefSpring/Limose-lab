# File Viewer Component Documentation

## Overview
The File Viewer Component is a reusable Blade component for displaying various file types in the RLMS application. It features a glassmorphic design matching the RLMS theme, supports both light and dark modes, and provides an intuitive interface for viewing images, PDFs, and documents.

## Location
`/resources/views/components/file-viewer.blade.php`

## Features
- Auto-detection of file types (images, PDFs, documents)
- Image carousel with Swiper.js (with thumbnails for multiple images)
- PDF viewer with iframe integration
- Document viewer with download functionality
- Glassmorphic design matching RLMS theme
- Light and dark mode support
- Fullscreen mode for images
- Download functionality
- Keyboard navigation (arrow keys for images, ESC to close fullscreen)
- Responsive design
- RTL support (Arabic)

## Props

### `files` (array|string) - Required
Array of file paths or a single file path string.
```php
// Single file
:files="'storage/uploads/document.pdf'"

// Multiple files
:files="['storage/uploads/image1.jpg', 'storage/uploads/image2.jpg']"

// From database
:files="$publication->images"
```

### `type` (string) - Optional (default: 'auto')
File type to display. Options:
- `'auto'` - Auto-detect based on file extension
- `'image'` - Force image viewer
- `'pdf'` - Force PDF viewer
- `'document'` - Force document viewer

```php
:type="'pdf'"
```

### `title` (string|null) - Optional
Title displayed in the viewer header.
```php
title="Publication Images"
```

### `showDownload` (boolean) - Optional (default: true)
Show/hide download button.
```php
:showDownload="false"
```

### `showFullscreen` (boolean) - Optional (default: true)
Show/hide fullscreen button (images only).
```php
:showFullscreen="false"
```

### `maxHeight` (string) - Optional (default: '600px')
Maximum height of the viewer.
```php
maxHeight="800px"
```

## Usage Examples

### Example 1: Single Image Viewer
```blade
<x-file-viewer
    :files="$publication->featured_image"
    title="Featured Image"
/>
```

### Example 2: Multiple Images with Carousel
```blade
<x-file-viewer
    :files="$publication->images"
    type="image"
    title="Publication Gallery"
    maxHeight="700px"
/>
```

### Example 3: PDF Viewer
```blade
<x-file-viewer
    :files="$publication->pdf_file"
    type="pdf"
    title="Research Paper"
    :showDownload="true"
/>
```

### Example 4: Document Viewer
```blade
<x-file-viewer
    :files="'storage/documents/report.docx'"
    title="Annual Report"
/>
```

### Example 5: Auto-detection with Multiple Files
```blade
{{-- Automatically detects type based on first file extension --}}
<x-file-viewer
    :files="[$project->images, $project->documents]->flatten()->toArray()"
/>
```

### Example 6: In a Modal
```blade
<x-modal name="view-publication-images" maxWidth="6xl">
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">{{ $publication->title }}</h2>
        <x-file-viewer
            :files="$publication->images"
            :showDownload="true"
            maxHeight="600px"
        />
    </div>
</x-modal>
```

### Example 7: In Publications Index
```blade
{{-- resources/views/publications/index.blade.php --}}
@foreach($publications as $publication)
    <div class="glass-card rounded-xl p-6 mb-4">
        <h3 class="text-xl font-bold mb-4">{{ $publication->title }}</h3>

        @if($publication->images)
            <x-file-viewer
                :files="$publication->images"
                maxHeight="400px"
                :showFullscreen="true"
            />
        @endif

        @if($publication->pdf_file)
            <div class="mt-4">
                <x-file-viewer
                    :files="$publication->pdf_file"
                    type="pdf"
                    title="Full Paper"
                    maxHeight="500px"
                />
            </div>
        @endif
    </div>
@endforeach
```

### Example 8: With Custom Classes
```blade
<x-file-viewer
    :files="$images"
    title="Project Images"
    class="shadow-2xl"
/>
```

### Example 9: Empty State Handling
```blade
{{-- Component automatically shows empty state if no files provided --}}
<x-file-viewer :files="[]" />
```

### Example 10: In Event Show Page
```blade
{{-- resources/views/events/show.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto">
        <div class="glass-card rounded-xl p-8">
            <h1 class="text-3xl font-bold mb-6">{{ $event->title }}</h1>

            {{-- Event Images --}}
            @if($event->images && count($event->images) > 0)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">{{ __('Event Gallery') }}</h2>
                    <x-file-viewer
                        :files="$event->images"
                        type="image"
                        :showFullscreen="true"
                        maxHeight="600px"
                    />
                </div>
            @endif

            {{-- Event Poster --}}
            @if($event->poster)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-4">{{ __('Event Poster') }}</h2>
                    <x-file-viewer
                        :files="$event->poster"
                        :showDownload="true"
                    />
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
```

## File Type Detection

The component auto-detects file types based on file extensions:

### Image Extensions
- jpg, jpeg, png, gif, svg, webp, bmp

### PDF Extensions
- pdf

### Document Extensions
- doc, docx, odt, txt, html, xml, json, csv

## Keyboard Controls

### Image Viewer
- **Arrow Left/Right**: Navigate between images
- **ESC**: Exit fullscreen mode

## Responsive Behavior

### Desktop (≥1024px)
- Full-width viewer
- 10 thumbnails visible
- Navigation arrows on sides

### Tablet (768px - 1023px)
- Adaptive width
- 8 thumbnails visible
- Optimized touch controls

### Mobile (<768px)
- Full-width viewer
- 4-6 thumbnails visible
- Touch-friendly swipe gestures

## Theme Integration

The component uses RLMS theme colors:
- **Amber** (#f59e0b): Primary navigation, active states
- **Violet** (#8b5cf6): Fullscreen toggle
- **Rose** (#f43f5e): PDF icons
- **Cyan** (#06b6d4): Document icons
- **Emerald** (#10b981): Success states

## Dark Mode

The component automatically adapts to dark mode using:
- Glass effect with adjusted opacity
- Theme-aware colors
- Automatic background adjustments

## Dependencies

### CDN Resources
```html
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
```

These are automatically loaded via `@push('styles')` and `@push('scripts')`.

### Required Technologies
- Laravel Blade
- Alpine.js (included in app.blade.php)
- Tailwind CSS (included in app.blade.php)
- Swiper.js 11+ (loaded via CDN)

## Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+

## Performance Considerations

1. **Lazy Loading**: Images are loaded on demand by Swiper
2. **CDN Caching**: Swiper resources are cached via CDN
3. **Optimized Rendering**: Only visible slides are rendered
4. **Minimal JS**: Uses Alpine.js for lightweight interactivity

## Accessibility

- Semantic HTML structure
- ARIA labels on buttons
- Keyboard navigation support
- Screen reader friendly
- Focus management in fullscreen mode

## Troubleshooting

### Images Not Displaying
Ensure the file paths are correct and accessible via `Storage::url()`:
```php
// Make sure storage is linked
php artisan storage:link
```

### Swiper Not Initializing
Check browser console for errors and ensure Swiper CDN is accessible.

### Dark Mode Issues
Verify that the parent layout includes the dark mode toggle functionality.

## Multilingual Support

The component supports multilingual labels using Laravel's translation system:
```php
{{ __('Download') }}
{{ __('Toggle Fullscreen') }}
{{ __('No files to display') }}
```

Add translations in:
- `lang/en/messages.php`
- `lang/fr/messages.php`
- `lang/ar/messages.php`

## Future Enhancements

Potential improvements for future versions:
- Video file support
- Zoom in/out for images
- Image rotation
- Print functionality
- Annotations/comments
- Batch download for multiple files
- Share functionality

## Version History

### v1.0.0 (2026-01-11)
- Initial release
- Image carousel with Swiper.js
- PDF viewer
- Document viewer
- Glassmorphic design
- Light/dark mode support
- Fullscreen mode
- Download functionality
