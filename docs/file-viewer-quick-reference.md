# File Viewer Component - Quick Reference

## Basic Usage

```blade
<x-file-viewer :files="$path" />
```

## Common Examples

### Single Image
```blade
<x-file-viewer :files="$publication->image" />
```

### Multiple Images (Gallery)
```blade
<x-file-viewer
    :files="$publication->images"
    title="Publication Gallery"
/>
```

### PDF Document
```blade
<x-file-viewer
    :files="$publication->pdf_file"
    type="pdf"
    title="Research Paper"
/>
```

### With Custom Height
```blade
<x-file-viewer
    :files="$images"
    maxHeight="800px"
/>
```

### Disable Download
```blade
<x-file-viewer
    :files="$images"
    :showDownload="false"
/>
```

### Disable Fullscreen
```blade
<x-file-viewer
    :files="$images"
    :showFullscreen="false"
/>
```

## Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `files` | array\|string | required | File path(s) |
| `type` | string | 'auto' | 'auto', 'image', 'pdf', 'document' |
| `title` | string\|null | null | Header title |
| `showDownload` | boolean | true | Show download button |
| `showFullscreen` | boolean | true | Show fullscreen button |
| `maxHeight` | string | '600px' | Max viewer height |

## Supported File Types

### Images
jpg, jpeg, png, gif, svg, webp, bmp

### PDFs
pdf

### Documents
doc, docx, odt, txt, html, xml, json, csv

## Keyboard Controls

- **Arrow Left/Right**: Navigate images
- **ESC**: Exit fullscreen

## Features

- Swiper.js carousel for images
- Thumbnail navigation
- Fullscreen mode
- Download functionality
- Dark/light mode support
- RTL support (Arabic)
- Responsive design
- Auto file type detection

## Integration in Controllers

```php
// In Publication Controller
public function show(Publication $publication)
{
    return view('publications.show', [
        'publication' => $publication,
        'images' => $publication->images, // Array of image paths
    ]);
}
```

## Integration in Blade Views

```blade
@if($publication->images && count($publication->images) > 0)
    <x-file-viewer
        :files="$publication->images"
        title="{{ $publication->title }}"
        maxHeight="600px"
    />
@endif
```

## Multilingual Support

The component uses Laravel's translation system.

Translation files location:
- `resources/lang/en/file-viewer.php`
- `resources/lang/fr/file-viewer.php`
- `resources/lang/ar/file-viewer.php`

## CDN Dependencies

Automatically loaded via component:
- Swiper CSS: `https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css`
- Swiper JS: `https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js`

## Troubleshooting

### Images not showing?
```bash
php artisan storage:link
```

### Swiper not working?
Check browser console for CDN errors.

### Dark mode not working?
Ensure parent layout has dark mode toggle.

## File Location

`resources/views/components/file-viewer.blade.php`

## Documentation

Full documentation: `docs/file-viewer-component.md`
Demo page: `resources/views/components/file-viewer-demo.blade.php`
