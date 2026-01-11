# File Upload Component Documentation

## Overview
A reusable Blade component for file uploads with real-time preview functionality, built with AlpineJS and styled to match the RLMS glassmorphic design theme.

**Component Path:** `/resources/views/components/file-upload.blade.php`

## Features

### File Type Support
- **Images:** JPG, JPEG, PNG, GIF, WEBP, SVG
- **PDFs:** PDF documents
- **Documents:** DOC, DOCX, ODT, TXT

### Preview Functionality
- **Images:** Display thumbnail preview with image dimensions preserved
- **PDFs:** Show PDF icon with red/rose accent
- **Documents:** Show document icon with cyan accent

### User Experience
- Drag and drop support
- Visual feedback on drag over
- File size display
- Current file indication (for edit forms)
- Easy file removal
- Glassmorphic design matching RLMS theme
- Dark mode support
- RTL (Arabic) language support
- Responsive design

## Component Props

| Prop | Type | Default | Required | Description |
|------|------|---------|----------|-------------|
| `name` | string | 'file' | No | Input field name attribute |
| `label` | string | null | No | Label text to display above the upload area |
| `required` | boolean | false | No | Whether the field is required |
| `currentFile` | string | null | No | Path to current file (for edit scenarios) |
| `accept` | string | 'image/*,.pdf,.doc,.docx,.odt,.txt' | No | File types accepted by the input |
| `error` | string | null | No | Custom error message |
| `maxSize` | string | '10MB' | No | Maximum file size display text |

## Usage Examples

### Basic Usage (Create Form)

```blade
<x-file-upload
    name="document"
    label="Upload Document"
    required
/>
```

### With Current File (Edit Form)

```blade
<x-file-upload
    name="avatar"
    label="Profile Picture"
    :currentFile="$user->avatar"
    accept="image/*"
    required
/>
```

### Images Only

```blade
<x-file-upload
    name="photo"
    label="Event Photo"
    accept="image/jpeg,image/png,image/jpg,image/gif,image/webp"
    maxSize="5MB"
/>
```

### PDFs Only

```blade
<x-file-upload
    name="research_paper"
    label="Research Paper (PDF)"
    accept="application/pdf"
    required
/>
```

### With Custom Error

```blade
<x-file-upload
    name="certificate"
    label="Certificate Document"
    :error="$customError"
    accept=".pdf,.doc,.docx"
/>
```

### Complete Form Example

```blade
<form method="POST" action="{{ route('publications.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="glass-card rounded-2xl p-5 lg:p-6">
        <h2 class="text-lg font-semibold mb-5">{{ __('Publication Information') }}</h2>

        <div class="space-y-5">
            <!-- Title Field -->
            <div>
                <label for="title" class="block text-sm font-medium mb-2">
                    {{ __('Title') }} <span class="text-accent-rose">*</span>
                </label>
                <input type="text" name="title" id="title" required
                    class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all">
            </div>

            <!-- File Upload Component -->
            <x-file-upload
                name="pdf_file"
                label="Publication PDF"
                accept="application/pdf"
                required
            />
        </div>
    </div>

    <div class="flex items-center justify-end gap-3 pt-6">
        <button type="submit" class="flex items-center gap-2 bg-gradient-to-r from-accent-violet to-accent-amber px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
            {{ __('Submit') }}
        </button>
    </div>
</form>
```

## Integration with Existing Forms

### Step 1: Add Component to Form
Replace the existing file input with the component:

**Before:**
```blade
<input type="file" name="avatar" accept="image/*">
```

**After:**
```blade
<x-file-upload
    name="avatar"
    label="Profile Picture"
    accept="image/*"
/>
```

### Step 2: Ensure Form Has Proper Encoding
Make sure your form has `enctype="multipart/form-data"`:

```blade
<form method="POST" action="..." enctype="multipart/form-data">
```

### Step 3: Handle File in Controller
No changes needed in controller - the component works with standard Laravel file upload:

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'avatar' => 'nullable|image|max:10240', // 10MB max
    ]);

    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        // Save $path to database
    }
}
```

## AlpineJS State Management

The component uses AlpineJS for reactive state management:

### State Variables
- `fileName`: Current file name
- `fileSize`: Formatted file size (e.g., "2.5 MB")
- `fileType`: Detected file type (image, pdf, document, unknown)
- `previewUrl`: URL for image preview
- `isDragging`: Drag-and-drop state indicator

### Key Methods
- `handleFileSelect(event)`: Processes file selection from input
- `processFile(file)`: Extracts file info and generates preview
- `getFileType(file)`: Determines file type for preview
- `formatFileSize(bytes)`: Converts bytes to human-readable format
- `removeFile()`: Clears the selected file
- `handleDragOver(event)`: Handles drag over event
- `handleDragLeave()`: Handles drag leave event
- `handleDrop(event)`: Handles file drop event

## Styling

### Design System Integration
The component uses the RLMS glassmorphic design tokens:

- **Glass Effect:** `glass` and `glass-card` classes
- **Accent Colors:**
  - Violet: Primary interactive elements
  - Amber: Hover states and highlights
  - Rose: PDF icons and errors
  - Cyan: Document icons

### Dark Mode
Fully supports dark mode with appropriate color adjustments using Tailwind's `dark:` variants.

### RTL Support
Automatically adjusts for Arabic (RTL) layout when needed.

## File Validation

### Client-Side
- File type filtering via `accept` attribute
- Visual file type detection

### Server-Side (Recommended)
Always validate files in your controller:

```php
$request->validate([
    'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
    'document' => 'nullable|mimes:pdf,doc,docx,odt,txt|max:10240',
    'pdf_file' => 'required|mimes:pdf|max:10240',
]);
```

## Error Handling

The component supports Laravel's validation errors automatically:

```blade
<!-- Automatic error display -->
<x-file-upload name="avatar" label="Profile Picture" />

<!-- Custom error message -->
<x-file-upload name="avatar" label="Profile Picture" :error="$customError" />
```

## Browser Compatibility

- Modern browsers with FileReader API support
- Drag-and-drop on browsers supporting HTML5 drag events
- Graceful fallback to standard file input

## Accessibility

- Proper label associations
- Screen reader support via sr-only class
- Keyboard accessible
- ARIA-compliant structure

## Troubleshooting

### Preview Not Showing
1. Ensure AlpineJS is loaded (check layout file)
2. Verify browser console for JavaScript errors
3. Check file type is supported

### File Not Uploading
1. Verify form has `enctype="multipart/form-data"`
2. Check server file upload limits (php.ini)
3. Validate file size within limits

### Styling Issues
1. Ensure Tailwind CSS is loaded
2. Check dark mode is properly configured
3. Verify glassmorphic classes are defined in app.css

## Advanced Customization

### Custom File Types
```blade
<x-file-upload
    name="custom_file"
    label="Custom File Type"
    accept=".custom,.xyz"
/>
```

### Additional Attributes
You can pass additional HTML attributes:

```blade
<x-file-upload
    name="document"
    label="Document"
    data-tracking="file-upload"
    class="custom-class"
/>
```

## Migration from Old File Inputs

### Users Form (Avatar Upload)
**File:** `/resources/views/users/create.blade.php` (Line 96-106)

**Before:**
```blade
<div class="md:col-span-2 lg:col-span-3">
    <label for="avatar" class="block text-sm font-medium mb-2">
        {{ __('Profile Picture') }}
    </label>
    <input type="file" name="avatar" id="avatar" accept="image/*"
        class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all @error('avatar') border-accent-rose @enderror">
    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">{{ __('Max size: 2MB') }}</p>
    @error('avatar')
        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
    @enderror
</div>
```

**After:**
```blade
<div class="md:col-span-2 lg:col-span-3">
    <x-file-upload
        name="avatar"
        label="{{ __('Profile Picture') }}"
        accept="image/*"
        maxSize="2MB"
    />
</div>
```

### Publications Form (PDF Upload)
**File:** `/resources/views/publications/create.blade.php` (Line 372-395)

**Before:**
```blade
<div class="glass-card rounded-2xl p-5 lg:p-6">
    <h2 class="text-lg font-semibold mb-5">{{ __('Publication File') }}</h2>

    <div class="flex justify-center px-6 pt-8 pb-8 border-2 border-dashed...">
        <!-- Complex upload UI -->
    </div>
    @error('pdf_file')
        <p class="mt-2 text-sm text-accent-rose">{{ $message }}</p>
    @enderror
</div>
```

**After:**
```blade
<div class="glass-card rounded-2xl p-5 lg:p-6">
    <h2 class="text-lg font-semibold mb-5">{{ __('Publication File') }}</h2>

    <x-file-upload
        name="pdf_file"
        accept="application/pdf"
        maxSize="10MB"
    />
</div>
```

## Performance Considerations

- File previews are generated client-side (no server requests)
- Only selected file is processed
- Efficient file size calculation
- Minimal DOM manipulation

## Security Notes

1. **Always validate server-side** - Client-side validation can be bypassed
2. **Sanitize filenames** - Use Laravel's storage methods
3. **Check MIME types** - Don't rely on extensions alone
4. **Limit file sizes** - Both client and server side
5. **Store files securely** - Use Laravel's storage system

## Support

For issues or questions:
1. Check this documentation
2. Review the component source code
3. Consult Laravel and AlpineJS documentation
4. Check browser console for errors

---

**Last Updated:** 2026-01-11
**Version:** 1.0.0
**Compatibility:** Laravel 10+, AlpineJS 3.x, Tailwind CSS 3.x
