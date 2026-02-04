# JavaScript Fixes - Turbo.js & Alpine.js Compatibility

**Date**: 2026-02-04
**Issues Fixed**: Alpine.js re-initialization errors, autofocus warnings

## Problems Identified

### 1. Alpine.js Re-initialization Error
**Error Message**: `Uncaught (in promise) TypeError: u is not a function` (appearing 12-24 times)
**Location**: `cdn.min.js:5` (Alpine.js)

**Root Cause**:
- The sidebar has `data-turbo-permanent` attribute to persist across page navigations
- Turbo.js keeps the sidebar DOM in place, but Alpine.js tried to re-initialize on every page load
- Inline `x-data` definition in the sidebar was causing conflicts with Turbo's DOM persistence

### 2. Autofocus Warning
**Warning**: `Autofocus processing was blocked because a document already has a focused element`
**Location**: profile:1

**Root Cause**:
- Turbo.js navigations maintain focus state
- Forms with `autofocus` attributes couldn't focus when another element already had focus

## Solutions Implemented

### Fix 1: Moved Alpine.js Component to Global Scope

**File**: `resources/views/layouts/app.blade.php` (lines 221-264)

**Before**:
```blade
<nav x-data="{ labManagement: false, research: false, ... }">
```

**After**:
```javascript
// Define component globally before Alpine loads
function navigationState() {
    return {
        labManagement: false,
        research: false,
        administration: false,
        personal: false,
        init() { /* load from localStorage */ },
        toggle(group) { /* toggle and save */ },
        save() { /* save to localStorage */ }
    }
}
```

**File**: `resources/views/layouts/navigation.blade.php` (line 16)

**Changed**:
```blade
<nav x-data="navigationState()" x-init="init()">
```

**Benefits**:
- Alpine component defined before Alpine.js loads
- Component reuses same instance across Turbo navigations
- No re-initialization errors
- Navigation state persists in localStorage correctly

### Fix 2: Turbo Permanent Element Protection

**File**: `resources/views/layouts/app.blade.php` (lines 316-327)

**Added**:
```javascript
document.addEventListener('turbo:before-render', (event) => {
    // Find all permanent elements in the new body
    const permanentElements = event.detail.newBody.querySelectorAll('[data-turbo-permanent]');

    permanentElements.forEach(el => {
        const original = document.querySelector(`[data-turbo-permanent][id="${el.id}"]`);
        if (original) {
            // Replace new element with original to preserve Alpine state
            el.replaceWith(original);
        }
    });
});
```

**Benefits**:
- Prevents Turbo from replacing permanent elements
- Preserves Alpine.js state and event listeners
- Eliminates double-initialization

### Fix 3: Autofocus Handler for Turbo

**File**: `resources/views/layouts/app.blade.php` (lines 350-361)

**Added**:
```javascript
document.addEventListener('turbo:load', function() {
    // Handle autofocus with Turbo
    setTimeout(() => {
        const autofocusElement = document.querySelector('[autofocus]');
        if (autofocusElement) {
            // Blur current element first
            if (document.activeElement) {
                document.activeElement.blur();
            }
            // Then focus autofocus element
            autofocusElement.focus();
        }
    }, 100);
});
```

**Benefits**:
- Properly handles autofocus after Turbo navigation
- Clears existing focus before applying new focus
- Eliminates browser warnings
- Works with forms in auth pages and profile

## Script Load Order

**Critical**: Scripts must load in this order:

1. **Axios** (line 218)
   ```html
   <script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
   ```

2. **Alpine Component Definitions** (lines 221-264)
   ```javascript
   function navigationState() { ... }
   ```

3. **Alpine.js with defer** (line 266)
   ```html
   <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
   ```

4. **Turbo Event Handlers** (lines 268+)
   ```javascript
   document.addEventListener('turbo:load', ...)
   document.addEventListener('turbo:before-render', ...)
   ```

## Testing Results

**Before Fixes**:
- ❌ Console showed 12-24 errors on each navigation
- ❌ Autofocus warnings on profile page
- ❌ Navigation state sometimes reset unexpectedly

**After Fixes**:
- ✅ Zero JavaScript errors in console
- ✅ No autofocus warnings
- ✅ Navigation state persists correctly
- ✅ Sidebar remains functional across all pages
- ✅ Alpine.js components work smoothly with Turbo

## Files Modified

1. `resources/views/layouts/app.blade.php`
   - Moved Alpine component to global scope
   - Added Turbo permanent element protection
   - Added autofocus handler
   - Reordered script tags

2. `resources/views/layouts/navigation.blade.php`
   - Changed inline x-data to component reference
   - Simplified Alpine initialization

## Best Practices for Turbo + Alpine

1. **Always define Alpine components globally** before Alpine.js loads
2. **Use `data-turbo-permanent`** sparingly and protect with before-render handler
3. **Load Alpine with `defer`** to ensure DOM is ready
4. **Handle autofocus explicitly** in Turbo load events
5. **Store component state in localStorage** when using permanent elements

## Related Issues

- Settings page responsiveness: Fixed with `flex-shrink-0` on tab buttons
- Sidebar active link: Fixed with `updateActiveNavItem()` function
- Permission cache: Cleared with `php artisan permission:cache-reset`

## References

- [Turbo.js Documentation](https://turbo.hotwired.dev/)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [Turbo + Alpine Integration Guide](https://alpinejs.dev/advanced/turbo)
