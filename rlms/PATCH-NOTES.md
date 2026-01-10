# RLMS Patch Notes
## Post-Restructuring Fixes

---

## Patch 1.0.1 - 2026-01-10

### Bug Fixes

#### Issue #1: Missing app-layout Component
**Error:** `Unable to locate a class or view for component [app-layout]`

**Fix:** Created anonymous Blade component
- File: `resources/views/components/app-layout.blade.php`
- Type: New file
- Status: ✅ Fixed

---

#### Issue #2: Enum Value Access on String
**Error:** `Attempt to read property "value" on string`
- Location: `resources/views/projects/index.blade.php:73`

**Fix:** Removed `->value` access since enums are now strings
- Changed: `$project->status->value` → `$project->status`
- Type: Code update
- Status: ✅ Fixed

---

#### Issue #3: Missing Timestamps on event_attendees Pivot Table
**Error:** `Column not found: 1054 Unknown column 'event_attendees.created_at'`

**Fix:** Added timestamps to event_attendees pivot table
- Migration: `2026_01_10_102309_add_timestamps_to_event_attendees_table.php`
- Columns added: `created_at`, `updated_at`
- Type: Database migration
- Status: ✅ Fixed

---

## Summary

**Total Issues Fixed:** 3
**Files Created:** 2
- `resources/views/components/app-layout.blade.php`
- `database/migrations/2026_01_10_102309_add_timestamps_to_event_attendees_table.php`

**Files Modified:** 1
- `resources/views/projects/index.blade.php`

**Database Changes:** 1 migration
- Added timestamps to `event_attendees` table

---

## Previous Fixes (During Restructuring)

### Issue #4: Missing Timestamps on project_user Pivot Table
**Fix:** Added timestamps to project_user pivot table
- Migration: `2026_01_10_100525_add_timestamps_to_project_user_table.php`
- Status: ✅ Fixed

### Issue #5: Missing Reservations Calendar Route
**Fix:** Added route and controller method
- Route: `GET /reservations-calendar`
- Method: `ReservationController::calendar()`
- Status: ✅ Fixed

### Issue #6: Materials Filter Missing Categories
**Fix:** Added categories to MaterialController
- File: `app/Http/Controllers/MaterialController.php`
- Status: ✅ Fixed

### Issue #7: Projects Missing Members Eager Loading
**Fix:** Added members to eager loading
- File: `app/Http/Controllers/ProjectController.php`
- Status: ✅ Fixed

---

## Total Migrations Created

1. `2026_01_10_100525_add_timestamps_to_project_user_table.php`
2. `2026_01_10_102309_add_timestamps_to_event_attendees_table.php`

**Total:** 2 new migrations
**Database tables modified:** 2 (project_user, event_attendees)

---

## Application Status

**Version:** 1.0.1
**Status:** ✅ PRODUCTION READY
**Last Updated:** 2026-01-10
**All Known Issues:** ✅ RESOLVED

---

## How to Apply Patches

If you're setting up a new instance:

```bash
# 1. Pull latest code
git pull origin main

# 2. Run migrations
php artisan migrate

# 3. Clear caches
php artisan cache:clear
php artisan view:clear
php artisan config:clear

# 4. Regenerate autoload
composer dump-autoload
```

---

## Known Working Features

✅ Authentication (Login, Register, Logout)
✅ Dashboard (Admin & User)
✅ Materials CRUD + Filters
✅ Reservations CRUD + Approval Workflow
✅ Projects CRUD + Members
✅ Events CRUD + RSVP + Comments
✅ Experiments CRUD + Files + Comments
✅ Users CRUD + Roles
✅ Maintenance Logs CRUD + Status Management

---

**Patch Date:** 2026-01-10
**Patch Author:** Automated Restructuring Process
