# RLMS Complete Implementation Plan

## Current System Analysis

### ✅ What's Already Implemented:

1. **Role & Permission System** (Spatie Laravel Permission)
   - Roles: admin, researcher, phd_student, partial_researcher, technician, material_manager, guest
   - 40+ permissions covering all modules
   - Users can have multiple roles via Spatie

2. **Seeders**
   - RoleAndPermissionSeeder: Creates all roles and permissions
   - UserSeeder: Creates sample users for each role
   - SettingSeeder: Creates frontend content settings

3. **Settings Management**
   - Model: `App\Models\Setting`
   - Controller: `App\Http\Controllers\SettingController`
   - Routes: `/settings` (index, update)
   - View: `resources/views/settings/index.blade.php`
   - Groups: general, frontend_hero, frontend_about, frontend_contact, appearance
   - Supports: text, textarea, image types
   - Cache: Redis with 3600s TTL

4. **User Model**
   - Uses `HasRoles` trait from Spatie
   - Already supports multiple roles
   - Fields: name, email, research_group, bio, status, locale, avatar

---

## 🎯 Required Implementations

### Phase 1: Enhanced User & Role System

#### 1.1 Add Role Types to Database
**Goal**: Differentiate between fulltime and part-time researchers

**Tasks**:
- [ ] Add migration for `user_role` pivot table with `employment_type` column
- [ ] Values: `fulltime`, `parttime`, `contract`, `visiting`
- [ ] Update UserSeeder to assign employment types
- [ ] Update role assignment methods

**Files to modify**:
```php
// Create new migration
database/migrations/XXXX_add_employment_type_to_model_has_roles_table.php

// Update UserSeeder
database/seeders/UserSeeder.php
```

**Implementation**:
```php
// In migration
Schema::table('model_has_roles', function (Blueprint $table) {
    $table->enum('employment_type', ['fulltime', 'parttime', 'contract', 'visiting'])->nullable();
    $table->text('additional_info')->nullable();
});

// In UserSeeder
$researcher->assignRole('researcher');
DB::table('model_has_roles')
    ->where('model_id', $researcher->id)
    ->where('role_id', Role::where('name', 'researcher')->first()->id)
    ->update(['employment_type' => 'fulltime']);
```

---

#### 1.2 Update UserSeeder with All Required Roles

**Tasks**:
- [x] Admin (already exists)
- [ ] Fulltime Researcher (update existing)
- [ ] Part-time Researcher (add new)
- [x] PhD Student (already exists)
- [ ] Maintenance Worker (rename technician or add new)
- [ ] Add research publications data for researchers

**New User Types**:
```php
// Fulltime Researcher
$fulltimeResearcher = User::create([
    'name' => 'Dr. John Researcher',
    'email' => 'fulltime@rlms.test',
    'password' => Hash::make('password'),
    'status' => 'active',
    'research_group' => 'Molecular Biology',
    'bio' => 'Full-time researcher with 10+ years experience',
    'employment_type' => 'fulltime',
]);
$fulltimeResearcher->assignRole('researcher');

// Part-time Researcher
$parttimeResearcher = User::create([
    'name' => 'Dr. Jane Smith',
    'email' => 'parttime@rlms.test',
    'employment_type' => 'parttime',
]);
$parttimeResearcher->assignRole('partial_researcher');

// Maintenance Worker
$maintenanceWorker = User::create([
    'name' => 'Mike Maintenance',
    'email' => 'maintenance@rlms.test',
    'employment_type' => 'fulltime',
]);
$maintenanceWorker->assignRole('technician');
```

---

### Phase 2: Enhanced Settings Management System

#### 2.1 Expand Settings for Complete Frontend Control

**Current Settings Groups**:
- [x] general (site_name, contact_email, contact_phone)
- [x] frontend_hero (hero_title, hero_subtitle)
- [x] frontend_about (about_description, stats)
- [x] frontend_contact (location, email, hours)
- [x] appearance (logo, favicon)

**New Settings to Add**:

**A. Laboratory Information**:
```php
// Group: lab_info
[
    ['key' => 'lab_name', 'value' => 'Research Laboratory', 'type' => 'text', 'group' => 'lab_info'],
    ['key' => 'lab_full_name', 'value' => 'Advanced Research Laboratory', 'type' => 'text', 'group' => 'lab_info'],
    ['key' => 'lab_description', 'value' => '...', 'type' => 'textarea', 'group' => 'lab_info'],
    ['key' => 'lab_mission', 'value' => '...', 'type' => 'textarea', 'group' => 'lab_info'],
    ['key' => 'lab_vision', 'value' => '...', 'type' => 'textarea', 'group' => 'lab_info'],
    ['key' => 'established_year', 'value' => '2020', 'type' => 'text', 'group' => 'lab_info'],
    ['key' => 'director_name', 'value' => 'Dr. Director', 'type' => 'text', 'group' => 'lab_info'],
]

// Group: lab_location
[
    ['key' => 'building_name', 'value' => 'Research Building', 'type' => 'text', 'group' => 'lab_location'],
    ['key' => 'floor_number', 'value' => '3rd Floor', 'type' => 'text', 'group' => 'lab_location'],
    ['key' => 'room_number', 'value' => 'Room 301', 'type' => 'text', 'group' => 'lab_location'],
    ['key' => 'full_address', 'value' => '...', 'type' => 'textarea', 'group' => 'lab_location'],
    ['key' => 'city', 'value' => 'City', 'type' => 'text', 'group' => 'lab_location'],
    ['key' => 'country', 'value' => 'Country', 'type' => 'text', 'group' => 'lab_location'],
    ['key' => 'postal_code', 'value' => '12345', 'type' => 'text', 'group' => 'lab_location'],
    ['key' => 'latitude', 'value' => '0.0', 'type' => 'text', 'group' => 'lab_location'],
    ['key' => 'longitude', 'value' => '0.0', 'type' => 'text', 'group' => 'lab_location'],
]

// Group: lab_contact
[
    ['key' => 'main_phone', 'value' => '+1234567890', 'type' => 'text', 'group' => 'lab_contact'],
    ['key' => 'fax', 'value' => '+1234567891', 'type' => 'text', 'group' => 'lab_contact'],
    ['key' => 'general_email', 'value' => 'info@lab.edu', 'type' => 'text', 'group' => 'lab_contact'],
    ['key' => 'support_email', 'value' => 'support@lab.edu', 'type' => 'text', 'group' => 'lab_contact'],
    ['key' => 'office_hours', 'value' => 'Mon-Fri 9AM-5PM', 'type' => 'text', 'group' => 'lab_contact'],
]

// Group: lab_social
[
    ['key' => 'website_url', 'value' => 'https://lab.edu', 'type' => 'text', 'group' => 'lab_social'],
    ['key' => 'facebook_url', 'value' => '', 'type' => 'text', 'group' => 'lab_social'],
    ['key' => 'twitter_url', 'value' => '', 'type' => 'text', 'group' => 'lab_social'],
    ['key' => 'linkedin_url', 'value' => '', 'type' => 'text', 'group' => 'lab_social'],
    ['key' => 'youtube_url', 'value' => '', 'type' => 'text', 'group' => 'lab_social'],
]

// Group: research_areas
[
    ['key' => 'research_area_1_title', 'value' => 'Molecular Biology', 'type' => 'text', 'group' => 'research_areas'],
    ['key' => 'research_area_1_desc', 'value' => '...', 'type' => 'textarea', 'group' => 'research_areas'],
    ['key' => 'research_area_1_icon', 'value' => null, 'type' => 'image', 'group' => 'research_areas'],
    // Repeat for area 2, 3, 4...
]
```

**B. Multilingual Support**:
```php
// Group: localization
[
    ['key' => 'default_locale', 'value' => 'en', 'type' => 'select', 'group' => 'localization', 'options' => 'en,fr,ar'],
    ['key' => 'available_locales', 'value' => 'en,fr,ar', 'type' => 'text', 'group' => 'localization'],
    ['key' => 'rtl_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'localization'],
]

// For multilingual content, use pattern: setting_key_{locale}
[
    ['key' => 'about_description_en', 'value' => 'English description', 'type' => 'textarea', 'group' => 'frontend_about'],
    ['key' => 'about_description_fr', 'value' => 'Description française', 'type' => 'textarea', 'group' => 'frontend_about'],
    ['key' => 'about_description_ar', 'value' => 'وصف عربي', 'type' => 'textarea', 'group' => 'frontend_about'],
]
```

**C. Images & Branding**:
```php
// Group: branding
[
    ['key' => 'primary_logo', 'value' => null, 'type' => 'image', 'group' => 'branding'],
    ['key' => 'secondary_logo', 'value' => null, 'type' => 'image', 'group' => 'branding'],
    ['key' => 'logo_dark', 'value' => null, 'type' => 'image', 'group' => 'branding'],
    ['key' => 'favicon', 'value' => null, 'type' => 'image', 'group' => 'branding'],
    ['key' => 'hero_background', 'value' => null, 'type' => 'image', 'group' => 'branding'],
    ['key' => 'about_image', 'value' => null, 'type' => 'image', 'group' => 'branding'],
    ['key' => 'primary_color', 'value' => '#8C1515', 'type' => 'color', 'group' => 'branding'],
    ['key' => 'secondary_color', 'value' => '#F9F6F2', 'type' => 'color', 'group' => 'branding'],
]
```

---

#### 2.2 Update Settings Migration

**Tasks**:
- [ ] Add `options` column for select-type settings
- [ ] Add `is_multilingual` boolean column
- [ ] Add `order` column for sorting

**Migration**:
```php
Schema::table('settings', function (Blueprint $table) {
    $table->text('options')->nullable()->after('type');
    $table->boolean('is_multilingual')->default(false)->after('options');
    $table->integer('order')->default(0)->after('is_multilingual');
    $table->string('category')->nullable()->after('group'); // For sub-categorization
});
```

---

#### 2.3 Enhance Setting Model

**Add Methods**:
```php
// Get setting with locale support
public static function getLocalized($key, $locale = null, $default = null)
{
    $locale = $locale ?? app()->getLocale();
    $localizedKey = "{$key}_{$locale}";

    $value = self::get($localizedKey);
    if ($value !== null) {
        return $value;
    }

    return self::get($key, $default);
}

// Get settings by group
public static function getByGroup($group)
{
    return Cache::remember("settings_group_{$group}", 3600, function () use ($group) {
        return self::where('group', $group)->get()->pluck('value', 'key');
    });
}

// Get all settings grouped
public static function getAllGrouped()
{
    return Cache::remember('settings_all_grouped', 3600, function () {
        return self::orderBy('group')->orderBy('order')->get()->groupBy('group');
    });
}
```

---

#### 2.4 Enhanced Settings Controller

**Update for Better UX**:
```php
public function index()
{
    $settings = Setting::getAllGrouped();
    $locales = ['en', 'fr', 'ar'];

    return view('settings.index', compact('settings', 'locales'));
}

public function update(Request $request)
{
    foreach ($request->settings as $key => $value) {
        $setting = Setting::where('key', $key)->first();

        if ($setting) {
            // Handle file uploads
            if ($setting->type === 'image' && $request->hasFile("settings.{$key}")) {
                // Delete old image
                if ($setting->value && Storage::disk('public')->exists($setting->value)) {
                    Storage::disk('public')->delete($setting->value);
                }

                $path = $request->file("settings.{$key}")->store('settings', 'public');
                $value = $path;
            }

            // Handle boolean
            if ($setting->type === 'boolean') {
                $value = $request->has("settings.{$key}") ? '1' : '0';
            }

            $setting->update(['value' => $value]);
        }
    }

    Setting::clearCache();

    return redirect()->route('settings.index')
        ->with('success', __('Settings updated successfully!'));
}
```

---

### Phase 3: User Content Contributions

#### 3.1 Research Publications System

**Create Models**:
```php
// app/Models/Publication.php
class Publication extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'abstract',
        'authors', // JSON array
        'journal',
        'publication_date',
        'doi',
        'url',
        'pdf_file',
        'status', // draft, submitted, published
        'citation_count',
        'keywords', // JSON array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

**Migration**:
```php
Schema::create('publications', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('title');
    $table->text('abstract')->nullable();
    $table->json('authors'); // [{name, affiliation, email}]
    $table->string('journal')->nullable();
    $table->date('publication_date')->nullable();
    $table->string('doi')->nullable();
    $table->string('url')->nullable();
    $table->string('pdf_file')->nullable();
    $table->enum('status', ['draft', 'submitted', 'published'])->default('draft');
    $table->integer('citation_count')->default(0);
    $table->json('keywords')->nullable();
    $table->boolean('is_public')->default(false);
    $table->timestamps();
});
```

---

#### 3.2 Research News/Blog System

**Create Models**:
```php
// app/Models/ResearchNews.php
class ResearchNews extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'category', // discovery, achievement, event, announcement
        'status', // draft, pending, published
        'published_at',
        'tags', // JSON
    ];
}
```

---

### Phase 4: Authorization & Permissions

#### 4.1 Add Settings Permissions

**Update RoleAndPermissionSeeder**:
```php
$permissions = [
    // ... existing permissions

    // Settings management
    'settings.view',
    'settings.update',
    'settings.manage-branding',
    'settings.manage-localization',

    // Publications
    'publications.index',
    'publications.create',
    'publications.update',
    'publications.delete',
    'publications.approve', // For admin

    // Research News
    'news.index',
    'news.create',
    'news.update',
    'news.delete',
    'news.publish', // For admin
];

// Admin gets all
$admin->givePermissionTo(Permission::all());

// Researchers can manage their publications
$researcher->givePermissionTo([
    'publications.index',
    'publications.create',
    'publications.update',
    'news.index',
    'news.create',
]);
```

---

#### 4.2 Add Policies

**PublicationPolicy**:
```php
public function create(User $user)
{
    return $user->hasAnyRole(['admin', 'researcher', 'phd_student']);
}

public function update(User $user, Publication $publication)
{
    return $user->id === $publication->user_id || $user->hasRole('admin');
}

public function publish(User $user, Publication $publication)
{
    return $user->hasRole('admin');
}
```

---

### Phase 5: Admin Dashboard Enhancements

#### 5.1 Settings Management UI

**Improve settings/index.blade.php**:
```blade
<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1>{{ __('System Settings') }}</h1>

        <!-- Tab Navigation -->
        <div class="tabs">
            <button onclick="showTab('general')">{{ __('General') }}</button>
            <button onclick="showTab('lab-info')">{{ __('Lab Information') }}</button>
            <button onclick="showTab('branding')">{{ __('Branding') }}</button>
            <button onclick="showTab('localization')">{{ __('Localization') }}</button>
            <button onclick="showTab('frontend')">{{ __('Frontend Content') }}</button>
        </div>

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- General Tab -->
            <div id="tab-general" class="tab-content">
                @foreach($settings['general'] ?? [] as $setting)
                    @include('settings.partials.field', ['setting' => $setting])
                @endforeach
            </div>

            <!-- Lab Info Tab -->
            <div id="tab-lab-info" class="tab-content hidden">
                @foreach($settings['lab_info'] ?? [] as $setting)
                    @if($setting->is_multilingual)
                        @foreach($locales as $locale)
                            @include('settings.partials.multilingual-field', [
                                'setting' => $setting,
                                'locale' => $locale
                            ])
                        @endforeach
                    @else
                        @include('settings.partials.field', ['setting' => $setting])
                    @endif
                @endforeach
            </div>

            <!-- Branding Tab -->
            <div id="tab-branding" class="tab-content hidden">
                @foreach($settings['branding'] ?? [] as $setting)
                    @include('settings.partials.field', ['setting' => $setting])
                @endforeach
            </div>

            <button type="submit" class="btn-primary">
                {{ __('Save Settings') }}
            </button>
        </form>
    </div>
</x-app-layout>
```

**Create Partial Views**:
```blade
<!-- settings/partials/field.blade.php -->
<div class="form-group">
    <label for="{{ $setting->key }}">{{ __(ucwords(str_replace('_', ' ', $setting->key))) }}</label>

    @if($setting->type === 'text')
        <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}">

    @elseif($setting->type === 'textarea')
        <textarea name="settings[{{ $setting->key }}]" rows="4">{{ $setting->value }}</textarea>

    @elseif($setting->type === 'image')
        @if($setting->value)
            <img src="{{ asset('storage/' . $setting->value) }}" class="preview-image">
        @endif
        <input type="file" name="settings[{{ $setting->key }}]" accept="image/*">

    @elseif($setting->type === 'boolean')
        <input type="checkbox" name="settings[{{ $setting->key }}]" {{ $setting->value ? 'checked' : '' }}>

    @elseif($setting->type === 'color')
        <input type="color" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}">

    @elseif($setting->type === 'select')
        <select name="settings[{{ $setting->key }}]">
            @foreach(explode(',', $setting->options) as $option)
                <option value="{{ $option }}" {{ $setting->value == $option ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endforeach
        </select>
    @endif
</div>
```

---

### Phase 6: Multi-Role Implementation

#### 6.1 Allow Users to Have Multiple Roles

**User Assignment Example**:
```php
// A user can be both a researcher AND a maintenance worker
$user = User::find(1);
$user->assignRole(['researcher', 'technician']);

// Check if user has any role
$user->hasAnyRole(['researcher', 'admin']); // true

// Check if user has all roles
$user->hasAllRoles(['researcher', 'admin']); // false

// Get all user roles
$user->getRoleNames(); // Collection: ['researcher', 'technician']
```

**Update Middleware/Policies**:
```php
// Instead of:
if ($user->hasRole('admin')) { ... }

// Use:
if ($user->hasAnyRole(['admin', 'material_manager'])) { ... }
```

---

## 📋 Implementation Checklist

### Week 1: Database & Seeders
- [ ] Create migration for employment_type in model_has_roles
- [ ] Update UserSeeder with all role types
- [ ] Add fulltime/parttime researchers
- [ ] Add maintenance worker users
- [ ] Test multi-role assignment

### Week 2: Enhanced Settings
- [ ] Create migration for settings enhancements (options, is_multilingual, order)
- [ ] Update SettingSeeder with all new settings groups
- [ ] Add lab_info, lab_location, lab_contact, lab_social, research_areas, localization, branding
- [ ] Test settings CRUD

### Week 3: Settings UI
- [ ] Create tabbed settings interface
- [ ] Add partial views for different field types
- [ ] Implement multilingual field support
- [ ] Add image upload with preview
- [ ] Add color picker
- [ ] Test settings update

### Week 4: User Contributions
- [ ] Create publications migration & model
- [ ] Create PublicationController
- [ ] Create publication views (index, create, edit)
- [ ] Add publication policies
- [ ] Test publication CRUD for researchers

### Week 5: Frontend Integration
- [ ] Update welcome.blade.php to use Setting::get()
- [ ] Add multilingual support to frontend
- [ ] Display research areas from settings
- [ ] Display publications on frontend
- [ ] Add social media links from settings

### Week 6: Testing & Documentation
- [ ] Test all roles with different permissions
- [ ] Test multi-role users
- [ ] Test settings management
- [ ] Test user contributions
- [ ] Create user manual
- [ ] Create admin guide

---

## 🔐 Security Considerations

1. **Settings Access**: Only admins can modify settings
2. **User Contributions**: Users can only edit their own content (unless admin)
3. **Image Uploads**: Validate file types and sizes
4. **XSS Protection**: Sanitize user-generated content
5. **CSRF Protection**: All forms protected
6. **Role Verification**: Check permissions at controller and view level

---

## 📝 Testing Scenarios

### Role-Based Access
```
Admin:
  ✓ Can access all settings
  ✓ Can manage all users
  ✓ Can approve publications
  ✓ Full CRUD on all resources

Fulltime Researcher:
  ✓ Can create/edit own publications
  ✓ Can create/manage projects
  ✓ Can reserve materials
  ✓ Cannot access admin settings

Parttime Researcher:
  ✓ Can view research
  ✓ Limited create permissions
  ✓ Cannot manage projects

PhD Student:
  ✓ Can participate in projects
  ✓ Can create experiments
  ✓ Cannot create projects

Maintenance Worker:
  ✓ Can manage maintenance logs
  ✓ Can update material status
  ✓ Cannot access research data
```

---

## 🚀 Deployment Steps

1. Backup database
2. Run migrations: `php artisan migrate`
3. Run seeders: `php artisan db:seed`
4. Clear cache: `php artisan cache:clear`
5. Clear config: `php artisan config:clear`
6. Optimize: `php artisan optimize`
7. Test critical features
8. Deploy to production

---

## Default Credentials (After Seeding)

```
Admin: admin@rlms.test / password
Fulltime Researcher: researcher@rlms.test / password
Parttime Researcher: parttime@rlms.test / password
PhD Student: phd@rlms.test / password
Maintenance: maintenance@rlms.test / password
```
