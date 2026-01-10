# Nexus Template Conversion Checklist

**Project:** RLMS - Research Laboratory Management System
**Date:** 2026-01-10
**Purpose:** Track conversion from Laravel Breeze default styling to Nexus template design
**Status:** IN PROGRESS

---

## Design System Reference

### Nexus Template Characteristics

#### 🎨 Color Palette
```
Accent Colors:
- amber:   #f59e0b (Warm gold)
- coral:   #f97316 (Orange-red)
- rose:    #f43f5e (Pink-red)
- violet:  #8b5cf6 (Purple)
- cyan:    #06b6d4 (Blue-cyan)
- emerald: #10b981 (Green)

Surface Colors (Dark Mode):
- surface-900: #0a0a0f (Darkest)
- surface-800: #12121a
- surface-700: #1a1a25
- surface-600: #252532 (Lightest)
```

#### ✨ Glass-Morphism Effects
```css
.glass
  - background: rgba(255, 255, 255, 0.8) [light]
  - background: rgba(26, 26, 37, 0.6) [dark]
  - backdrop-filter: blur(20px)
  - border: 1px solid rgba(0, 0, 0, 0.05) [light]
  - border: 1px solid rgba(255, 255, 255, 0.05) [dark]

.glass-card
  - background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(248, 250, 252, 0.6)) [light]
  - background: linear-gradient(135deg, rgba(37, 37, 50, 0.8), rgba(26, 26, 37, 0.4)) [dark]
  - backdrop-filter: blur(10px)
  - box-shadow: 0 4px 20px -5px rgba(0, 0, 0, 0.1)
```

#### 🔲 Border Radius
```
rounded-xl   → 0.75rem (12px)
rounded-2xl  → 1rem (16px)
```

#### 📝 Typography
```
Fonts:
- English/French: Outfit
- Arabic: Cairo
- Monospace: Space Mono

Heading: text-xl sm:text-2xl font-semibold
Subtitle: text-zinc-500 dark:text-zinc-400 text-sm
```

---

## Laravel Breeze vs Nexus Comparison

### Component Style Comparison

#### Buttons

**OLD BREEZE:**
```blade
bg-gray-800 dark:bg-gray-200
text-white dark:text-gray-800
border border-transparent rounded-md
hover:bg-gray-700 dark:hover:bg-white
focus:ring-indigo-500
```

**NEW NEXUS:**
```blade
bg-gradient-to-r from-accent-amber to-accent-coral
text-white
rounded-xl px-4 py-2.5
hover:opacity-90
focus:ring-2 focus:ring-accent-amber/50
transition-all
```

---

#### Cards

**OLD BREEZE:**
```blade
bg-white dark:bg-gray-800
shadow-sm sm:rounded-lg
border-gray-200 dark:border-gray-700
```

**NEW NEXUS:**
```blade
glass-card rounded-2xl
p-5 lg:p-6
hover:scale-[1.02] transition-all duration-300
```

---

#### Form Inputs

**OLD BREEZE:**
```blade
border-gray-300 dark:border-gray-700
focus:border-indigo-500 dark:focus:border-indigo-600
focus:ring-indigo-500 dark:focus:ring-indigo-600
rounded-md shadow-sm
```

**NEW NEXUS:**
```blade
bg-white dark:bg-surface-700/50
border border-black/10 dark:border-white/10
rounded-xl
focus:ring-2 focus:ring-accent-amber/50
focus:border-accent-amber
transition-all
```

---

## Conversion Checklist

### 🔴 CRITICAL PRIORITY (User-Facing, High Traffic)

#### Profile/Settings Module

- [ ] **profile/edit.blade.php**
  - Status: ❌ NOT CONVERTED
  - Current: Breeze white boxes
  - Target: Nexus glass-cards
  - Estimated Time: 30 minutes
  - Assignee: ___________
  
- [ ] **profile/partials/update-profile-information-form.blade.php**
  - Status: ❌ NOT CONVERTED
  - Changes Needed:
    - Replace section with glass-card wrapper
    - Update input styling
    - Update button to gradient
  - Estimated Time: 20 minutes
  
- [ ] **profile/partials/update-password-form.blade.php**
  - Status: ❌ NOT CONVERTED
  - Same changes as above
  - Estimated Time: 20 minutes
  
- [ ] **profile/partials/delete-user-form.blade.php**
  - Status: ❌ NOT CONVERTED
  - Add glass-card styling
  - Update danger button to use accent-rose
  - Estimated Time: 15 minutes

**Total Profile Module: ~1.5 hours**

---

### 🟡 HIGH PRIORITY (Core Components)

#### Button Components

- [ ] **components/primary-button.blade.php**
  - Status: ❌ NOT CONVERTED
  - Current: Gray/Indigo
  - Target: Amber-Coral gradient
  - Estimated Time: 10 minutes
  
- [ ] **components/secondary-button.blade.php**
  - Status: ❌ NOT CONVERTED
  - Target: Outline style with Nexus colors
  - Estimated Time: 10 minutes
  
- [ ] **components/danger-button.blade.php**
  - Status: ⚠️ NEEDS UPDATE
  - Update to use accent-rose
  - Estimated Time: 10 minutes

**Total Buttons: ~30 minutes**

---

#### Card Components

- [ ] **components/card.blade.php**
  - Status: ❌ NOT CONVERTED
  - Current: bg-white with shadow
  - Target: glass-card effect
  - Estimated Time: 15 minutes

---

#### Input Components

- [ ] **components/text-input.blade.php**
  - Status: ⚠️ NEEDS VERIFICATION
  - Update border colors
  - Add Nexus focus states
  - Estimated Time: 10 minutes
  
- [ ] **components/input-label.blade.php**
  - Status: ⚠️ NEEDS VERIFICATION
  - Update text colors
  - Estimated Time: 5 minutes
  
- [ ] **components/input-error.blade.php**
  - Status: ⚠️ NEEDS VERIFICATION
  - Use accent-rose for errors
  - Estimated Time: 5 minutes

**Total Inputs: ~20 minutes**

---

### 🟢 MEDIUM PRIORITY (Auth Flow)

#### Auth Views

- [ ] **auth/login.blade.php**
  - Status: ✅ USING GUEST LAYOUT (Already Nexus)
  - Verify: Check form inputs use Nexus styling
  - Estimated Time: 10 minutes verification
  
- [ ] **auth/register.blade.php**
  - Status: ✅ USING GUEST LAYOUT
  - Verify: Same as login
  - Estimated Time: 10 minutes
  
- [ ] **auth/forgot-password.blade.php**
  - Status: ✅ USING GUEST LAYOUT
  - Verify: Same as login
  - Estimated Time: 5 minutes
  
- [ ] **auth/reset-password.blade.php**
  - Status: ✅ USING GUEST LAYOUT
  - Verify: Same as login
  - Estimated Time: 5 minutes
  
- [ ] **auth/verify-email.blade.php**
  - Status: ⚠️ NEEDS VERIFICATION
  - Estimated Time: 10 minutes
  
- [ ] **auth/confirm-password.blade.php**
  - Status: ⚠️ NEEDS VERIFICATION
  - Estimated Time: 10 minutes

**Total Auth: ~50 minutes**

---

### 🔵 LOW PRIORITY (Supporting Components)

#### Dropdown Components

- [ ] **components/dropdown.blade.php**
  - Status: ⚠️ NEEDS UPDATE
  - Add glass effect to dropdown menu
  - Update colors
  - Estimated Time: 20 minutes
  
- [ ] **components/dropdown-link.blade.php**
  - Status: ⚠️ NEEDS UPDATE
  - Update hover states
  - Estimated Time: 10 minutes

---

#### Navigation Components

- [ ] **components/nav-link.blade.php**
  - Status: ⚠️ NEEDS VERIFICATION
  - Check active states use Nexus colors
  - Estimated Time: 10 minutes
  
- [ ] **components/responsive-nav-link.blade.php**
  - Status: ⚠️ NEEDS VERIFICATION
  - Same as nav-link
  - Estimated Time: 10 minutes

---

#### Modal Components

- [ ] **components/modal.blade.php**
  - Status: ⚠️ NEEDS UPDATE
  - Replace bg-white with glass-card
  - Add backdrop blur
  - Estimated Time: 15 minutes

---

#### Application Logo

- [ ] **components/application-logo.blade.php**
  - Status: ⚠️ NEEDS VERIFICATION
  - Ensure uses gradient background
  - Estimated Time: 5 minutes

---

## Time Estimates Summary

| Priority | Items | Estimated Time |
|----------|-------|----------------|
| 🔴 Critical | 4 items | 1.5 hours |
| 🟡 High | 10 items | 1.5 hours |
| 🟢 Medium | 6 items | 50 minutes |
| 🔵 Low | 7 items | 1 hour |
| **TOTAL** | **27 items** | **~4.5 hours** |

---

## Conversion Guidelines

### Step-by-Step Process

#### For Each View File:

1. **Identify Current Styling**
   ```bash
   grep -n "bg-white\|bg-gray-800\|shadow-sm\|rounded-lg" file.blade.php
   ```

2. **Replace Container Classes**
   ```blade
   <!-- FIND -->
   class="bg-white dark:bg-gray-800 shadow sm:rounded-lg"
   
   <!-- REPLACE WITH -->
   class="glass-card rounded-2xl"
   ```

3. **Update Padding**
   ```blade
   <!-- FIND -->
   class="p-4 sm:p-8"
   
   <!-- REPLACE WITH -->
   class="p-5 lg:p-6"
   ```

4. **Update Border Colors**
   ```blade
   <!-- FIND -->
   border-gray-200 dark:border-gray-700
   
   <!-- REPLACE WITH -->
   border-black/10 dark:border-white/10
   ```

5. **Update Text Colors**
   ```blade
   <!-- FIND -->
   text-gray-900 dark:text-gray-100
   text-gray-600 dark:text-gray-400
   
   <!-- REPLACE WITH -->
   text-zinc-800 dark:text-white
   text-zinc-500 dark:text-zinc-400
   ```

6. **Test Dark Mode**
   - Toggle dark mode
   - Verify glass effect visible
   - Check text contrast

7. **Test RTL (if applicable)**
   - Switch to Arabic
   - Verify layout mirrors correctly
   - Check spacing adjustments

---

#### For Each Component File:

1. **Update Default Classes**
   ```php
   // OLD
   $attributes->merge(['class' => 'bg-white dark:bg-gray-800'])
   
   // NEW
   $attributes->merge(['class' => 'glass-card rounded-2xl'])
   ```

2. **Update Color Variables**
   ```php
   // OLD
   'primary' => 'bg-blue-600'
   
   // NEW  
   'primary' => 'bg-gradient-to-r from-accent-amber to-accent-coral'
   ```

3. **Update Focus States**
   ```php
   // OLD
   'focus:ring-indigo-500'
   
   // NEW
   'focus:ring-accent-amber/50'
   ```

4. **Test All Variants**
   - Test each variant/size combination
   - Verify hover states
   - Check disabled states

---

## Quality Assurance Checklist

### Before Marking as Complete

For each converted file, verify:

- [ ] Glass-morphism effect visible
- [ ] Nexus colors used (amber, coral, violet, cyan, etc.)
- [ ] rounded-2xl or rounded-xl used (not rounded-lg)
- [ ] Dark mode styling correct
- [ ] RTL support working (if applicable)
- [ ] Hover effects smooth
- [ ] Focus states visible
- [ ] Mobile responsive
- [ ] No console errors
- [ ] Matches design system documentation

---

## Testing Procedures

### Visual Regression Testing

1. **Take "Before" Screenshot**
   ```bash
   # Use browser dev tools
   # Or automated tool like Percy/Chromatic
   ```

2. **Make Changes**

3. **Take "After" Screenshot**

4. **Compare**
   - Layout matches?
   - Colors correct?
   - Spacing consistent?

---

### Dark Mode Testing

```javascript
// Toggle dark mode
document.documentElement.classList.toggle('dark');

// Check each converted component
// Verify:
// - Background colors appropriate
// - Text readable (contrast)
// - Border colors visible
// - Glass effect apparent
```

---

### RTL Testing

```javascript
// Switch to Arabic
document.documentElement.dir = 'rtl';

// Verify:
// - Layout mirrors correctly
// - Icons positioned correctly
// - Spacing reversed
// - Text alignment correct
```

---

## Progress Tracking

### Overall Progress

```
[████░░░░░░░░░░░░░░░░] 20% Complete (5/27 items)
```

### By Priority

| Priority | Progress | Items Done | Items Total |
|----------|----------|------------|-------------|
| 🔴 Critical | [░░░░░░░░░░░░░░░░░░░░] 0% | 0/4 | Not Started |
| 🟡 High | [░░░░░░░░░░░░░░░░░░░░] 0% | 0/10 | Not Started |
| 🟢 Medium | [███░░░░░░░░░░░░░░░░░] 15% | 1/6 | Guest Layout ✓ |
| 🔵 Low | [░░░░░░░░░░░░░░░░░░░░] 0% | 0/7 | Not Started |

---

## Common Issues & Solutions

### Issue 1: Glass Effect Not Visible

**Problem:** Changed to glass-card but no blur effect visible

**Solution:**
- Ensure `backdrop-filter: blur()` is in CSS
- Check browser supports backdrop-filter
- Verify parent doesn't have `overflow: hidden`

---

### Issue 2: Colors Not Matching

**Problem:** Using Nexus color names but displaying different colors

**Solution:**
- Check Tailwind config includes Nexus colors
- Run `npm run dev` to rebuild CSS
- Clear browser cache

---

### Issue 3: Dark Mode Not Working

**Problem:** Dark mode styles not applying

**Solution:**
- Verify `class="dark"` on `<html>` element
- Check `darkMode: 'class'` in Tailwind config
- Ensure using `dark:` prefix on classes

---

### Issue 4: RTL Spacing Issues

**Problem:** Spacing not reversing in RTL mode

**Solution:**
```blade
<!-- Use conditional spacing -->
{{ app()->getLocale() === 'ar' ? 'mr-3' : 'ml-3' }}

<!-- Or use space-x-reverse -->
<div class="flex space-x-4 {{ app()->getLocale() === 'ar' ? 'space-x-reverse' : '' }}">
```

---

## Sign-Off

### Completion Criteria

To mark this conversion as COMPLETE, all of the following must be true:

- [ ] All 27 items checked off
- [ ] Visual regression testing passed
- [ ] Dark mode verified on all pages
- [ ] RTL tested on all pages
- [ ] Mobile responsive verified
- [ ] No Breeze styling remaining
- [ ] Component library documented
- [ ] Design system guide updated

---

### Team Sign-Off

| Role | Name | Signature | Date |
|------|------|-----------|------|
| Developer | _______ | _______ | _____ |
| Designer | _______ | _______ | _____ |
| QA Tester | _______ | _______ | _____ |
| Product Owner | _______ | _______ | _____ |

---

**Document Version:** 1.0
**Last Updated:** 2026-01-10
**Next Review:** After completing critical priority items
**Status:** READY FOR EXECUTION
