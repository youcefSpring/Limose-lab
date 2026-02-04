# Blade Component Library Documentation

This document describes all reusable Blade components available in the application, following atomic design principles and the Nexus Design System with glass morphism aesthetic.

## Table of Contents

1. [UI Components](#ui-components)
   - [Button](#button)
   - [Card](#card)
   - [Badge](#badge)
   - [Input](#input)
   - [Select](#select)
   - [Delete Confirm](#delete-confirm)
   - [Page Header](#page-header)
2. [Navigation Components](#navigation-components)
   - [Breadcrumbs](#breadcrumbs)
3. [Form Components (Week 4)](#form-components)
   - [Stepper](#stepper)
   - [Step](#step)
   - [Tabs](#tabs)
   - [Tab Panel](#tab-panel)
   - [Multilingual Input](#multilingual-input)

---

## UI Components

### Button

**Component:** `<x-ui.button>`

**Location:** `resources/views/components/ui/button.blade.php`

**Purpose:** Reusable button component with multiple variants, sizes, and icon support.

#### Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `variant` | string | `'primary'` | `primary`, `secondary`, `danger`, `success`, `ghost` | Visual style variant |
| `size` | string | `'md'` | `sm`, `md`, `lg` | Button size |
| `icon` | string | `null` | Any SVG path | Optional icon to display |
| `href` | string | `null` | Any URL | If provided, renders as link instead of button |
| `type` | string | `'button'` | `button`, `submit`, `reset` | Button type attribute |

#### Variants

- **Primary:** Gradient accent background with white text
- **Secondary:** Glass morphism with border
- **Danger:** Red/rose accent for destructive actions
- **Success:** Green accent for positive actions
- **Ghost:** Transparent with hover effect

#### Size Classes

- **sm:** Smaller padding, text-sm
- **md:** Medium padding, text-sm
- **lg:** Larger padding, text-base

#### Usage Examples

```blade
{{-- Primary button --}}
<x-ui.button variant="primary">
    Save Changes
</x-ui.button>

{{-- Secondary button with icon --}}
<x-ui.button variant="secondary" icon="M12 4v16m8-8H4">
    Add New Item
</x-ui.button>

{{-- Danger button (small) --}}
<x-ui.button variant="danger" size="sm">
    Delete
</x-ui.button>

{{-- Button as link --}}
<x-ui.button variant="primary" href="{{ route('publications.create') }}">
    Create Publication
</x-ui.button>

{{-- Submit button --}}
<x-ui.button variant="primary" type="submit">
    Submit Form
</x-ui.button>
```

---

### Card

**Component:** `<x-ui.card>`

**Location:** `resources/views/components/ui/card.blade.php`

**Purpose:** Glass morphism card container with optional hover effects.

#### Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `padding` | string | `'default'` | `default`, `none`, `sm`, `lg` | Card padding size |
| `hover` | boolean | `false` | `true`, `false` | Enable hover animation |

#### Padding Options

- **default:** Standard p-6 padding
- **none:** No padding (p-0)
- **sm:** Small padding (p-4)
- **lg:** Large padding (p-8)

#### Usage Examples

```blade
{{-- Standard card --}}
<x-ui.card>
    <h3 class="text-lg font-semibold mb-2">Card Title</h3>
    <p class="text-zinc-600 dark:text-zinc-400">Card content goes here.</p>
</x-ui.card>

{{-- Card with hover effect --}}
<x-ui.card hover="true">
    <a href="{{ route('publications.show', $publication) }}">
        <h3>{{ $publication->title }}</h3>
    </a>
</x-ui.card>

{{-- Card with no padding --}}
<x-ui.card padding="none">
    <img src="image.jpg" alt="Header" class="w-full rounded-t-2xl">
    <div class="p-6">
        Content with custom padding
    </div>
</x-ui.card>
```

---

### Badge

**Component:** `<x-ui.badge>`

**Location:** `resources/views/components/ui/badge.blade.php`

**Purpose:** Status badges with color variants and optional status dots.

#### Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `variant` | string | `'default'` | `default`, `primary`, `success`, `warning`, `danger`, `info` | Badge color scheme |
| `size` | string | `'md'` | `sm`, `md`, `lg` | Badge size |
| `dot` | boolean | `false` | `true`, `false` | Show status dot indicator |

#### Variants

- **default:** Gray/zinc colors
- **primary:** Blue/indigo accent
- **success:** Green accent
- **warning:** Yellow/amber accent
- **danger:** Red/rose accent
- **info:** Cyan/teal accent

#### Usage Examples

```blade
{{-- Publication status badges --}}
<x-ui.badge variant="success">Published</x-ui.badge>
<x-ui.badge variant="warning">Pending</x-ui.badge>
<x-ui.badge variant="danger">Rejected</x-ui.badge>

{{-- Badge with status dot --}}
<x-ui.badge variant="success" dot="true">Active</x-ui.badge>

{{-- Small badge --}}
<x-ui.badge variant="primary" size="sm">New</x-ui.badge>

{{-- Event type badges --}}
<x-ui.badge variant="info">{{ ucfirst($event->event_type) }}</x-ui.badge>
```

---

### Input

**Component:** `<x-ui.input>`

**Location:** `resources/views/components/ui/input.blade.php`

**Purpose:** Standardized form input field with label, error handling, and hint text.

#### Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `label` | string | `null` | Any text | Input label text |
| `name` | string | **required** | Any string | Input name attribute |
| `type` | string | `'text'` | Any HTML input type | Input type |
| `required` | boolean | `false` | `true`, `false` | Mark field as required |
| `error` | string | `null` | Error message | Validation error to display |
| `hint` | string | `null` | Any text | Helper text below input |

#### Features

- Automatic RTL support for Arabic locale
- Error state styling
- Focus ring with accent color
- Required field indicator (*)
- Dark mode support

#### Usage Examples

```blade
{{-- Basic input --}}
<x-ui.input
    label="Title"
    name="title"
    required
    :error="$errors->first('title')"
/>

{{-- Email input with hint --}}
<x-ui.input
    label="Email Address"
    name="email"
    type="email"
    hint="We'll never share your email with anyone else."
    :error="$errors->first('email')"
/>

{{-- Date input --}}
<x-ui.input
    label="Publication Date"
    name="publication_date"
    type="date"
    required
/>

{{-- Input with old value --}}
<x-ui.input
    label="Authors"
    name="authors"
    value="{{ old('authors', $publication->authors ?? '') }}"
    :error="$errors->first('authors')"
/>
```

---

### Select

**Component:** `<x-ui.select>`

**Location:** `resources/views/components/ui/select.blade.php`

**Purpose:** Standardized dropdown select field with label and error handling.

#### Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `label` | string | `null` | Any text | Select label text |
| `name` | string | **required** | Any string | Select name attribute |
| `required` | boolean | `false` | `true`, `false` | Mark field as required |
| `error` | string | `null` | Error message | Validation error to display |
| `hint` | string | `null` | Any text | Helper text below select |
| `placeholder` | string | `null` | Any text | Placeholder option value |

#### Features

- Automatic RTL text alignment for Arabic
- Error state styling
- Required field indicator
- Placeholder option support
- Dark mode support

#### Usage Examples

```blade
{{-- Basic select --}}
<x-ui.select
    label="Publication Type"
    name="type"
    required
    :error="$errors->first('type')"
>
    <option value="journal">{{ __('Journal Article') }}</option>
    <option value="conference">{{ __('Conference Paper') }}</option>
    <option value="book">{{ __('Book') }}</option>
</x-ui.select>

{{-- Select with placeholder --}}
<x-ui.select
    label="Status"
    name="status"
    placeholder="-- Select Status --"
>
    <option value="published">Published</option>
    <option value="draft">Draft</option>
    <option value="under_review">Under Review</option>
</x-ui.select>

{{-- Select with old value --}}
<x-ui.select
    label="Visibility"
    name="visibility"
    required
>
    <option value="public" {{ old('visibility', $publication->visibility) == 'public' ? 'selected' : '' }}>
        Public
    </option>
    <option value="private" {{ old('visibility', $publication->visibility) == 'private' ? 'selected' : '' }}>
        Private
    </option>
</x-ui.select>
```

---

### Delete Confirm

**Component:** `<x-ui.delete-confirm>`

**Location:** `resources/views/components/ui/delete-confirm.blade.php`

**Purpose:** Reusable delete confirmation modal with Alpine.js interactions.

#### Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `action` | string | **required** | Route URL | Form action URL for deletion |
| `message` | string | Auto-generated | Any text | Custom confirmation message |
| `buttonText` | string | `'Delete'` | Any text | Custom button text |
| `variant` | string | `'icon'` | `icon`, `button`, `text` | Trigger button style |

#### Variants

- **icon:** Icon-only button with trash can icon
- **button:** Full button with icon and text
- **text:** Text-only link style

#### Features

- Alpine.js powered modal
- Backdrop with blur effect
- Smooth animations
- Click-away to close
- CSRF protection
- DELETE method spoofing

#### Usage Examples

```blade
{{-- Icon variant (default) --}}
<x-ui.delete-confirm :action="route('publications.destroy', $publication)" />

{{-- Button variant --}}
<x-ui.delete-confirm
    :action="route('events.destroy', $event)"
    variant="button"
    message="Are you sure you want to delete this event? All submissions and RSVPs will be lost."
/>

{{-- Text variant with custom button text --}}
<x-ui.delete-confirm
    :action="route('projects.destroy', $project)"
    variant="text"
    buttonText="Remove Project"
    message="This will permanently delete the project and all associated data."
/>

{{-- Custom message --}}
<x-ui.delete-confirm
    :action="route('materials.destroy', $material)"
    message="Delete {{ $material->name }}? This action cannot be undone."
/>
```

---

### Page Header

**Component:** `<x-ui.page-header>`

**Location:** `resources/views/components/ui/page-header.blade.php`

**Purpose:** Standardized page header with title, description, back button, and action buttons.

#### Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `title` | string | **required** | Any text | Page title |
| `description` | string | `null` | Any text | Optional page description |
| `backUrl` | string | `null` | Route URL | Optional back button URL |

#### Slots

- **Default slot:** Action buttons area (right side)

#### Usage Examples

```blade
{{-- Simple page header --}}
<x-ui.page-header title="Publications" />

{{-- Header with description --}}
<x-ui.page-header
    title="Research Projects"
    description="Manage active and completed research projects"
/>

{{-- Header with back button --}}
<x-ui.page-header
    title="{{ $publication->title }}"
    :backUrl="route('publications.index')"
/>

{{-- Header with action buttons --}}
<x-ui.page-header
    title="Publications"
    description="Manage your publications and research outputs"
>
    <x-ui.button
        variant="primary"
        href="{{ route('publications.create') }}"
        icon="M12 4v16m8-8H4"
    >
        {{ __('Create Publication') }}
    </x-ui.button>
</x-ui.page-header>

{{-- Full example with back and actions --}}
<x-ui.page-header
    title="{{ $event->title }}"
    description="Event details and attendees"
    :backUrl="route('events.index')"
>
    <x-ui.button
        variant="secondary"
        href="{{ route('events.edit', $event) }}"
    >
        {{ __('Edit') }}
    </x-ui.button>
    <x-ui.delete-confirm
        :action="route('events.destroy', $event)"
        variant="button"
    />
</x-ui.page-header>
```

---

## Navigation Components

### Breadcrumbs

**Component:** `<x-breadcrumbs>`

**Location:** `resources/views/components/breadcrumbs.blade.php`

**Purpose:** Navigation breadcrumb trail with home icon and chevron separators.

#### Props

| Prop | Type | Default | Options | Description |
|------|------|---------|---------|-------------|
| `items` | array | `[]` | Array of breadcrumb items | Breadcrumb navigation items |

#### Item Structure

Each item in the `items` array should have:

```php
[
    'label' => 'Page Name',  // Required: Display text
    'url' => route('name')   // Optional: Link URL (omit for current page)
]
```

#### Features

- Automatic home icon link to dashboard
- RTL-aware chevron rotation for Arabic
- Last item styled as current page (no link)
- Dark mode support
- Responsive spacing

#### Usage Examples

```blade
{{-- Simple breadcrumb --}}
<x-breadcrumbs :items="[
    ['label' => __('Publications')]
]" />

{{-- Multi-level breadcrumb --}}
<x-breadcrumbs :items="[
    ['label' => __('Publications'), 'url' => route('publications.index')],
    ['label' => __('Create Publication')]
]" />

{{-- Full navigation path --}}
<x-breadcrumbs :items="[
    ['label' => __('Events'), 'url' => route('events.index')],
    ['label' => $event->title, 'url' => route('events.show', $event)],
    ['label' => __('Submissions')]
]" />

{{-- Dynamic breadcrumb in controller --}}
@php
$breadcrumbs = [
    ['label' => __('Projects'), 'url' => route('projects.index')],
    ['label' => $project->title, 'url' => route('projects.show', $project)],
    ['label' => __('Edit')]
];
@endphp
<x-breadcrumbs :items="$breadcrumbs" />
```

---

## Design Patterns

### Color Scheme

All components follow the Nexus Design System color palette:

- **Accent Indigo:** Primary actions, focus states
- **Accent Rose:** Destructive actions, errors
- **Accent Teal:** Success states
- **Accent Amber:** Warning states
- **Zinc Scale:** Neutral colors for text and borders

### Glass Morphism

Cards and input elements use glass morphism effect with:
- Semi-transparent backgrounds
- Backdrop blur
- Subtle borders
- Soft shadows

### Dark Mode

All components fully support dark mode using Tailwind's `dark:` variant classes.

### RTL Support

Components automatically adjust for Arabic (RTL) layout:
- Text alignment
- Icon rotation
- Padding/margin direction

### Accessibility

Components include:
- ARIA labels where appropriate
- Semantic HTML
- Keyboard navigation support
- Focus indicators
- Screen reader friendly text

---

## Best Practices

1. **Use semantic variants:** Choose button/badge variants that match the action semantics (danger for delete, success for approve, etc.)

2. **Consistent spacing:** Use Tailwind spacing utilities consistently across pages

3. **Error handling:** Always pass validation errors to form components using `:error="$errors->first('field')"`

4. **Required fields:** Mark required fields with the `required` prop for visual consistency

5. **Breadcrumbs:** Add breadcrumbs to all detail/edit pages for better navigation

6. **Page headers:** Use consistent page headers across all index pages

7. **Delete confirmations:** Always use `<x-ui.delete-confirm>` instead of inline forms

8. **Icons:** Use consistent icon styles from Heroicons (the default icon set)

---

## Migration Guide

To migrate existing views to use these components:

### Before (Old Pattern)
```blade
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">{{ __('Publications') }}</h1>
        <p class="text-zinc-600 dark:text-zinc-400">Manage publications</p>
    </div>
    <a href="{{ route('publications.create') }}"
       class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-accent-indigo to-accent-purple text-white">
        {{ __('Create') }}
    </a>
</div>
```

### After (New Pattern)
```blade
<x-ui.page-header
    title="{{ __('Publications') }}"
    description="Manage publications"
>
    <x-ui.button variant="primary" href="{{ route('publications.create') }}">
        {{ __('Create') }}
    </x-ui.button>
</x-ui.page-header>
```

---

---

## Form Components

**Note:** Week 4 added advanced form components for multi-step wizards and multilingual content. For complete documentation, see `UX-Components-Documentation.md`.

### Stepper

**Component:** `<x-ui.stepper>`

**Purpose:** Multi-step form wizard with progress indicator.

**Quick Example:**
```blade
<x-ui.stepper :steps="[__('Basic'), __('Advanced'), __('Review')]">
    <x-ui.step :step="1"><!-- Content --></x-ui.step>
    <x-ui.step :step="2"><!-- Content --></x-ui.step>
    <x-ui.step :step="3"><!-- Content --></x-ui.step>
</x-ui.stepper>
```

### Step

**Component:** `<x-ui.step>`

**Purpose:** Content wrapper for individual wizard steps.

### Tabs

**Component:** `<x-ui.tabs>`

**Purpose:** Tabbed interface for organizing related content.

**Quick Example:**
```blade
<x-ui.tabs :tabs="[
    ['id' => 'tab1', 'label' => 'Tab 1'],
    ['id' => 'tab2', 'label' => 'Tab 2']
]">
    <x-ui.tab-panel id="tab1">Content 1</x-ui.tab-panel>
    <x-ui.tab-panel id="tab2">Content 2</x-ui.tab-panel>
</x-ui.tabs>
```

### Tab Panel

**Component:** `<x-ui.tab-panel>`

**Purpose:** Content container for individual tabs.

### Multilingual Input

**Component:** `<x-ui.multilingual-input>`

**Purpose:** Input field with tabbed language interface for multilingual content.

**Quick Example:**
```blade
<x-ui.multilingual-input
    label="{{ __('Title') }}"
    name="title"
    :required="true"
/>
```

**Full Documentation:** See `docs/UX-Components-Documentation.md` for complete usage examples, props, and best practices.

---

## Future Enhancements

Planned components for future releases:

- `<x-ui.modal>` - Reusable modal dialog
- `<x-ui.table>` - Styled data table
- `<x-ui.pagination>` - Custom pagination
- `<x-ui.dropdown>` - Dropdown menu
- `<x-ui.toast>` - Toast notifications
- `<x-ui.alert>` - Alert messages
- `<x-ui.file-upload>` - Drag-and-drop file upload

---

## Support

For questions or issues with these components, please refer to:
- Laravel Blade Components Documentation: https://laravel.com/docs/blade#components
- Tailwind CSS Documentation: https://tailwindcss.com/docs
- Alpine.js Documentation: https://alpinejs.dev
- UX Components Documentation: `docs/UX-Components-Documentation.md` (advanced components)

