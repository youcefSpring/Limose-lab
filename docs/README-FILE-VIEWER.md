# File Viewer Component - README

## Quick Start Guide

### Installation Complete!
The File Viewer Component has been successfully installed in your RLMS project.

---

## What Was Created?

### 12 Files Total (75KB)

#### Core Component (1 file)
- **file-viewer.blade.php** - Main component (22KB, 468 lines)

#### Support Files (2 files)
- **file-viewer-demo.blade.php** - Demo page with examples (19KB)
- **file-viewer-test.blade.php** - Test page (4.6KB)

#### Translations (3 files)
- **en/file-viewer.php** - English (473 bytes)
- **fr/file-viewer.php** - French (541 bytes)
- **ar/file-viewer.php** - Arabic (583 bytes)

#### Documentation (6 files)
- **README-FILE-VIEWER.md** - This file
- **FILE-VIEWER-SUMMARY.md** - Complete summary (11KB)
- **IMPLEMENTATION-FILE-VIEWER.md** - Implementation guide (15KB)
- **file-viewer-component.md** - Full documentation (8.9KB)
- **file-viewer-quick-reference.md** - Quick reference (3.1KB)
- **file-viewer-usage-examples.md** - Usage examples (21KB)
- **file-viewer-routes-example.php** - Example routes (5.3KB)
- **FILE-VIEWER-FILE-TREE.txt** - File structure (3.3KB)

---

## First Steps

### 1. Link Storage (Required)
```bash
cd /home/charikatec/Desktop/my\ docs/labo/rlms
php artisan storage:link
```

### 2. Add Demo Route (Optional)
Add to `routes/web.php`:
```php
Route::get('/demo/file-viewer', function () {
    return view('components.file-viewer-demo');
})->name('file-viewer.demo');
```

### 3. Visit Demo Page
```
http://your-app.test/demo/file-viewer
```

---

## Usage in 30 Seconds

### Single Image
```blade
<x-file-viewer :files="'storage/image.jpg'" />
```

### Gallery
```blade
<x-file-viewer :files="['image1.jpg', 'image2.jpg', 'image3.jpg']" />
```

### PDF
```blade
<x-file-viewer :files="'storage/document.pdf'" type="pdf" />
```

That's it!

---

## Documentation Guide

### Start Here
1. **Quick Reference** - `/docs/file-viewer-quick-reference.md`
   - Basic usage patterns
   - Props reference
   - Copy-paste examples

### Going Deeper
2. **Usage Examples** - `/docs/file-viewer-usage-examples.md`
   - Real-world examples
   - Module integration (Publications, Events, etc.)
   - Advanced patterns

3. **Full Documentation** - `/docs/file-viewer-component.md`
   - Complete feature list
   - All configuration options
   - Browser support
   - Troubleshooting

### Implementation
4. **Implementation Guide** - `/docs/IMPLEMENTATION-FILE-VIEWER.md`
   - Installation steps
   - Controller integration
   - Database examples
   - Security considerations

### Reference
5. **Summary** - `/docs/FILE-VIEWER-SUMMARY.md`
   - Overview of all files
   - Feature checklist
   - Testing guide

---

## Common Use Cases

### Publications Module
```blade
{{-- Show publication with images and PDF --}}
<x-file-viewer
    :files="$publication->images"
    title="{{ $publication->title }}"
/>

<x-file-viewer
    :files="$publication->pdf_file"
    type="pdf"
    title="Full Paper"
/>
```

### Events Module
```blade
{{-- Event gallery --}}
<x-file-viewer
    :files="$event->images"
    title="Event Gallery"
/>
```

### Materials Module
```blade
{{-- Material image and manual --}}
<x-file-viewer :files="$material->image" />
<x-file-viewer :files="$material->manual_pdf" type="pdf" />
```

### Projects Module
```blade
{{-- Project documentation --}}
<x-file-viewer :files="$project->documents" />
```

---

## Features Overview

### Image Viewer
- Swiper.js carousel
- Thumbnail navigation
- Fullscreen mode
- Keyboard controls (arrows, ESC)
- Touch/swipe gestures
- Download button

### PDF Viewer
- Embedded iframe
- Scrollable preview
- Download button

### Document Viewer
- Preview for text files
- Download for all formats
- Auto file type detection

### Design
- Glassmorphic theme
- Light/dark mode
- RTL support (Arabic)
- Fully responsive
- RLMS color scheme

---

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `files` | array\|string | required | File path(s) |
| `type` | string | 'auto' | 'auto', 'image', 'pdf', 'document' |
| `title` | string | null | Header title |
| `showDownload` | boolean | true | Show download button |
| `showFullscreen` | boolean | true | Show fullscreen button |
| `maxHeight` | string | '600px' | Max viewer height |

---

## Supported File Types

### Images
jpg, jpeg, png, gif, svg, webp, bmp

### PDFs
pdf

### Documents
doc, docx, odt, txt, html, xml, json, csv

---

## Keyboard Shortcuts

- **→** Next image
- **←** Previous image
- **ESC** Exit fullscreen

---

## Examples by Module

### Publications
```blade
<x-file-viewer
    :files="$publication->images"
    title="{{ $publication->title }}"
    maxHeight="600px"
/>
```

### Events
```blade
<x-file-viewer
    :files="$event->gallery"
    type="image"
/>
```

### Projects
```blade
<x-file-viewer
    :files="$project->documents"
    :showDownload="true"
/>
```

### Materials
```blade
<x-file-viewer
    :files="$material->image"
    maxHeight="400px"
/>
```

---

## Troubleshooting

### Images not showing?
```bash
php artisan storage:link
chmod -R 775 storage/
```

### Swiper not working?
Check browser console for CDN errors.

### Dark mode not working?
Verify `app.blade.php` has dark mode toggle.

---

## Next Steps

### 1. Test the Component
Visit: `/demo/file-viewer`

### 2. Integrate into Your Views
Start with Publications or Events module

### 3. Customize as Needed
Adjust props for your use case

### 4. Review Documentation
Read full docs for advanced features

---

## File Locations

### Component
```
resources/views/components/file-viewer.blade.php
```

### Translations
```
resources/lang/en/file-viewer.php
resources/lang/fr/file-viewer.php
resources/lang/ar/file-viewer.php
```

### Documentation
```
docs/README-FILE-VIEWER.md (this file)
docs/file-viewer-quick-reference.md
docs/file-viewer-usage-examples.md
docs/file-viewer-component.md
docs/IMPLEMENTATION-FILE-VIEWER.md
docs/FILE-VIEWER-SUMMARY.md
```

---

## CDN Dependencies

Auto-loaded via `@push`:
- Swiper CSS: `https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css`
- Swiper JS: `https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js`

---

## Browser Support

- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers

---

## Need Help?

1. **Quick Reference**: `/docs/file-viewer-quick-reference.md`
2. **Usage Examples**: `/docs/file-viewer-usage-examples.md`
3. **Full Documentation**: `/docs/file-viewer-component.md`
4. **Implementation**: `/docs/IMPLEMENTATION-FILE-VIEWER.md`

---

## Version

**v1.0.0** - Released 2026-01-11

---

## Credits

- Swiper.js - https://swiperjs.com/
- AlpineJS - https://alpinejs.dev/
- Tailwind CSS - https://tailwindcss.com/

---

## License

Part of the RLMS (Research Laboratory Management System) project.

---

**Happy coding!**
