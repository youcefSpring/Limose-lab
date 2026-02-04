# UX Components Documentation - Multi-Step Forms & Tabbed Interfaces

**Date:** February 4, 2026
**Component Library:** Week 4 UX Enhancements
**Dependencies:** Alpine.js, Tailwind CSS

---

## Table of Contents

1. [Overview](#overview)
2. [Stepper Component](#stepper-component)
3. [Step Component](#step-component)
4. [Tabs Component](#tabs-component)
5. [Tab Panel Component](#tab-panel-component)
6. [Multilingual Input Component](#multilingual-input-component)
7. [Usage Examples](#usage-examples)
8. [Best Practices](#best-practices)

---

## Overview

This documentation covers advanced UX components designed to improve form usability and multilingual content management. These components build upon the base component library (Week 3) to provide sophisticated user interfaces.

### Component Hierarchy

```
Wizard Form
├── Stepper (progress indicator + navigation)
├── Step 1 (content wrapper)
│   ├── Card
│   ├── Multilingual Input
│   │   ├── Tabs (language switcher)
│   │   └── Tab Panels (language content)
│   └── Regular Inputs
├── Step 2
└── Step N
```

### Key Benefits

- **Reduced Cognitive Load:** Break complex forms into manageable steps
- **Better Mobile UX:** Smaller forms fit better on mobile screens
- **Progress Tracking:** Visual indication of completion status
- **Easier Translation:** Tabbed interface for multilingual content
- **Improved Validation:** Validate per-step before proceeding

---

## Stepper Component

**Component:** `<x-ui.stepper>`

**Location:** `resources/views/components/ui/stepper.blade.php`

**Purpose:** Multi-step form wizard with progress indicator and navigation.

### Props

| Prop | Type | Required | Default | Description |
|------|------|----------|---------|-------------|
| `steps` | array | Yes | `[]` | Array of step labels to display |
| `currentStep` | integer | No | `1` | Initial step to display |

### Features

- **Visual Progress Indicator:** Shows current step and completion status
- **Step Navigation:** Previous/Next buttons with auto-hide logic
- **Completed Step Indicators:** Checkmarks for completed steps
- **Responsive Design:** Adapts to mobile/tablet/desktop
- **RTL Support:** Adjusts arrow directions for Arabic
- **Alpine.js Integration:** Reactive step management
- **Smooth Transitions:** Animated step changes
- **Submit on Last Step:** Next button becomes Submit button on final step

### Visual States

- **Pending:** Gray circle with step number
- **Current:** Gradient circle with step number, bold label
- **Completed:** Gradient circle with checkmark icon

### Usage

```blade
<form method="POST" action="{{ route('publications.store') }}" x-data="{ currentStep: 1 }">
    @csrf

    <x-ui.stepper :steps="[
        __('Basic Information'),
        __('Publication Details'),
        __('Identifiers'),
        __('Research Info'),
        __('Files & Review')
    ]">
        <!-- Step content goes here -->
        <x-ui.step :step="1">
            <!-- Step 1 content -->
        </x-ui.step>

        <x-ui.step :step="2">
            <!-- Step 2 content -->
        </x-ui.step>

        <!-- More steps... -->
    </x-ui.stepper>
</form>
```

### Alpine.js Data

The stepper component requires Alpine.js with the following data structure:

```javascript
{
    currentStep: 1,        // Current active step
    totalSteps: 5,         // Total number of steps
    nextStep(),            // Function to advance
    previousStep(),        // Function to go back
    goToStep(n),           // Jump to specific step
    isStepVisible(n)       // Check if step should display
}
```

### Styling

```html
<!-- Current step indicator -->
<div class="bg-gradient-to-r from-accent-indigo to-accent-violet text-white">
    <span>1</span>
</div>

<!-- Completed step indicator -->
<div class="bg-gradient-to-r from-accent-indigo to-accent-violet text-white">
    <svg><!-- Checkmark --></svg>
</div>

<!-- Pending step indicator -->
<div class="glass border-2 border-black/10 dark:border-white/10">
    <span>3</span>
</div>
```

### Accessibility

- Semantic HTML with proper navigation structure
- Keyboard navigable (Tab, Shift+Tab, Enter)
- Screen reader announcements for step changes
- ARIA attributes for progress indication
- Focus management on step transitions

---

## Step Component

**Component:** `<x-ui.step>`

**Location:** `resources/views/components/ui/step.blade.php`

**Purpose:** Content wrapper for individual wizard steps.

### Props

| Prop | Type | Required | Default | Description |
|------|------|----------|---------|-------------|
| `step` | integer | Yes | - | Step number (1-indexed) |
| `title` | string | No | `null` | Optional step title |
| `description` | string | No | `null` | Optional step description |

### Features

- **Conditional Display:** Shows only when step is active
- **Smooth Transitions:** Slide-in animation on step change
- **Auto-hide:** Hides inactive steps from DOM
- **Title/Description:** Optional heading and subheading
- **Flexible Content:** Accepts any content in default slot

### Usage

```blade
<x-ui.step
    :step="1"
    title="{{ __('Basic Information') }}"
    description="{{ __('Enter the core details about your publication') }}"
>
    <x-ui.card>
        <x-ui.input label="{{ __('Title') }}" name="title" required />
        <x-ui.input label="{{ __('Authors') }}" name="authors" required />
    </x-ui.card>
</x-ui.step>
```

### Transitions

```html
<!-- Enter animation -->
x-transition:enter="transition ease-out duration-300"
x-transition:enter-start="opacity-0 transform translate-x-4"
x-transition:enter-end="opacity-100 transform translate-x-0"

<!-- Leave animation -->
x-transition:leave="transition ease-in duration-200"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"
```

---

## Tabs Component

**Component:** `<x-ui.tabs>`

**Location:** `resources/views/components/ui/tabs.blade.php`

**Purpose:** Tabbed interface for organizing related content.

### Props

| Prop | Type | Required | Default | Description |
|------|------|----------|---------|-------------|
| `tabs` | array | Yes | `[]` | Array of tab definitions |
| `activeTab` | string | No | First tab ID | Initially active tab ID |

### Tab Definition Structure

```php
[
    'id' => 'unique-id',      // Required: Unique identifier
    'label' => 'Tab Label',   // Required: Display text
    'icon' => '🔖'            // Optional: Icon/emoji
]
```

### Features

- **Multiple Tabs:** Support for 2+ tabs
- **Active State:** Visual indication of selected tab
- **Icons:** Optional icon/emoji support
- **Keyboard Navigation:** Arrow keys to switch tabs
- **Smooth Transitions:** Animated tab panel switching
- **Accessible:** Proper ARIA roles and labels

### Usage

```blade
<x-ui.tabs :tabs="[
    ['id' => 'en', 'label' => __('English'), 'icon' => '🇬🇧'],
    ['id' => 'fr', 'label' => __('French'), 'icon' => '🇫🇷'],
    ['id' => 'ar', 'label' => __('Arabic'), 'icon' => '🇸🇦']
]" active-tab="en">
    <x-ui.tab-panel id="en">
        <!-- English content -->
    </x-ui.tab-panel>

    <x-ui.tab-panel id="fr">
        <!-- French content -->
    </x-ui.tab-panel>

    <x-ui.tab-panel id="ar">
        <!-- Arabic content -->
    </x-ui.tab-panel>
</x-ui.tabs>
```

### Styling

```html
<!-- Active tab -->
<button class="border-accent-indigo text-accent-indigo">
    🇬🇧 English
</button>

<!-- Inactive tab -->
<button class="border-transparent text-zinc-500 hover:text-zinc-700">
    🇫🇷 French
</button>
```

---

## Tab Panel Component

**Component:** `<x-ui.tab-panel>`

**Location:** `resources/views/components/ui/tab-panel.blade.php`

**Purpose:** Content container for individual tabs.

### Props

| Prop | Type | Required | Default | Description |
|------|------|----------|---------|-------------|
| `id` | string | Yes | - | Panel ID matching tab ID |

### Features

- **Conditional Display:** Shows only when tab is active
- **Smooth Transitions:** Scale and fade animation
- **Hidden by Default:** Uses x-show with display: none
- **Attribute Passthrough:** Accepts additional attributes

### Usage

```blade
<x-ui.tab-panel id="settings" class="space-y-4">
    <h3>{{ __('Settings') }}</h3>
    <!-- Panel content -->
</x-ui.tab-panel>
```

---

## Multilingual Input Component

**Component:** `<x-ui.multilingual-input>`

**Location:** `resources/views/components/ui/multilingual-input.blade.php`

**Purpose:** Combined input field with tabbed language interface for multilingual content.

### Props

| Prop | Type | Required | Default | Description |
|------|------|----------|---------|-------------|
| `label` | string | No | `null` | Field label |
| `name` | string | Yes | - | Base field name (e.g., 'title') |
| `type` | string | No | `'text'` | Input type: 'text' or 'textarea' |
| `required` | boolean | No | `false` | Mark field as required |
| `rows` | integer | No | `3` | Rows for textarea type |
| `values` | array | No | `[]` | Pre-filled values for each language |
| `errors` | array | No | `[]` | Validation errors for each language |
| `hints` | array | No | `[]` | Helper text for each language |

### Features

- **Three Languages:** English, French, Arabic support
- **Tabbed Interface:** Easy switching between languages
- **Required Field Handling:** Only English required by default
- **Error Display:** Per-language error messages
- **Hint Support:** Optional helper text per language
- **RTL Support:** Automatic text direction for Arabic
- **Old Value Support:** Preserves form data on validation failure
- **Textarea Support:** Switch between input and textarea

### Usage

#### Text Input

```blade
<x-ui.multilingual-input
    label="{{ __('Title') }}"
    name="title"
    :required="true"
    :errors="[
        'en' => $errors->first('title'),
        'fr' => $errors->first('title_fr'),
        'ar' => $errors->first('title_ar')
    ]"
    :values="[
        'en' => $publication->title ?? '',
        'fr' => $publication->title_fr ?? '',
        'ar' => $publication->title_ar ?? ''
    ]"
/>
```

#### Textarea

```blade
<x-ui.multilingual-input
    label="{{ __('Abstract') }}"
    name="abstract"
    type="textarea"
    :rows="6"
    :required="true"
    :errors="[
        'en' => $errors->first('abstract'),
        'fr' => $errors->first('abstract_fr'),
        'ar' => $errors->first('abstract_ar')
    ]"
/>
```

### Form Field Names

The component automatically generates field names:
- English: `{name}` (e.g., `title`)
- French: `{name}_fr` (e.g., `title_fr`)
- Arabic: `{name}_ar` (e.g., `title_ar`)

### Language Configuration

```php
$tabs = [
    ['id' => 'en', 'label' => __('English'), 'icon' => '🇬🇧'],
    ['id' => 'fr', 'label' => __('French'), 'icon' => '🇫🇷'],
    ['id' => 'ar', 'label' => __('Arabic'), 'icon' => '🇸🇦'],
];
```

---

## Usage Examples

### Complete Publication Wizard Form

```blade
<form method="POST" action="{{ route('publications.store') }}" x-data="{ currentStep: 1 }">
    @csrf

    <x-ui.stepper :steps="[
        __('Basic Info'),
        __('Details'),
        __('Submit')
    ]">
        <!-- Step 1: Basic Info -->
        <x-ui.step :step="1">
            <x-ui.card>
                <!-- Multilingual title -->
                <x-ui.multilingual-input
                    label="{{ __('Title') }}"
                    name="title"
                    :required="true"
                    :errors="[
                        'en' => $errors->first('title'),
                        'fr' => $errors->first('title_fr'),
                        'ar' => $errors->first('title_ar')
                    ]"
                />

                <!-- Single language field -->
                <x-ui.input
                    label="{{ __('Authors') }}"
                    name="authors"
                    :required="true"
                />
            </x-ui.card>
        </x-ui.step>

        <!-- Step 2: Details -->
        <x-ui.step :step="2">
            <x-ui.card>
                <x-ui.select
                    label="{{ __('Type') }}"
                    name="type"
                    :required="true"
                >
                    <option value="journal">Journal</option>
                    <option value="conference">Conference</option>
                </x-ui.select>
            </x-ui.card>
        </x-ui.step>

        <!-- Step 3: Review -->
        <x-ui.step :step="3">
            <x-ui.card>
                <p>{{ __('Review and submit') }}</p>
            </x-ui.card>
        </x-ui.step>
    </x-ui.stepper>
</form>
```

### Settings Page with Tabs

```blade
<x-ui.tabs :tabs="[
    ['id' => 'general', 'label' => __('General'), 'icon' => '⚙️'],
    ['id' => 'notifications', 'label' => __('Notifications'), 'icon' => '🔔'],
    ['id' => 'security', 'label' => __('Security'), 'icon' => '🔒']
]">
    <x-ui.tab-panel id="general">
        <x-ui.card>
            <h3>{{ __('General Settings') }}</h3>
            <!-- Settings fields -->
        </x-ui.card>
    </x-ui.tab-panel>

    <x-ui.tab-panel id="notifications">
        <x-ui.card>
            <h3>{{ __('Notification Preferences') }}</h3>
            <!-- Notification settings -->
        </x-ui.card>
    </x-ui.tab-panel>

    <x-ui.tab-panel id="security">
        <x-ui.card>
            <h3>{{ __('Security Options') }}</h3>
            <!-- Security settings -->
        </x-ui.card>
    </x-ui.tab-panel>
</x-ui.tabs>
```

---

## Best Practices

### Multi-Step Forms

1. **Keep Steps Focused:** Each step should have a single purpose
2. **5-7 Steps Maximum:** Too many steps hurts completion rates
3. **Validate Per Step:** Check required fields before allowing next
4. **Save Progress:** Consider auto-saving draft data
5. **Allow Back Navigation:** Users should be able to review previous steps
6. **Show Progress:** Always display which step they're on

### Tabbed Interfaces

1. **2-7 Tabs Ideal:** Too few = not needed, too many = dropdown instead
2. **Short Labels:** Keep tab labels concise (1-2 words)
3. **Logical Order:** Most important/common tab first
4. **Distinct Content:** Each tab should have clearly different content
5. **Remember State:** Preserve active tab on page reload

### Multilingual Inputs

1. **English First:** Make English the default/required language
2. **Optional Translations:** Don't require all languages
3. **Clear Labels:** Use flag icons for easy recognition
4. **Consistent Formatting:** Keep placeholder text similar across languages
5. **Validation Messages:** Translate error messages too

### Accessibility

1. **Keyboard Navigation:** Test all components with keyboard only
2. **Screen Readers:** Add proper ARIA labels
3. **Focus Management:** Maintain logical focus order
4. **Error Announcements:** Use role="alert" for errors
5. **Progress Indication:** Announce step changes to screen readers

### Performance

1. **Lazy Load Steps:** Only render current step content
2. **Debounce Auto-Save:** Don't save on every keystroke
3. **Optimize Alpine.js:** Keep x-data objects small
4. **Minimize Re-renders:** Use x-show instead of x-if where possible

---

## Migration Guide

### From Single-Page Form to Wizard

**Before:**
```blade
<form method="POST">
    @csrf
    <div class="space-y-6">
        <input name="title">
        <input name="authors">
        <input name="year">
        <!-- 50 more fields... -->
        <button type="submit">Submit</button>
    </div>
</form>
```

**After:**
```blade
<form method="POST" x-data="{ currentStep: 1 }">
    @csrf
    <x-ui.stepper :steps="[__('Basic'), __('Advanced'), __('Review')]">
        <x-ui.step :step="1">
            <x-ui.card>
                <input name="title">
                <input name="authors">
            </x-ui.card>
        </x-ui.step>

        <x-ui.step :step="2">
            <x-ui.card>
                <input name="year">
                <!-- More fields -->
            </x-ui.card>
        </x-ui.step>

        <x-ui.step :step="3">
            <x-ui.card>
                <p>Review your submission</p>
            </x-ui.card>
        </x-ui.step>
    </x-ui.stepper>
</form>
```

### From Separate Language Fields to Tabbed Input

**Before:**
```blade
<div>
    <label>Title (English)</label>
    <input name="title">
</div>
<div>
    <label>Title (French)</label>
    <input name="title_fr">
</div>
<div>
    <label>Title (Arabic)</label>
    <input name="title_ar" dir="rtl">
</div>
```

**After:**
```blade
<x-ui.multilingual-input
    label="{{ __('Title') }}"
    name="title"
    :required="true"
/>
```

---

## Troubleshooting

### Stepper Not Advancing

**Problem:** Clicking "Next" doesn't change step.

**Solutions:**
- Ensure `x-data="{ currentStep: 1 }"` is on form element
- Check Alpine.js is loaded
- Verify no JavaScript errors in console

### Tabs Not Switching

**Problem:** Clicking tabs doesn't change content.

**Solutions:**
- Verify tab IDs match panel IDs exactly
- Check `x-data` is present on tabs wrapper
- Ensure Alpine.js is initialized

### Multilingual Input Not Saving

**Problem:** Only English value is saved to database.

**Solutions:**
- Check form request accepts `{name}_fr` and `{name}_ar`
- Verify migration includes `{name}_fr` and `{name}_ar` columns
- Ensure model has fields in `$fillable` array

### Validation Errors Not Displaying

**Problem:** Errors don't show in wizard.

**Solutions:**
- Pass error messages to `:errors` prop
- Check error bag names match form fields
- Ensure error display is in same step as field

---

## Future Enhancements

Planned improvements for future versions:

1. **Step Validation:** Prevent advancing with invalid fields
2. **Auto-Save:** Draft saving for long forms
3. **Progress Persistence:** Resume where user left off
4. **Conditional Steps:** Show/hide steps based on previous answers
5. **Step Summary:** Review all entered data before submit
6. **More Languages:** Support for additional locales
7. **Custom Validation:** Per-step validation rules
8. **Analytics:** Track step completion rates

---

## Conclusion

These UX components significantly improve the user experience for complex forms and multilingual content. By breaking long forms into manageable steps and organizing language variants in tabs, we reduce cognitive load and improve completion rates.

**Key Takeaways:**
- Use steppers for forms with 10+ fields
- Use tabs for 2-7 related content groups
- Use multilingual inputs for translated content
- Always test with keyboard and screen readers
- Monitor form completion analytics

**Reference Implementation:**
- Publication wizard: `resources/views/publications/create-wizard.blade.php`
- Event wizard: `resources/views/events/create-wizard.blade.php`

---

**Document Version:** 1.0
**Last Updated:** February 4, 2026
**Dependencies:** Alpine.js 3.x, Tailwind CSS 3.x
