# Material Permissions Fix

## Problem
Admin users could not add or edit materials because the views were checking for permissions using `@can` directives, but no MaterialPolicy was defined.

## Root Cause
- `resources/views/materials/index.blade.php` line 9: `@can('create', App\Models\Material::class)`
- `resources/views/materials/show.blade.php` line 16: `@can('update', $material)`
- **No MaterialPolicy existed** - Laravel denied all actions by default

## Solution Implemented

### 1. Created MaterialPolicy
**File:** `app/Policies/MaterialPolicy.php`

**Permissions granted:**
- **viewAny()** - All authenticated users can view materials list
- **view()** - All authenticated users can view material details
- **create()** - Admin, Material Manager, and Technician roles can create
- **update()** - Admin, Material Manager, and Technician roles can edit
- **delete()** - Admin role only can delete
- **restore()** - Admin role only
- **forceDelete()** - Admin role only

### 2. Policy Auto-Discovery
Laravel 11 auto-discovers policies using naming convention:
- `Material` model → `MaterialPolicy`
- No manual registration required

### 3. Cleared Permission Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan permission:cache-reset
```

## Testing

### To verify admin access:
1. **Log out** from the admin account
2. **Log back in** to admin account (admin@rlms.test / password)
3. Navigate to Materials page
4. **"Add Material" button should now be visible**
5. Click on any material → **"Edit" button should be visible**

### Test users with material access:
- **admin@rlms.test** - Full access (create, edit, delete)
- **manager@rlms.test** - Full access (create, edit)
- **technician@rlms.test** - Create and edit access
- **researcher@rlms.test** - View only (no add/edit buttons)

## Roles and Material Permissions

| Role | View | Create | Edit | Delete |
|------|------|--------|------|--------|
| admin | ✅ | ✅ | ✅ | ✅ |
| material_manager | ✅ | ✅ | ✅ | ❌ |
| technician | ✅ | ✅ | ✅ | ❌ |
| researcher | ✅ | ❌ | ❌ | ❌ |
| phd_student | ✅ | ❌ | ❌ | ❌ |
| partial_researcher | ✅ | ❌ | ❌ | ❌ |
| guest | ✅ | ❌ | ❌ | ❌ |

## Files Modified

1. **app/Policies/MaterialPolicy.php** - Created new policy
2. **MATERIAL-PERMISSIONS-FIX.md** - This documentation

## Important Notes

1. **Logout Required**: After permission changes, users must log out and log back in
2. **Cache Cleared**: Permission cache has been reset
3. **Auto-Discovery**: Policy is automatically discovered by Laravel
4. **Spatie Permissions**: Uses Spatie Laravel Permission package for role checking

## Troubleshooting

### If buttons still don't appear:

1. **Verify user has admin role:**
```bash
php artisan tinker
>>> $user = User::where('email', 'admin@rlms.test')->first();
>>> $user->getRoleNames();
```
Should return: `["admin"]`

2. **Verify policy is loaded:**
```bash
php artisan tinker
>>> Gate::getPolicyFor(\App\Models\Material::class);
```
Should return: `App\Policies\MaterialPolicy` object

3. **Clear all caches again:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan permission:cache-reset
php artisan optimize:clear
```

4. **Log out and log back in**

### If database was not seeded:

Run seeders to create roles and test users:
```bash
php artisan db:seed --class=RoleAndPermissionSeeder
php artisan db:seed --class=UserSeeder
```

## References

- [Laravel Policies Documentation](https://laravel.com/docs/11.x/authorization#creating-policies)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
