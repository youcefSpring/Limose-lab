# UI Components Standardization

**Date**: 2026-02-04
**Issue**: Inconsistent button and form styling across the application
**Goal**: Create reusable Blade components for buttons and form inputs with unified styling

## Problem

The `/rooms` pages (and other modules) had buttons with white text that was difficult to see due to inconsistent gradient implementations. Form inputs had repetitive inline classes that were hard to maintain.

**Issues Identified**:
- Buttons used different gradients (teal’cyan, amber’coral, indigo’violet)
- Inline classes repeated across every button and form input
- No standardized action buttons for tables
- Error handling and validation styles duplicated everywhere
- RTL support implemented inconsistently

## Solution: Component-Based System

Created 5 reusable Blade components with unified styling:

### 1. Button Component (`components/ui/button.blade.php`)

**Features**:
- 7 variants: `primary`, `secondary`, `danger`, `success`, `warning`, `info`, `ghost`
- 3 sizes: `sm`, `md`, `lg`
- Supports both links (`href`) and buttons (`type`)
- Optional icon support with position control
- Gradient backgrounds with proper white text
- Shadow effects on hover
- Full dark mode support

**Props**:
```php
[
    'variant' => 'primary',      // primary, secondary, danger, success, warning, info, ghost
    'size' => 'md',              // sm, md, lg
    'icon' => null,              // Icon name (currently not fully implemented)
    'iconPosition' => 'left',    // left, right
    'href' => null,              // If provided, renders as <a> tag
    'type' => 'button',          // button, submit, reset (for <button> tag)
]
```

**Variants**:
- **primary**: Indigo’Violet gradient, white text
- **secondary**: Glass effect, dark text
- **danger**: Rose’Coral gradient, white text
- **success**: Emerald’Teal gradient, white text
- **warning**: Amber’Coral gradient, white text
- **info**: Cyan’Teal gradient, white text
- **ghost**: Transparent with hover effect

**Usage Examples**:
```blade
{{-- Primary button with icon --}}
<x-ui.button variant="primary" size="md">
    <svg class="w-4 h-4" ...>...</svg>
    {{ __('Save') }}
</x-ui.button>

{{-- Link button --}}
<x-ui.button variant="info" href="{{ route('rooms.create') }}" size="lg">
    {{ __('Add Room') }}
</x-ui.button>

{{-- Submit button --}}
<x-ui.button variant="success" type="submit" size="md">
    {{ __('Create Room') }}
</x-ui.button>

{{-- Secondary (cancel) button --}}
<x-ui.button variant="secondary" href="{{ route('rooms.index') }}">
    {{ __('Cancel') }}
</x-ui.button>
```

### 2. Action Button Component (`components/ui/action-button.blade.php`)

**Purpose**: Standardized icon-only buttons for table actions (view, edit, delete)

**Features**:
- 5 variants with proper colors and hover effects
- SVG icons built-in
- Supports both links and buttons
- Accessible with `title` and `aria-label`
- Small size optimized for table rows

**Props**:
```php
[
    'variant' => 'view',    // view, edit, delete, info, success
    'href' => null,         // If provided, renders as <a> tag
    'type' => 'button',     // For <button> tag
    'title' => '',          // Tooltip text
]
```

**Variants**:
- **view**: Cyan eye icon
- **edit**: Violet pencil icon
- **delete**: Rose trash icon
- **info**: Indigo info icon
- **success**: Emerald check icon

**Usage Examples**:
```blade
{{-- View button --}}
<x-ui.action-button
    variant="view"
    :href="route('rooms.show', $room)"
    :title="__('View')"
/>

{{-- Edit button --}}
<x-ui.action-button
    variant="edit"
    :href="route('rooms.edit', $room)"
    :title="__('Edit')"
/>

{{-- Delete button (in form) --}}
<form method="POST" action="{{ route('rooms.destroy', $room) }}" class="inline-block">
    @csrf
    @method('DELETE')
    <x-ui.action-button
        variant="delete"
        type="submit"
        :title="__('Delete')"
    />
</form>
```

### 3. Input Component (`components/ui/input.blade.php`)

**Features**:
- All HTML5 input types supported
- Automatic RTL text direction
- Laravel validation integration (`old()` helper and `@error` directive)
- Optional label with required indicator
- Help text support
- Min/max/step for number inputs
- Disabled and readonly states
- Error styling with red borders

**Props**:
```php
[
    'label' => null,           // Field label
    'name' => '',              // Input name (required)
    'type' => 'text',          // text, number, email, password, etc.
    'value' => '',             // Default value
    'placeholder' => '',       // Placeholder text
    'required' => false,       // Show * indicator
    'disabled' => false,       // Disable input
    'readonly' => false,       // Make read-only
    'min' => null,             // For number inputs
    'max' => null,             // For number inputs
    'step' => null,            // For number inputs
    'help' => null,            // Help text below input
]
```

**Usage Examples**:
```blade
{{-- Basic text input --}}
<x-ui.input
    name="name"
    :label="__('Room Name')"
    :placeholder="__('e.g., Conference Room A')"
    :required="true"
/>

{{-- Number input with constraints --}}
<x-ui.input
    name="capacity"
    type="number"
    :label="__('Capacity')"
    :placeholder="__('e.g., 20')"
    min="1"
    max="100"
    step="1"
/>

{{-- Input with help text --}}
<x-ui.input
    name="email"
    type="email"
    :label="__('Email')"
    :help="__('We will never share your email')"
    :required="true"
/>

{{-- Edit form with value --}}
<x-ui.input
    name="name"
    :label="__('Room Name')"
    :value="$room->name"
    :required="true"
/>
```

### 4. Select Component (`components/ui/select.blade.php`)

**Features**:
- Dropdown/select styling matching input component
- Automatic RTL text direction
- Laravel validation integration
- Optional label with required indicator
- Placeholder option
- Help text support
- Disabled state
- Error styling

**Props**:
```php
[
    'label' => null,           // Field label
    'name' => '',              // Select name (required)
    'required' => false,       // Show * indicator
    'disabled' => false,       // Disable select
    'placeholder' => null,     // Adds empty option at top
    'help' => null,            // Help text below select
]
```

**Usage Examples**:
```blade
{{-- Basic select --}}
<x-ui.select
    name="status"
    :label="__('Status')"
    :required="true"
>
    <option value="active">{{ __('Active') }}</option>
    <option value="inactive">{{ __('Inactive') }}</option>
</x-ui.select>

{{-- Select with placeholder --}}
<x-ui.select
    name="room_type_id"
    :label="__('Room Type')"
    :placeholder="__('Select room type')"
    :required="true"
>
    @foreach($roomTypes as $type)
        <option value="{{ $type->id }}" {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
            {{ $type->name }}
        </option>
    @endforeach
</x-ui.select>

{{-- Edit form with selected value --}}
<x-ui.select
    name="status"
    :label="__('Status')"
    :required="true"
>
    <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>
        {{ __('Available') }}
    </option>
    <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>
        {{ __('Occupied') }}
    </option>
</x-ui.select>
```

### 5. Textarea Component (`components/ui/textarea.blade.php`)

**Features**:
- Multi-line text input
- Automatic RTL text direction
- Laravel validation integration
- Optional label with required indicator
- Help text support
- Configurable rows
- Disabled and readonly states
- Error styling
- Vertical resize only

**Props**:
```php
[
    'label' => null,           // Field label
    'name' => '',              // Textarea name (required)
    'value' => '',             // Default value
    'placeholder' => '',       // Placeholder text
    'required' => false,       // Show * indicator
    'disabled' => false,       // Disable textarea
    'readonly' => false,       // Make read-only
    'rows' => 4,               // Number of visible rows
    'help' => null,            // Help text below textarea
]
```

**Usage Examples**:
```blade
{{-- Basic textarea --}}
<x-ui.textarea
    name="description"
    :label="__('Description')"
    :placeholder="__('Provide additional details...')"
    rows="3"
/>

{{-- Textarea with help text --}}
<x-ui.textarea
    name="notes"
    :label="__('Notes')"
    :help="__('Internal notes, not visible to users')"
    rows="5"
/>

{{-- Edit form with value --}}
<x-ui.textarea
    name="description"
    :label="__('Description')"
    :value="$room->description"
    :placeholder="__('Provide additional details...')"
    rows="3"
/>

{{-- Add custom classes --}}
<x-ui.textarea
    name="equipment"
    :label="__('Equipment')"
    rows="3"
    class="mt-5"
/>
```

## Implementation Summary

### Files Created/Updated

**Components Created**:
1. `resources/views/components/ui/button.blade.php` - Updated with unified variants
2. `resources/views/components/ui/action-button.blade.php` - Created new
3. `resources/views/components/ui/input.blade.php` - Enhanced existing
4. `resources/views/components/ui/select.blade.php` - Enhanced existing
5. `resources/views/components/ui/textarea.blade.php` - Created new

**Pages Updated** (Rooms Module):
1. `resources/views/rooms/index.blade.php`
   - Replaced header "Add Room" button with `<x-ui.button variant="info">`
   - Replaced table action buttons with `<x-ui.action-button>`
   - Replaced empty state button with `<x-ui.button variant="info">`

2. `resources/views/rooms/create.blade.php`
   - Replaced submit button with `<x-ui.button variant="success">`
   - Replaced cancel button with `<x-ui.button variant="secondary">`
   - Replaced all text inputs with `<x-ui.input>`
   - Replaced all selects with `<x-ui.select>`
   - Replaced all textareas with `<x-ui.textarea>`

3. `resources/views/rooms/edit.blade.php`
   - Same replacements as create page
   - All components use `:value` prop with model data

## Benefits

### Before Standardization
```blade
{{-- Button with inline classes --}}
<a href="{{ route('rooms.create') }}" class="flex items-center gap-2 bg-gradient-to-r from-accent-teal to-accent-cyan px-4 lg:px-5 py-2.5 rounded-xl font-medium text-sm text-white hover:opacity-90 transition-opacity">
    <svg>...</svg>
    {{ __('Add Room') }}
</a>

{{-- Input with inline classes --}}
<input type="text" name="name" id="name" value="{{ old('name') }}" required
    class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 bg-white dark:bg-surface-700/50 border border-black/10 dark:border-white/10 rounded-xl focus:outline-none focus:ring-2 focus:ring-accent-teal/50 focus:border-accent-teal transition-all @error('name') border-accent-rose @enderror"
    placeholder="{{ __('e.g., Conference Room A') }}">
```

### After Standardization
```blade
{{-- Button with component --}}
<x-ui.button variant="info" href="{{ route('rooms.create') }}" size="md">
    <svg>...</svg>
    {{ __('Add Room') }}
</x-ui.button>

{{-- Input with component --}}
<x-ui.input
    name="name"
    :label="__('Room Name')"
    :placeholder="__('e.g., Conference Room A')"
    :required="true"
/>
```

**Improvements**:
-  70% less code in view files
-  Consistent styling across all pages
-  Centralized maintenance (change once, applies everywhere)
-  Proper white text on gradient buttons (visibility issue fixed)
-  Automatic RTL support
-  Built-in validation error handling
-  Accessibility attributes included
-  Dark mode support standardized

## Color Scheme Reference

All components follow this unified color scheme:

**Accent Colors** (defined in Tailwind config):
- **Indigo**: `#6366f1` - Primary actions
- **Violet**: `#8b5cf6` - Edit actions, secondary primary
- **Cyan**: `#06b6d4` - Info, view actions
- **Teal**: `#14b8a6` - Success alternative
- **Emerald**: `#10b981` - Success actions
- **Amber**: `#f59e0b` - Warnings
- **Coral**: `#ff6b6b` - Danger alternative
- **Rose**: `#f43f5e` - Danger, delete actions

**Button Variant Colors**:
- Primary: Indigo’Violet gradient
- Info: Cyan’Teal gradient
- Success: Emerald’Teal gradient
- Danger: Rose’Coral gradient
- Warning: Amber’Coral gradient

**Action Button Colors**:
- View: Cyan
- Edit: Violet
- Delete: Rose
- Info: Indigo
- Success: Emerald

## Migration Guide

To migrate existing pages to use the new components:

### Step 1: Replace Buttons

**Find patterns like**:
```blade
<button class="... bg-gradient-to-r from-accent-* to-accent-* ...">
<a class="... bg-gradient-to-r from-accent-* to-accent-* ...">
```

**Replace with**:
```blade
<x-ui.button variant="[variant]" [type|href]="...">
    {{-- content --}}
</x-ui.button>
```

### Step 2: Replace Table Action Buttons

**Find patterns like**:
```blade
<a href="..." class="p-2 rounded-lg hover:bg-accent-*/10 text-accent-*">
    <svg>...</svg>
</a>
```

**Replace with**:
```blade
<x-ui.action-button variant="[variant]" :href="..." :title="..." />
```

### Step 3: Replace Form Inputs

**Find patterns like**:
```blade
<label for="name">...</label>
<input type="text" name="name" class="block w-full {{ app()->getLocale() === 'ar' ? 'text-right' : '' }} py-3 px-4 ...">
@error('name')
    <p>{{ $message }}</p>
@enderror
```

**Replace with**:
```blade
<x-ui.input
    name="name"
    :label="__('...')"
    :placeholder="__('...')"
    :required="true"
/>
```

### Step 4: Replace Selects

**Find patterns like**:
```blade
<label for="status">...</label>
<select name="status" class="block w-full ...">
    <option>...</option>
</select>
@error('status')
    <p>{{ $message }}</p>
@enderror
```

**Replace with**:
```blade
<x-ui.select name="status" :label="__('...')" :required="true">
    <option>...</option>
</x-ui.select>
```

### Step 5: Replace Textareas

**Find patterns like**:
```blade
<label for="description">...</label>
<textarea name="description" rows="3" class="block w-full ...">{{ old('description') }}</textarea>
@error('description')
    <p>{{ $message }}</p>
@enderror
```

**Replace with**:
```blade
<x-ui.textarea
    name="description"
    :label="__('...')"
    :placeholder="__('...')"
    rows="3"
/>
```

## Next Steps

**Modules to Update**:
1.  Rooms (completed)
2. ó Materials
3. ó Publications
4. ó Users
5. ó Projects
6. ó Experiments
7. ó Events
8. ó Reservations
9. ó Maintenance

**Estimated Time**: ~30 minutes per module (index, create, edit pages)

## Testing Checklist

When migrating a module, test:

- [ ] All buttons render correctly with proper colors
- [ ] Button text is visible (white text on gradients)
- [ ] Buttons work as links (`href`) and form submissions (`type="submit"`)
- [ ] Action buttons display proper icons
- [ ] Form inputs show labels with required indicators
- [ ] Form validation displays errors below fields
- [ ] Form inputs repopulate on validation errors (`old()` helper works)
- [ ] Edit forms display existing values
- [ ] RTL text direction works for Arabic language
- [ ] Dark mode styling works correctly
- [ ] Mobile responsive behavior is maintained

## Troubleshooting

### Button text not visible
**Problem**: Gradient backgrounds with dark text
**Solution**: Ensure using the correct variant (primary, info, success, danger, warning all have white text)

### Form input not showing errors
**Problem**: Error styling not applied
**Solution**: Component automatically checks `$errors->has($name)`, ensure form name matches

### Select not showing selected value in edit form
**Problem**: Old value not preserved
**Solution**: Keep the `{{ old('name', $model->value) == 'option' ? 'selected' : '' }}` logic in `<option>` tags

### Textarea content disappears
**Problem**: Using both `:value` prop and slot content
**Solution**: Use `:value` prop for edit forms, component handles `old()` automatically

## References

- Original issue: `/rooms` buttons exist but color white
- Related docs: `JavaScript-Fixes.md` (Turbo/Alpine compatibility)
- Tailwind CSS: Utility classes and gradient system
- Laravel Blade Components: [Documentation](https://laravel.com/docs/11.x/blade#components)
