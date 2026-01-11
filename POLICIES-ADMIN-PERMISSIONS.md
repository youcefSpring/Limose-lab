# Admin CRUD Permissions - All Policies

## Overview
All policies have been created/updated to ensure **admin users have full CRUD access** to all resources in the RLMS application.

## Summary

✅ **ALL 10 POLICIES CONFIGURED**

| # | Model | Policy | Admin Access | Status |
|---|-------|--------|--------------|--------|
| 1 | Material | MaterialPolicy | ✅ Full CRUD | ✅ Verified |
| 2 | Reservation | ReservationPolicy | ✅ Full CRUD | ✅ Created |
| 3 | User | UserPolicy | ✅ Full CRUD | ✅ Verified |
| 4 | Project | ProjectPolicy | ✅ Full CRUD | ✅ Created |
| 5 | Room | RoomPolicy | ✅ Full CRUD | ✅ Verified |
| 6 | Material Category | MaterialCategoryPolicy | ✅ Full CRUD | ✅ Updated |
| 7 | Maintenance Log | MaintenanceLogPolicy | ✅ Full CRUD | ✅ Created |
| 8 | Experiment | ExperimentPolicy | ✅ Full CRUD | ✅ Created |
| 9 | Event | EventPolicy | ✅ Full CRUD | ✅ Created |
| 10 | Publication | PublicationPolicy | ✅ Full CRUD | ✅ Verified |

---

## Policy Details

### 1. MaterialPolicy ✅
**File:** `app/Policies/MaterialPolicy.php`

**Admin Permissions:**
- ✅ `viewAny()` - View all materials
- ✅ `view()` - View individual material
- ✅ `create()` - Create materials
- ✅ `update()` - Update materials
- ✅ `delete()` - Delete materials
- ✅ `restore()` - Restore soft-deleted materials
- ✅ `forceDelete()` - Permanently delete materials

**Other Roles:**
- `material_manager`, `technician` - Can create, update
- All authenticated users - Can view

---

### 2. ReservationPolicy ✅ **NEW**
**File:** `app/Policies/ReservationPolicy.php`

**Admin Permissions:**
- ✅ `viewAny()` - View all reservations
- ✅ `view()` - View any reservation
- ✅ `create()` - Create reservations
- ✅ `update()` - Update any reservation
- ✅ `delete()` - Delete any reservation
- ✅ `restore()` - Restore soft-deleted reservations
- ✅ `forceDelete()` - Permanently delete reservations
- ✅ `approve()` - Approve/reject reservations
- ✅ `cancel()` - Cancel any reservation

**Other Roles:**
- All users - Can create, view their own
- Users - Can update/cancel their own pending/approved reservations
- `material_manager` - Can approve reservations

---

### 3. UserPolicy ✅
**File:** `app/Policies/UserPolicy.php`

**Admin Permissions:**
- ✅ `viewAny()` - View all users
- ✅ `view()` - View individual user
- ✅ `create()` - Create users
- ✅ `update()` - Update users
- ✅ `delete()` - Delete users (except self)
- ✅ `restore()` - Restore soft-deleted users
- ✅ `forceDelete()` - Permanently delete users (except self)

**Special Rules:**
- Admin cannot delete/force delete their own account (safety measure)

---

### 4. ProjectPolicy ✅ **NEW**
**File:** `app/Policies/ProjectPolicy.php`

**Admin Permissions:**
- ✅ `viewAny()` - View all projects
- ✅ `view()` - View individual project
- ✅ `create()` - Create projects
- ✅ `update()` - Update any project
- ✅ `delete()` - Delete any project
- ✅ `restore()` - Restore soft-deleted projects
- ✅ `forceDelete()` - Permanently delete projects

**Other Roles:**
- `researcher`, `partial_researcher`, `phd_student` - Can create projects
- Project creator - Can update/delete their own projects
- All users - Can view projects

---

### 5. RoomPolicy ✅
**File:** `app/Policies/RoomPolicy.php`

**Admin Permissions:**
- ✅ `viewAny()` - View all rooms
- ✅ `view()` - View individual room
- ✅ `create()` - Create rooms
- ✅ `update()` - Update rooms
- ✅ `delete()` - Delete rooms
- ✅ `restore()` - Restore soft-deleted rooms
- ✅ `forceDelete()` - Permanently delete rooms

**Other Roles:**
- All authenticated users - Can view rooms only

---

### 6. MaterialCategoryPolicy ✅ **UPDATED**
**File:** `app/Policies/MaterialCategoryPolicy.php`

**Admin Permissions:**
- ✅ `viewAny()` - View all categories
- ✅ `view()` - View individual category
- ✅ `create()` - Create categories
- ✅ `update()` - Update categories
- ✅ `delete()` - Delete categories
- ✅ `restore()` - Restore soft-deleted categories
- ✅ `forceDelete()` - Permanently delete categories
- ✅ `manage()` - Manage categories

**Changes Made:**
- Updated to check `hasRole('admin')` first before checking permission
- Ensures admin always has access regardless of assigned permissions

**Other Roles:**
- Users with `categories.manage` permission

---

### 7. MaintenanceLogPolicy ✅ **NEW**
**File:** `app/Policies/MaintenanceLogPolicy.php`

**Admin Permissions:**
- ✅ `viewAny()` - View all maintenance logs
- ✅ `view()` - View individual log
- ✅ `create()` - Create maintenance logs
- ✅ `update()` - Update any log
- ✅ `delete()` - Delete any log
- ✅ `restore()` - Restore soft-deleted logs
- ✅ `forceDelete()` - Permanently delete logs

**Other Roles:**
- `technician`, `material_manager` - Can create, update logs
- All users - Can view logs

---

### 8. ExperimentPolicy ✅ **NEW**
**File:** `app/Policies/ExperimentPolicy.php`

**Admin Permissions:**
- ✅ `viewAny()` - View all experiments
- ✅ `view()` - View individual experiment
- ✅ `create()` - Create experiments
- ✅ `update()` - Update any experiment
- ✅ `delete()` - Delete any experiment
- ✅ `restore()` - Restore soft-deleted experiments
- ✅ `forceDelete()` - Permanently delete experiments

**Other Roles:**
- `researcher`, `partial_researcher`, `phd_student` - Can create experiments
- Assigned researcher - Can update/delete their own experiments
- All users - Can view experiments

---

### 9. EventPolicy ✅ **NEW**
**File:** `app/Policies/EventPolicy.php`

**Admin Permissions:**
- ✅ `viewAny()` - View all events
- ✅ `view()` - View individual event
- ✅ `create()` - Create events
- ✅ `update()` - Update any event
- ✅ `delete()` - Delete any event
- ✅ `restore()` - Restore soft-deleted events
- ✅ `forceDelete()` - Permanently delete events

**Other Roles:**
- All users - Can create, view events
- Event organizer - Can update/delete their own events

---

### 10. PublicationPolicy ✅
**File:** `app/Policies/PublicationPolicy.php`

**Admin Permissions:**
- ✅ `viewAny()` - View all publications
- ✅ `view()` - View any publication
- ✅ `create()` - Create publications
- ✅ `update()` - Update any publication
- ✅ `delete()` - Delete any publication
- ✅ `restore()` - Restore soft-deleted publications
- ✅ `forceDelete()` - Permanently delete publications
- ✅ `approve()` - Approve/reject publications (change visibility)

**Other Roles:**
- `researcher`, `partial_researcher`, `phd_student` - Can create, view
- Publication owner - Can update/delete their own publications
- All users - Can view public publications

---

## Files Created/Modified

### New Policies Created (5):
1. ✅ `app/Policies/ReservationPolicy.php`
2. ✅ `app/Policies/ProjectPolicy.php`
3. ✅ `app/Policies/MaintenanceLogPolicy.php`
4. ✅ `app/Policies/ExperimentPolicy.php`
5. ✅ `app/Policies/EventPolicy.php`

### Existing Policies Updated (1):
1. ✅ `app/Policies/MaterialCategoryPolicy.php` - Added admin role check

### Existing Policies Verified (4):
1. ✅ `app/Policies/MaterialPolicy.php`
2. ✅ `app/Policies/UserPolicy.php`
3. ✅ `app/Policies/RoomPolicy.php`
4. ✅ `app/Policies/PublicationPolicy.php`

---

## Cache Cleared

All caches have been cleared to ensure policies take effect immediately:
```bash
php artisan cache:clear
php artisan config:clear
php artisan permission:cache-reset
```

---

## Testing Checklist

**As Admin User, you should be able to:**

### Materials
- [ ] View materials list
- [ ] View individual material
- [ ] Create new material
- [ ] Edit any material
- [ ] Delete any material

### Reservations
- [ ] View all reservations
- [ ] View individual reservation
- [ ] Create new reservation
- [ ] Edit any reservation
- [ ] Delete any reservation
- [ ] Approve/reject reservations
- [ ] Cancel any reservation

### Users
- [ ] View users list
- [ ] View individual user
- [ ] Create new user
- [ ] Edit any user
- [ ] Delete any user (except yourself)

### Projects
- [ ] View projects list
- [ ] View individual project
- [ ] Create new project
- [ ] Edit any project
- [ ] Delete any project

### Rooms
- [ ] View rooms list
- [ ] View individual room
- [ ] Create new room
- [ ] Edit any room
- [ ] Delete any room

### Material Categories
- [ ] View categories list
- [ ] View individual category
- [ ] Create new category
- [ ] Edit any category
- [ ] Delete any category

### Maintenance Logs
- [ ] View maintenance logs list
- [ ] View individual log
- [ ] Create new log
- [ ] Edit any log
- [ ] Delete any log

### Experiments
- [ ] View experiments list
- [ ] View individual experiment
- [ ] Create new experiment
- [ ] Edit any experiment
- [ ] Delete any experiment

### Events
- [ ] View events list
- [ ] View individual event
- [ ] Create new event
- [ ] Edit any event
- [ ] Delete any event

### Publications
- [ ] View publications list
- [ ] View individual publication
- [ ] Create new publication
- [ ] Edit any publication
- [ ] Delete any publication
- [ ] Approve/reject publications

---

## Policy Auto-Discovery

Laravel 11 automatically discovers policies based on naming convention:
- `Material` model → `MaterialPolicy`
- `Reservation` model → `ReservationPolicy`
- `User` model → `UserPolicy`
- etc.

No manual registration required in `AuthServiceProvider`.

---

## Role-Based Access Summary

**Admin Role Has:**
- ✅ Full CRUD on all 10 resources
- ✅ Special actions (approve, manage, etc.)
- ✅ Bypass most restrictions
- ⚠️ Cannot delete own user account (safety)

**Other Roles:**
- Specific permissions based on resource type
- Generally can manage their own resources
- View access to most resources
- Create access based on role relevance

---

## Notes

- All policies follow the same pattern for consistency
- Admin checks are always first in conditional logic
- Soft delete support (restore/forceDelete) included
- Special methods for specific actions (approve, cancel, etc.)
- Self-protection rules for User model
- Permission cache cleared after updates

**Admin users now have full CRUD access to all resources in the RLMS application!**
