# File Upload Component - Usage Examples

This document provides practical examples of integrating the file-upload component into RLMS forms.

## Table of Contents
1. [User Avatar Upload](#user-avatar-upload)
2. [Publication PDF Upload](#publication-pdf-upload)
3. [Material Image Upload](#material-image-upload)
4. [Experiment Document Upload](#experiment-document-upload)
5. [Multiple File Types](#multiple-file-types)

---

## 1. User Avatar Upload

### Create Form (`users/create.blade.php`)

Replace lines 96-106 with:

```blade
<!-- Avatar -->
<div class="md:col-span-2 lg:col-span-3">
    <x-file-upload
        name="avatar"
        label="{{ __('Profile Picture') }}"
        accept="image/*"
        maxSize="2MB"
    />
</div>
```

### Edit Form (`users/edit.blade.php`)

Replace the avatar upload section with:

```blade
<!-- Avatar -->
<div class="md:col-span-2 lg:col-span-3">
    <x-file-upload
        name="avatar"
        label="{{ __('Profile Picture') }}"
        :currentFile="$user->avatar ? asset('storage/' . $user->avatar) : null"
        accept="image/*"
        maxSize="2MB"
    />
</div>
```

### Controller Validation

```php
// app/Http/Controllers/UserController.php

public function store(StoreUserRequest $request)
{
    $validated = $request->validated();

    if ($request->hasFile('avatar')) {
        $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    $user = User::create($validated);
    // ... rest of the code
}

public function update(UpdateUserRequest $request, User $user)
{
    $validated = $request->validated();

    if ($request->hasFile('avatar')) {
        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }
        $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
    }

    $user->update($validated);
    // ... rest of the code
}
```

---

## 2. Publication PDF Upload

### Create Form (`publications/create.blade.php`)

Replace lines 372-395 with:

```blade
<!-- PDF Upload Section -->
<div class="glass-card rounded-2xl p-5 lg:p-6">
    <h2 class="text-lg font-semibold mb-5">{{ __('Publication File') }}</h2>

    <x-file-upload
        name="pdf_file"
        accept="application/pdf"
        maxSize="10MB"
    />
</div>
```

### Edit Form (`publications/edit.blade.php`)

```blade
<!-- PDF Upload Section -->
<div class="glass-card rounded-2xl p-5 lg:p-6">
    <h2 class="text-lg font-semibold mb-5">{{ __('Publication File') }}</h2>

    <x-file-upload
        name="pdf_file"
        :currentFile="$publication->pdf_path ? asset('storage/' . $publication->pdf_path) : null"
        accept="application/pdf"
        maxSize="10MB"
    />
</div>
```

### Controller Example

```php
// app/Http/Controllers/PublicationController.php

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:500',
        'pdf_file' => 'nullable|file|mimes:pdf|max:10240', // 10MB
        // ... other fields
    ]);

    if ($request->hasFile('pdf_file')) {
        $validated['pdf_path'] = $request->file('pdf_file')->store('publications', 'public');
    }

    $publication = Publication::create($validated);

    return redirect()->route('publications.index')
        ->with('success', __('Publication created successfully'));
}
```

---

## 3. Material Image Upload

### Create Form (`materials/create.blade.php`)

```blade
<div class="glass-card rounded-2xl p-5 lg:p-6">
    <h2 class="text-lg font-semibold mb-5">{{ __('Material Image') }}</h2>

    <x-file-upload
        name="image"
        label="{{ __('Upload Material Image') }}"
        accept="image/jpeg,image/png,image/jpg,image/webp"
        maxSize="5MB"
    />
</div>
```

### Edit Form (`materials/edit.blade.php`)

```blade
<div class="glass-card rounded-2xl p-5 lg:p-6">
    <h2 class="text-lg font-semibold mb-5">{{ __('Material Image') }}</h2>

    <x-file-upload
        name="image"
        label="{{ __('Upload Material Image') }}"
        :currentFile="$material->image_path ? asset('storage/' . $material->image_path) : null"
        accept="image/jpeg,image/png,image/jpg,image/webp"
        maxSize="5MB"
    />

    @if($material->image_path)
        <div class="mt-4 flex items-center gap-3">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remove_image" value="1"
                    class="w-4 h-4 text-accent-rose border-gray-300 rounded focus:ring-accent-rose">
                <span class="text-sm text-accent-rose">{{ __('Remove current image') }}</span>
            </label>
        </div>
    @endif
</div>
```

---

## 4. Experiment Document Upload

### Complete Form Example

```blade
<x-app-layout>
    <header class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 lg:mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold">{{ __('Add Experiment') }}</h1>
            <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-1">{{ __('Record a new experiment') }}</p>
        </div>
    </header>

    <form method="POST" action="{{ route('experiments.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-lg font-semibold mb-5">{{ __('Basic Information') }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="title" class="block text-sm font-medium mb-2">
                        {{ __('Title') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="text" name="title" id="title" required
                        class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all">
                </div>

                <div>
                    <label for="date" class="block text-sm font-medium mb-2">
                        {{ __('Date') }} <span class="text-accent-rose">*</span>
                    </label>
                    <input type="date" name="date" id="date" required
                        class="block w-full py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-violet/50 focus:border-accent-violet transition-all">
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="glass-card rounded-2xl p-5 lg:p-6">
            <h2 class="text-lg font-semibold mb-5">{{ __('Experiment Documentation') }}</h2>

            <div class="space-y-5">
                <!-- Protocol Document -->
                <x-file-upload
                    name="protocol_document"
                    label="{{ __('Protocol Document') }}"
                    accept=".pdf,.doc,.docx,.txt"
                    maxSize="10MB"
                />

                <!-- Results Document -->
                <x-file-upload
                    name="results_document"
                    label="{{ __('Results Document') }}"
                    accept=".pdf,.doc,.docx,.txt"
                    maxSize="10MB"
                />

                <!-- Supporting Images -->
                <x-file-upload
                    name="supporting_image"
                    label="{{ __('Supporting Image') }}"
                    accept="image/*"
                    maxSize="5MB"
                />
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('experiments.index') }}"
                class="px-5 py-2.5 rounded-xl glass hover:glass-card text-sm font-medium transition-all">
                {{ __('Cancel') }}
            </a>
            <button type="submit"
                class="flex items-center gap-2 bg-gradient-to-r from-accent-violet to-accent-amber px-6 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ __('Create Experiment') }}
            </button>
        </div>
    </form>
</x-app-layout>
```

---

## 5. Multiple File Types

### Event Form with Multiple Upload Types

```blade
<div class="glass-card rounded-2xl p-5 lg:p-6">
    <h2 class="text-lg font-semibold mb-5">{{ __('Event Media') }}</h2>

    <div class="space-y-5">
        <!-- Event Poster (Image Required) -->
        <x-file-upload
            name="poster"
            label="{{ __('Event Poster') }}"
            accept="image/*"
            required
            maxSize="5MB"
        />

        <!-- Event Program (PDF Optional) -->
        <x-file-upload
            name="program"
            label="{{ __('Event Program (PDF)') }}"
            accept="application/pdf"
            maxSize="10MB"
        />

        <!-- Supporting Documents (Any Document) -->
        <x-file-upload
            name="supporting_doc"
            label="{{ __('Supporting Documents') }}"
            accept=".pdf,.doc,.docx,.odt,.txt"
            maxSize="10MB"
        />
    </div>
</div>
```

---

## Common Patterns

### Pattern 1: Required Image Upload

```blade
<x-file-upload
    name="featured_image"
    label="{{ __('Featured Image') }}"
    accept="image/*"
    required
    maxSize="5MB"
/>
```

### Pattern 2: Optional PDF with Current File

```blade
<x-file-upload
    name="attachment"
    label="{{ __('Attachment') }}"
    :currentFile="$model->attachment_path ?? null"
    accept="application/pdf"
    maxSize="10MB"
/>
```

### Pattern 3: Multiple Accepted Types

```blade
<x-file-upload
    name="document"
    label="{{ __('Document') }}"
    accept="image/*,.pdf,.doc,.docx"
    maxSize="10MB"
/>
```

### Pattern 4: With Custom Error Handling

```blade
<x-file-upload
    name="certificate"
    label="{{ __('Certificate') }}"
    :error="session('certificate_error')"
    accept=".pdf"
    required
    maxSize="5MB"
/>
```

---

## Validation Examples

### Image Validation

```php
$request->validate([
    'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
    'poster' => 'required|image|max:5120', // 5MB
]);
```

### PDF Validation

```php
$request->validate([
    'pdf_file' => 'nullable|file|mimes:pdf|max:10240', // 10MB
]);
```

### Document Validation

```php
$request->validate([
    'document' => 'required|file|mimes:pdf,doc,docx,odt,txt|max:10240',
]);
```

### Multiple Types Validation

```php
$request->validate([
    'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:10240',
]);
```

---

## Storage Examples

### Store File

```php
if ($request->hasFile('avatar')) {
    $path = $request->file('avatar')->store('avatars', 'public');
    $model->avatar = $path;
}
```

### Store with Custom Name

```php
if ($request->hasFile('document')) {
    $filename = time() . '_' . $request->file('document')->getClientOriginalName();
    $path = $request->file('document')->storeAs('documents', $filename, 'public');
    $model->document_path = $path;
}
```

### Replace Existing File

```php
if ($request->hasFile('image')) {
    // Delete old file
    if ($model->image_path && Storage::disk('public')->exists($model->image_path)) {
        Storage::disk('public')->delete($model->image_path);
    }
    // Store new file
    $model->image_path = $request->file('image')->store('images', 'public');
}
```

---

## Display Uploaded Files

### In Blade Views

```blade
@if($user->avatar)
    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
        class="w-32 h-32 rounded-full object-cover">
@endif

@if($publication->pdf_path)
    <a href="{{ asset('storage/' . $publication->pdf_path) }}" target="_blank"
        class="flex items-center gap-2 text-accent-violet hover:text-accent-amber">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        {{ __('Download PDF') }}
    </a>
@endif
```

---

## Testing

### Feature Test Example

```php
// tests/Feature/UserAvatarUploadTest.php

public function test_user_can_upload_avatar()
{
    Storage::fake('public');

    $file = UploadedFile::fake()->image('avatar.jpg', 600, 600);

    $response = $this->post(route('users.store'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'avatar' => $file,
        // ... other required fields
    ]);

    $response->assertRedirect(route('users.index'));

    Storage::disk('public')->assertExists('avatars/' . $file->hashName());
}

public function test_avatar_upload_validates_file_type()
{
    $file = UploadedFile::fake()->create('document.pdf', 1000);

    $response = $this->post(route('users.store'), [
        'avatar' => $file,
        // ... other fields
    ]);

    $response->assertSessionHasErrors('avatar');
}
```

---

## Troubleshooting

### Issue: Preview Not Showing

**Solution:** Check that AlpineJS is loaded:

```blade
<!-- Should be in layouts/app.blade.php -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
```

### Issue: File Upload Fails

**Solution:** Check PHP upload limits in `php.ini`:

```ini
upload_max_filesize = 10M
post_max_size = 10M
```

### Issue: Storage Link Not Working

**Solution:** Create storage link:

```bash
php artisan storage:link
```

### Issue: Old File Not Showing in Edit Form

**Solution:** Ensure you're passing the full URL:

```blade
:currentFile="$model->file ? asset('storage/' . $model->file) : null"
```

---

**Last Updated:** 2026-01-11
