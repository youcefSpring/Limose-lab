# RLMS Application Restructuring Plan
## Simplify to Core Layers Only

**Date:** 2026-01-10
**Objective:** Restructure the application to contain only essential layers: Routes, Migrations, Seeders, Request Validators, Controllers, and Models

---

## Current Application Structure Analysis

### ✅ KEEP - Required Layers
1. **Routes** (`routes/`)
   - ✅ `web.php` - Web routes
   - ✅ `auth.php` - Authentication routes
   - ✅ `console.php` - Console routes
   - ✅ `channels.php` - Broadcasting channels

2. **Migrations** (`database/migrations/`)
   - ✅ 32 migration files
   - All migrations are essential for database schema

3. **Seeders** (`database/seeders/`)
   - ✅ DatabaseSeeder.php
   - ✅ RoleAndPermissionSeeder.php
   - ✅ UserSeeder.php
   - Essential for initial data

4. **Request Validators** (`app/Http/Requests/`)
   - ✅ 16 form request classes
   - Used for validation logic
   - **NOTE:** Currently controllers use inline validation, need to migrate to Form Requests

5. **Controllers** (`app/Http/Controllers/`)
   - ✅ 21 controller files
   - All implement CRUD operations

6. **Models** (`app/Models/`)
   - ✅ 11 model files
   - All represent database entities

### ❌ REMOVE - Non-Essential Layers

#### 1. **Enums** (`app/Enums/`)
**Files:**
- ExperimentStatus.php
- MaintenanceStatus.php
- MaintenanceType.php
- ProjectStatus.php
- ReservationStatus.php
- UserStatus.php

**Strategy:**
- Replace enum usage with string constants in models
- Update database columns to use string values
- Update all controllers/models/views referencing enums

#### 2. **Policies** (`app/Policies/`)
**Files:**
- MaterialPolicy.php
- ProjectPolicy.php
- UserPolicy.php
- EventPolicy.php
- ReservationPolicy.php
- ExperimentPolicy.php

**Strategy:**
- Remove authorization checks from controllers
- Keep basic `auth` middleware only
- Remove policy service provider registration

#### 3. **Observers** (`app/Observers/`)
**Files:**
- Various model observers for lifecycle events

**Strategy:**
- Move critical logic to controller methods
- Remove observer registration from providers

#### 4. **Events** (`app/Events/`)
**Files:**
- Custom event classes

**Strategy:**
- Remove event dispatching from controllers
- Delete event classes
- Remove from EventServiceProvider

#### 5. **Listeners** (`app/Listeners/`)
**Files:**
- Event listener classes

**Strategy:**
- Remove listener registration
- Delete listener files

#### 6. **Notifications** (`app/Notifications/`)
**Files:**
- Custom notification classes

**Strategy:**
- Remove notification sending from controllers
- Keep database notifications table for manual entries
- Remove notification classes

#### 7. **Jobs** (`app/Jobs/`)
**Files:**
- Queue job classes

**Strategy:**
- Move job logic directly into controllers
- Remove queue configuration
- Delete job classes

#### 8. **Services** (`app/Services/`)
**Files:**
- Business logic service classes

**Strategy:**
- Move service logic into controllers or models
- Keep controllers as "fat controllers" if needed
- Delete service classes

#### 9. **Helpers** (`app/Helpers/`)
**Files:**
- Helper function files

**Strategy:**
- Move essential helpers to Laravel's helpers.php
- Remove custom helper directory

#### 10. **View Components** (`app/View/Components/`)
**Files:**
- Blade component classes

**Strategy:**
- Keep anonymous components in views
- Remove component classes
- Update Blade views to use basic includes

#### 11. **Resources** (`app/Http/Resources/`)
**Files:**
- API resource classes (if any)

**Strategy:**
- Remove if not used
- If API needed, return plain arrays from controllers

#### 12. **Middleware** (Custom Only - `app/Http/Middleware/`)
**Keep Laravel's default middleware:**
- Authenticate.php
- RedirectIfAuthenticated.php
- TrustProxies.php
- VerifyCsrfToken.php
- etc.

**Remove custom middleware:**
- Any application-specific middleware

---

## Implementation Steps

### Phase 1: Prepare and Backup (CRITICAL)
```bash
# Create backup of current application
cd /home/charikatec/Desktop/my\ docs/labo
cp -r rlms rlms-backup-$(date +%Y%m%d-%H%M%S)

# Create git commit before changes
cd rlms
git add .
git commit -m "Backup before restructuring to core layers"
```

### Phase 2: Replace Enums with String Constants

#### Step 1: Update Models to Use String Casts
**Files to modify:**
- `app/Models/User.php`
- `app/Models/Reservation.php`
- `app/Models/Project.php`
- `app/Models/Experiment.php`
- `app/Models/MaintenanceLog.php`

**Changes:**
```php
// BEFORE (with enum):
protected function casts(): array
{
    return [
        'status' => UserStatus::class,
    ];
}

// AFTER (with string):
protected function casts(): array
{
    return [
        'status' => 'string',
    ];
}
```

#### Step 2: Update Controllers
Replace all enum comparisons:
```php
// BEFORE:
if ($user->status === UserStatus::ACTIVE)

// AFTER:
if ($user->status === 'active')
```

#### Step 3: Update Views
Replace enum value access:
```php
// BEFORE:
{{ $project->status->value }}

// AFTER:
{{ $project->status }}
```

#### Step 4: Update Database Migrations
Ensure status columns use string type:
```php
$table->enum('status', ['active', 'pending', 'suspended', 'banned'])->default('pending');
// OR
$table->string('status')->default('pending');
```

#### Step 5: Delete Enum Files
```bash
rm -rf app/Enums/
```

### Phase 3: Remove Policies and Authorization

#### Step 1: Remove Policy Checks from Controllers
```php
// BEFORE:
$this->authorize('update', $material);

// AFTER:
// Remove line entirely
```

#### Step 2: Remove Gate Definitions
Edit `app/Providers/AuthServiceProvider.php`:
```php
// REMOVE all policy registrations
protected $policies = [];

public function boot(): void
{
    // Keep empty or only basic registrations
}
```

#### Step 3: Remove @can/@cannot from Views
```php
// BEFORE:
@can('update', $material)
    <button>Edit</button>
@endcan

// AFTER:
@auth
    <button>Edit</button>
@endauth
```

#### Step 4: Delete Policy Files
```bash
rm -rf app/Policies/
```

### Phase 4: Remove Observers

#### Step 1: Remove Observer Registration
Edit `app/Providers/EventServiceProvider.php`:
```php
// REMOVE observer registration from boot() method
```

#### Step 2: Move Critical Logic to Controllers
Example: If MaterialObserver had logic on delete:
```php
// Move from Observer to MaterialController destroy():
public function destroy(Material $material)
{
    // Add observer logic here if critical
    if ($material->image) {
        \Storage::disk('public')->delete($material->image);
    }
    $material->delete();
}
```

#### Step 3: Delete Observer Files
```bash
rm -rf app/Observers/
```

### Phase 5: Remove Events and Listeners

#### Step 1: Remove Event Dispatching from Code
```php
// BEFORE:
event(new MaterialCreated($material));

// AFTER:
// Remove line
```

#### Step 2: Clean EventServiceProvider
```php
protected $listen = [];
```

#### Step 3: Delete Files
```bash
rm -rf app/Events/
rm -rf app/Listeners/
```

### Phase 6: Remove Notifications

#### Step 1: Remove Notification Sending
```php
// BEFORE:
$user->notify(new ReservationApproved($reservation));

// AFTER:
// Remove line or add manual notification record if needed
```

#### Step 2: Delete Notification Files
```bash
rm -rf app/Notifications/
```

### Phase 7: Remove Jobs and Queues

#### Step 1: Move Job Logic to Controllers
```php
// If job was processing something:
// Move logic directly into controller action
```

#### Step 2: Remove Queue Configuration
Edit `.env`:
```
QUEUE_CONNECTION=sync
```

#### Step 3: Delete Job Files
```bash
rm -rf app/Jobs/
```

### Phase 8: Remove Services

#### Step 1: Move Service Methods to Controllers
```php
// BEFORE:
class MaterialService {
    public function updateStock($material, $quantity) {
        // logic
    }
}

// AFTER: In MaterialController
public function updateStock(Request $request, Material $material)
{
    // Move service logic here
}
```

#### Step 2: Remove Service Injections
```php
// BEFORE:
public function __construct(MaterialService $service)

// AFTER:
// Remove constructor injection
```

#### Step 3: Delete Service Files
```bash
rm -rf app/Services/
```

### Phase 9: Remove Helpers

#### Step 1: Move Essential Functions
If you have critical helpers, move to `bootstrap/helpers.php`:
```php
// Create bootstrap/helpers.php if needed
if (!function_exists('format_date')) {
    function format_date($date) {
        return $date->format('Y-m-d');
    }
}
```

#### Step 2: Require in composer.json
```json
"autoload": {
    "files": [
        "bootstrap/helpers.php"
    ]
}
```

#### Step 3: Delete Helper Directory
```bash
rm -rf app/Helpers/
```

### Phase 10: Remove View Components

#### Step 1: Convert Component Usage
```php
// BEFORE:
<x-material-card :material="$material" />

// AFTER:
@include('partials.material-card', ['material' => $material])
```

#### Step 2: Delete Component Classes
```bash
rm -rf app/View/
```

### Phase 11: Remove API Resources

#### Step 1: Return Arrays Directly
```php
// BEFORE:
return MaterialResource::collection($materials);

// AFTER:
return response()->json($materials);
```

#### Step 2: Delete Resource Files
```bash
rm -rf app/Http/Resources/
```

### Phase 12: Migrate Inline Validation to Form Requests

#### Step 1: Create Form Request for Each Action
Example for MaterialController:
```bash
php artisan make:request StoreMaterialRequest
php artisan make:request UpdateMaterialRequest
```

#### Step 2: Move Validation Rules
```php
// In StoreMaterialRequest.php:
public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        // ... all validation rules
    ];
}
```

#### Step 3: Use Form Request in Controller
```php
// BEFORE:
public function store(Request $request)
{
    $validated = $request->validate([...]);
}

// AFTER:
public function store(StoreMaterialRequest $request)
{
    $validated = $request->validated();
}
```

### Phase 13: Clean Up Providers

#### Step 1: Update AppServiceProvider
```php
// Keep minimal configuration only
public function boot(): void
{
    // Basic settings only
}
```

#### Step 2: Update AuthServiceProvider
```php
// Remove policy registrations
protected $policies = [];
```

#### Step 3: Update EventServiceProvider
```php
// Remove event listeners
protected $listen = [];
```

---

## Final Directory Structure

```
rlms/
├── app/
│   ├── Console/                    # Keep (Laravel default)
│   ├── Http/
│   │   ├── Controllers/           ✅ KEEP (21 files)
│   │   ├── Middleware/            # Keep (Laravel defaults only)
│   │   └── Requests/              ✅ KEEP (16+ files)
│   ├── Models/                    ✅ KEEP (11 files)
│   └── Providers/                 # Keep (Laravel defaults)
├── database/
│   ├── migrations/                ✅ KEEP (32 files)
│   └── seeders/                   ✅ KEEP (3 files)
├── routes/
│   ├── web.php                    ✅ KEEP
│   ├── auth.php                   ✅ KEEP
│   ├── console.php                ✅ KEEP
│   └── channels.php               ✅ KEEP
└── ...

REMOVED:
❌ app/Enums/
❌ app/Policies/
❌ app/Observers/
❌ app/Events/
❌ app/Listeners/
❌ app/Notifications/
❌ app/Jobs/
❌ app/Services/
❌ app/Helpers/
❌ app/View/Components/
❌ app/Http/Resources/
```

---

## Testing After Restructuring

### Test Checklist
```bash
# 1. Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 2. Regenerate autoload
composer dump-autoload

# 3. Run migrations (fresh)
php artisan migrate:fresh --seed

# 4. Test critical routes
# - Login
# - Dashboard
# - Materials CRUD
# - Reservations CRUD
# - Projects CRUD
# - Events CRUD
# - Experiments CRUD
# - Users CRUD
# - Maintenance CRUD
```

---

## Risk Assessment

### High Risk Changes
1. **Enum Removal** - Affects many files
   - Risk: Breaking existing queries and comparisons
   - Mitigation: Search and replace all enum usage

2. **Policy Removal** - Removes authorization
   - Risk: Security holes, unauthorized access
   - Mitigation: Add basic role checks in controllers

3. **Service Removal** - Business logic distribution
   - Risk: Fat controllers, code duplication
   - Mitigation: Keep logic organized within controllers

### Medium Risk Changes
1. **Observer Removal** - Lifecycle hooks lost
   - Risk: Missing side effects (file deletion, etc.)
   - Mitigation: Move critical logic to controller methods

2. **Notification Removal** - User communication
   - Risk: Users not notified of important events
   - Mitigation: Manual notification system if needed

### Low Risk Changes
1. **Helper Removal** - Utility functions
2. **View Component Removal** - UI components
3. **Resource Removal** - API transformation

---

## Estimated Time

- Phase 1 (Backup): 10 minutes
- Phase 2 (Enums): 2 hours
- Phase 3 (Policies): 1 hour
- Phase 4 (Observers): 30 minutes
- Phase 5 (Events/Listeners): 30 minutes
- Phase 6 (Notifications): 30 minutes
- Phase 7 (Jobs): 30 minutes
- Phase 8 (Services): 1 hour
- Phase 9 (Helpers): 20 minutes
- Phase 10 (View Components): 1 hour
- Phase 11 (Resources): 20 minutes
- Phase 12 (Form Requests): 3 hours
- Phase 13 (Providers): 30 minutes

**Total: ~11 hours**

---

## Alternative: Conservative Approach

If you want to keep the application functional but simplified:

1. **Keep Enums** - They're actually helpful for type safety
2. **Remove** Policies, Observers, Events, Listeners, Notifications, Jobs, Services
3. **Keep** Helpers (if few), View Components (if many views use them)
4. **Migrate** to Form Requests gradually

This reduces time to ~5 hours and keeps some helpful features.

---

## Recommendation

**I recommend the Conservative Approach** because:
1. Enums provide type safety and prevent bugs
2. Removing everything at once is high risk
3. Form Requests are valuable for clean validation
4. You can always remove more later if needed

**Core layers that MUST be kept:**
- ✅ Routes
- ✅ Migrations
- ✅ Seeders
- ✅ Request Validators (Form Requests)
- ✅ Controllers
- ✅ Models

**Layers that can be removed safely:**
- ❌ Policies (replace with basic auth checks)
- ❌ Observers (move logic to controllers)
- ❌ Events/Listeners (remove event-driven code)
- ❌ Notifications (remove or manual system)
- ❌ Jobs (move to controllers, no queues)
- ❌ Services (move to controllers/models)

**Layers to consider keeping:**
- 🤔 Enums (useful for type safety)
- 🤔 Helpers (if few, useful functions)
- 🤔 View Components (if many views depend on them)

---

**Next Steps:**
1. Review this plan
2. Decide: Full removal or Conservative approach
3. Create backup
4. Execute plan phase by phase
5. Test after each phase
