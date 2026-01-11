# File Upload Component - Quick Reference

## Component Location
`/resources/views/components/file-upload.blade.php`

## Basic Syntax

```blade
<x-file-upload
    name="field_name"
    label="Label Text"
    accept="file_types"
    :currentFile="$variable"
    required
    maxSize="10MB"
/>
```

## Props Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `name` | string | 'file' | Input field name |
| `label` | string | null | Label text |
| `required` | bool | false | Required field |
| `currentFile` | string | null | Current file URL (for edit forms) |
| `accept` | string | 'image/*,.pdf,.doc,.docx,.odt,.txt' | Accepted file types |
| `error` | string | null | Custom error message |
| `maxSize` | string | '10MB' | Max size display text |

## File Type Presets

### Images Only
```blade
accept="image/*"
```

### PDFs Only
```blade
accept="application/pdf"
```

### Documents Only
```blade
accept=".doc,.docx,.odt,.txt"
```

### Specific Image Types
```blade
accept="image/jpeg,image/png,image/jpg,image/webp"
```

### Mixed Types
```blade
accept="image/*,.pdf,.doc,.docx"
```

## Common Use Cases

### 1. Avatar Upload (Create)
```blade
<x-file-upload
    name="avatar"
    label="{{ __('Profile Picture') }}"
    accept="image/*"
    maxSize="2MB"
/>
```

### 2. Avatar Upload (Edit)
```blade
<x-file-upload
    name="avatar"
    label="{{ __('Profile Picture') }}"
    :currentFile="$user->avatar ? asset('storage/' . $user->avatar) : null"
    accept="image/*"
    maxSize="2MB"
/>
```

### 3. PDF Upload
```blade
<x-file-upload
    name="pdf_file"
    label="{{ __('Upload PDF') }}"
    accept="application/pdf"
    required
    maxSize="10MB"
/>
```

### 4. Optional Document
```blade
<x-file-upload
    name="attachment"
    label="{{ __('Attachment') }}"
    accept=".pdf,.doc,.docx"
    maxSize="10MB"
/>
```

## Controller Validation

### Image Validation
```php
'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
```

### PDF Validation
```php
'pdf_file' => 'required|file|mimes:pdf|max:10240',
```

### Document Validation
```php
'document' => 'nullable|file|mimes:pdf,doc,docx,odt,txt|max:10240',
```

## Controller Storage

### Store New File
```php
if ($request->hasFile('avatar')) {
    $path = $request->file('avatar')->store('avatars', 'public');
    $model->avatar = $path;
}
```

### Replace Existing File
```php
if ($request->hasFile('avatar')) {
    // Delete old
    if ($model->avatar) {
        Storage::disk('public')->delete($model->avatar);
    }
    // Store new
    $model->avatar = $request->file('avatar')->store('avatars', 'public');
}
```

## Form Requirements

### Essential: Add enctype
```blade
<form method="POST" action="..." enctype="multipart/form-data">
```

## Display Uploaded Files

### Image
```blade
@if($user->avatar)
    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
@endif
```

### PDF Link
```blade
@if($publication->pdf_path)
    <a href="{{ asset('storage/' . $publication->pdf_path) }}" target="_blank">
        {{ __('Download PDF') }}
    </a>
@endif
```

## AlpineJS State (Available in Component)

- `fileName` - Current file name
- `fileSize` - Formatted file size
- `fileType` - File type (image, pdf, document)
- `previewUrl` - Preview URL for images
- `isDragging` - Drag state

## Styling Classes

### Container
- `glass-card` - Glassmorphic card
- `rounded-xl` - Rounded corners
- `border-dashed` - Dashed border

### Colors
- `accent-violet` - Primary accent
- `accent-amber` - Secondary accent
- `accent-rose` - Errors & PDF icon
- `accent-cyan` - Document icon

## Troubleshooting

### Preview not showing?
- Check AlpineJS is loaded in layout
- Check browser console for errors

### Upload failing?
- Verify `enctype="multipart/form-data"` on form
- Check PHP upload limits
- Validate file size server-side

### Storage link broken?
```bash
php artisan storage:link
```

## File Size Limits

| Size | Bytes |
|------|-------|
| 1MB  | 1024  |
| 2MB  | 2048  |
| 5MB  | 5120  |
| 10MB | 10240 |

## MIME Types Reference

### Images
- `image/*` - All images
- `image/jpeg` - JPEG
- `image/png` - PNG
- `image/gif` - GIF
- `image/webp` - WebP
- `image/svg+xml` - SVG

### Documents
- `application/pdf` - PDF
- `application/msword` - DOC
- `application/vnd.openxmlformats-officedocument.wordprocessingml.document` - DOCX
- `application/vnd.oasis.opendocument.text` - ODT
- `text/plain` - TXT

## Preview Types

| File Type | Icon Color | Preview |
|-----------|------------|---------|
| Image | - | Thumbnail |
| PDF | Rose | PDF Icon |
| Document | Cyan | Document Icon |
| Other | - | Upload Icon |

## Dependencies

- Laravel 10+
- AlpineJS 3.x
- Tailwind CSS 3.x

## Example: Complete Integration

```blade
<!-- Form -->
<form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="glass-card rounded-2xl p-5 lg:p-6">
        <x-file-upload
            name="avatar"
            label="{{ __('Profile Picture') }}"
            accept="image/*"
            required
            maxSize="2MB"
        />
    </div>

    <button type="submit">{{ __('Submit') }}</button>
</form>
```

```php
// Controller
public function store(Request $request)
{
    $validated = $request->validate([
        'avatar' => 'required|image|max:2048',
    ]);

    if ($request->hasFile('avatar')) {
        $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    User::create($validated);

    return redirect()->route('users.index');
}
```

---

**Documentation:** See `file-upload-component.md` for full details
**Examples:** See `file-upload-examples.md` for usage examples
