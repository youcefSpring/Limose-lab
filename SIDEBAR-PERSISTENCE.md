# Sidebar Persistence & Vite Removal Implementation

## Overview
This document explains the changes made to remove Vite and implement sidebar persistence using Turbo (Hotwire).

## Problem
- **Vite Issue**: Vite manifest not found error on cPanel hosting
- **Sidebar Reload**: Sidebar was reloading on every route change, causing flickering and poor UX

## Solution Implemented

### 1. Removed Vite
Vite has been completely removed from the project to avoid build-related issues on cPanel hosting.

**Files Modified:**
- Deleted `vite.config.js`
- Updated `package.json` - removed all Vite and build-related dependencies
- Created `public/css/app.css` - placeholder for custom CSS

**Changes in Blade Templates:**
- Replaced `@vite(['resources/css/app.css', 'resources/js/app.js'])` with `<link rel="stylesheet" href="{{ asset('css/app.css') }}">`
- Added CDN links for Alpine.js and Axios in `layouts/app.blade.php`

**Files Updated:**
- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/guest.blade.php`
- `resources/views/components/app-layout.blade.php`
- `resources/views/components/guest-layout.blade.php`

### 2. Implemented Turbo for Sidebar Persistence
Added **Turbo (Hotwire)** to enable SPA-like navigation without full page reloads.

**What is Turbo?**
- Lightweight JavaScript library (~15KB)
- Intercepts link clicks and form submissions
- Loads new pages via AJAX and updates only the `<body>` content
- Keeps persistent elements (like sidebar) from reloading

**Implementation Details:**

#### Added Turbo CDN
```html
<script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/dist/turbo.es2017-umd.js"></script>
```

#### Added `data-turbo-permanent` Attribute
This critical attribute tells Turbo to keep these elements and not replace them during navigation:

```html
<!-- Sidebar -->
<aside id="sidebar" data-turbo-permanent class="...">
    <!-- Sidebar content -->
</aside>

<!-- Mobile Overlay -->
<div id="sidebar-overlay" data-turbo-permanent class="..."></div>

<!-- Top Controls (hamburger + theme toggle) -->
<div id="top-controls" data-turbo-permanent class="...">
    <!-- Controls content -->
</div>
```

**Key Changes:**
1. **Sidebar classes updated**: Added `lg:translate-x-0` to show sidebar on desktop by default
2. **Hamburger hidden on desktop**: Added `lg:hidden` class to hamburger button
3. **Proper margin on main content**: Changed from `ml-72` to `ml-64` to match sidebar width

#### Added Turbo Event Listeners
```javascript
// Re-initialize theme after navigation (for browser back/forward)
document.addEventListener('turbo:load', initializeTheme);

// Close mobile sidebar before navigation
document.addEventListener('turbo:before-visit', function() {
    if (window.innerWidth < 1024) {
        const sidebar = document.getElementById('sidebar');
        if (sidebar && !sidebar.classList.contains('-translate-x-full')) {
            toggleSidebar();
        }
    }
});

// Scroll to top on navigation
document.addEventListener('turbo:load', function() {
    window.scrollTo(0, 0);
});
```

### 3. Added Alpine.js and Axios via CDN
```html
<script src="https://cdn.jsdelivr.net/npm/axios@1.6.7/dist/axios.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
```

## Benefits

### Sidebar Persistence
✅ **Sidebar loads only once** on first page load
✅ **No flickering** when navigating between routes
✅ **Faster navigation** - only main content refreshes
✅ **Better UX** - feels like a Single Page Application
✅ **Theme persists** across navigations
✅ **Mobile sidebar closes** automatically on navigation

### No Build Process
✅ **No npm run dev** required during development
✅ **No npm run build** required for production
✅ **Works directly** on cPanel without build artifacts
✅ **No Vite manifest** errors
✅ **Faster deployment** - just upload files

## How It Works

1. **First Page Load:**
   - Browser loads the full HTML including sidebar
   - Turbo initializes and monitors all links
   - Alpine.js and other scripts initialize
   - Sidebar shows on desktop (lg:translate-x-0), hidden on mobile (-translate-x-full)

2. **Subsequent Navigation:**
   - User clicks a link
   - Turbo intercepts the click
   - Turbo fetches the new page via AJAX
   - **Turbo identifies elements with `data-turbo-permanent`**
   - **These elements (sidebar, overlay, controls) are kept in place**
   - Turbo replaces only the NON-permanent body content
   - `turbo:load` event fires
   - Theme reinitializes (for browser back/forward)

3. **Result:**
   - Sidebar **truly persists** - not replaced or reloaded
   - Overlay stays in the DOM
   - Only main content area updates
   - Smooth, instant page transitions
   - No flickering or layout shifts

## Testing

To verify sidebar persistence:

1. Load any authenticated page (e.g., Dashboard)
2. Observe the sidebar loads
3. Click on different navigation links (Materials, Reservations, etc.)
4. **Expected**: Sidebar should NOT reload/flicker
5. **Expected**: Only the main content area updates
6. **Expected**: URL changes in browser
7. **Expected**: Browser back/forward buttons work correctly

## Deployment to cPanel

1. Upload all files to cPanel
2. Ensure `public/css/app.css` exists
3. No build step required
4. Application works immediately

## Notes

- **Turbo is automatic** - it works without any special markup on links
- **Alpine.js components** reinitialize automatically on `turbo:load`
- **Forms work normally** - Turbo handles form submissions too
- **External links** are not intercepted by Turbo (use `data-turbo="false"` if needed)
- **CSRF tokens** are automatically handled

## Troubleshooting

### If sidebar disappears on navigation:
1. **Verify `data-turbo-permanent` attribute** is present on:
   - `#sidebar` element in `layouts/navigation.blade.php`
   - `#sidebar-overlay` element
   - `#top-controls` element (if used)
2. **Check each element has a unique `id`** - required for Turbo to track them
3. **Verify sidebar has proper classes**: `lg:translate-x-0` for desktop visibility
4. **Check browser console** for JavaScript errors

### If sidebar still reloads:
- Ensure you've cleared browser cache
- Verify Turbo CDN is loading correctly (check Network tab)
- Check that all layout files have been updated

### If navigation doesn't work:
- Ensure all links use Laravel route helpers (not hardcoded URLs)
- Check if JavaScript errors are preventing Turbo from initializing
- Try disabling browser extensions

### If Alpine.js components break:
- Alpine should reinitialize automatically with Turbo
- Check that Alpine.js is loaded AFTER Turbo
- If issues persist, elements with `data-turbo-permanent` won't reinitialize Alpine (by design)

## Future Enhancements

- Add loading indicator during page transitions
- Implement Turbo Streams for real-time updates
- Add page transition animations
- Consider Turbo Frames for partial page updates

## References

- [Turbo Documentation](https://turbo.hotwired.dev/)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [Laravel with Turbo](https://turbo-laravel.com/)
