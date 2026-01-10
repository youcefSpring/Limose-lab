# web-module.md

## Modules Spécifiques Application Web RLMS

Ce document détaille l'implémentation spécifique des modules pour l'application web Laravel.

---

## 1. Scope & Ownership

### Application Web
**Type :** Plateforme web monolithique Laravel
**Users :** Tous les utilisateurs (admin, material_manager, researcher, phd_student, partial_researcher, technician, guest)
**Accès :** Navigateur web (desktop/mobile responsive)

### Responsabilités
- Authentification et gestion sessions
- Interface utilisateur complète (CRUD toutes entités)
- Gestion permissions et rôles
- Notifications email et in-app
- Rapports et exports
- Upload/download fichiers

---

## 2. Domain Model

### Entités Principales
```
User
├── roles (many-to-many via Spatie)
├── permissions (many-to-many via Spatie)
├── reservations (one-to-many)
├── projects (many-to-many via project_user)
├── experiments (one-to-many)
├── notifications (one-to-many)
└── maintenance_logs (one-to-many)

Material
├── category (belongs-to)
├── reservations (one-to-many)
└── maintenance_logs (one-to-many)

Reservation
├── user (belongs-to)
├── material (belongs-to)
└── validator (belongs-to User)

Project
├── creator (belongs-to User)
├── members (many-to-many via project_user)
└── experiments (one-to-many)

Experiment
├── project (belongs-to)
├── user (belongs-to)
├── files (one-to-many)
└── comments (one-to-many)

Event
├── creator (belongs-to User)
└── attendees (many-to-many via event_attendees)

MaintenanceLog
├── material (belongs-to)
└── technician (belongs-to User)
```

### États et Transitions
Voir **03-ValidationAndStates.md**

---

## 3. Interfaces (UI, Routes, Endpoints)

### Architecture Routes
```
routes/web.php
├── Auth routes (public)
├── Dashboard (auth)
├── Profile (auth)
├── Materials (auth, permission-based)
├── Reservations (auth, permission-based)
├── Projects (auth, permission-based)
├── Experiments (auth, permission-based)
├── Events (auth, permission-based)
├── Maintenance (auth, permission-based)
├── Reports (auth, permission-based)
├── Notifications (auth)
└── Admin (auth, role:admin)
```

### Pages Principales

**Layouts :**
- `resources/views/layouts/app.blade.php` : Layout principal authentifié
- `resources/views/layouts/guest.blade.php` : Layout pages publiques
- `resources/views/layouts/navigation.blade.php` : Menu navigation dynamique selon rôle

**Dashboards par Rôle :**
- Admin : `dashboard/admin.blade.php` - Stats globales, users pending, alertes système
- Material Manager : `dashboard/index.blade.php` - Réservations pending, équipements maintenance
- Researcher : `dashboard/researcher.blade.php` - Mes réservations, mes projets, notifications
- Technician : `dashboard/technician.blade.php` - Maintenance schedule, équipements

**Composants Réutilisables :**
```blade
<x-alert type="success|error|warning|info" />
<x-button variant="primary|secondary|danger" />
<x-input name="..." label="..." />
<x-select name="..." :options="[]" />
<x-modal title="..." />
<x-card title="...">content</x-card>
<x-table :headers="[]" :rows="[]" />
<x-badge status="pending|approved|rejected" />
```

---

## 4. Workflows MVP/V1/V2

### MVP (Phase 1)
**Durée estimée :** 4-6 semaines

**Modules :**
1. **Authentication** (semaine 1)
   - Login, Register, Forgot Password
   - User status: pending → active
   - Email verification

2. **User Management** (semaine 1)
   - Admin: approve users, assign roles
   - Profile edit

3. **Materials** (semaine 2)
   - CRUD équipements
   - Catégories
   - Recherche/filtres AJAX

4. **Reservations** (semaine 3-4)
   - Création réservation
   - Validation disponibilité
   - Workflow approbation (material_manager)
   - Calendrier basique

5. **Dashboard** (semaine 4)
   - Dashboard personnalisé par rôle
   - Notifications basiques (DB)

6. **Notifications Email** (semaine 4)
   - Envoi emails via queue
   - Templates notifications clés

**Critères Acceptance MVP :**
- ✓ User peut s'inscrire et être approuvé
- ✓ User peut réserver équipement
- ✓ Material manager peut valider réservations
- ✓ Détection conflits réservations fonctionne
- ✓ Emails notifications envoyés
- ✓ Interface responsive (mobile/desktop)
- ✓ Multilingue (ar, fr, en) fonctionnel

---

### V1 (Phase 2)
**Durée estimée :** 4-6 semaines

**Modules :**
1. **Projects** (semaine 1-2)
   - CRUD projets
   - Assignation membres
   - Dashboard projet

2. **Experiments** (semaine 2-3)
   - Soumission expériences
   - Upload fichiers
   - Commentaires/collaboration

3. **Events** (semaine 3-4)
   - CRUD événements
   - RSVP système
   - Calendrier événements

4. **Notifications Avancées** (semaine 4)
   - In-app notifications (badge)
   - Email reminders événements
   - Digest quotidien (optionnel)

5. **Polish UI/UX** (semaine 4)
   - Amélioration design
   - Transitions AJAX fluides
   - Loading states

**Critères Acceptance V1 :**
- ✓ Toutes fonctionnalités MVP + Projects + Experiments + Events
- ✓ Collaboration projet opérationnelle
- ✓ RSVP événements avec capacité
- ✓ Notifications complètes (email + in-app)

---

### V2 (Phase 3)
**Durée estimée :** 4-6 semaines

**Modules :**
1. **Maintenance** (semaine 1)
   - CRUD logs maintenance
   - Planning maintenance
   - Intégration avec matériaux (status)

2. **Reports & Analytics** (semaine 2-3)
   - Rapports équipements usage
   - Rapports activité utilisateurs
   - Graphiques (Chart.js)
   - Export PDF/Excel

3. **Advanced Search** (semaine 3)
   - Filtres avancés matériaux
   - Recherche globale (omnisearch)

4. **Calendrier Avancé** (semaine 4)
   - Calendrier réservations complet (FullCalendar)
   - Vue mensuelle/hebdomadaire/journalière
   - Drag & drop (admin only)

5. **Activity Log** (semaine 4)
   - Traçabilité actions utilisateurs (Spatie Activity Log)
   - Audit trail admin

**Critères Acceptance V2 :**
- ✓ Toutes fonctionnalités MVP + V1 + Maintenance + Reports
- ✓ Analytics dashboards opérationnels
- ✓ Exports PDF/Excel fonctionnels
- ✓ Système complet et production-ready

---

## 5. Permissions & Sécurité

### Middleware Chain
```php
Route::group(['middleware' => ['auth', 'check-user-status', 'set-locale']], function() {
    // Routes protégées
});
```

**Middlewares :**
- `auth` : Vérification authentification
- `check-user-status` : Bloque si status != active
- `set-locale` : Applique langue utilisateur
- `role:admin` : Vérification rôle (Spatie)
- `permission:manage-materials` : Vérification permission (Spatie)

### Policies Laravel

**MaterialPolicy :**
```php
public function view(User $user, Material $material): bool
{
    return $user->hasPermissionTo('view-materials');
}

public function update(User $user, Material $material): bool
{
    return $user->hasPermissionTo('manage-materials');
}
```

**ReservationPolicy :**
```php
public function view(User $user, Reservation $reservation): bool
{
    return $user->id === $reservation->user_id
        || $user->hasPermissionTo('approve-reservations');
}

public function cancel(User $user, Reservation $reservation): bool
{
    return $user->id === $reservation->user_id
        && in_array($reservation->status, ['pending', 'approved'])
        && $reservation->start_date > now();
}
```

**ProjectPolicy :**
```php
public function view(User $user, Project $project): bool
{
    return $project->members->contains($user)
        || $user->hasRole('admin');
}

public function update(User $user, Project $project): bool
{
    return $project->created_by === $user->id
        || $user->hasRole('admin');
}
```

### CSRF Protection
- Automatique Laravel pour toutes routes POST/PUT/DELETE
- Token `@csrf` dans formulaires Blade
- Axios configure automatiquement header X-CSRF-TOKEN

### XSS Protection
- Blade escape automatique : `{{ $variable }}`
- Raw output seulement si explicite : `{!! $html !!}` (à éviter)

### SQL Injection Protection
- Eloquent ORM parameterized queries
- Jamais de SQL raw sans bindings

---

## 6. Validation & États

### Form Requests

**StoreMaterialRequest :**
```php
public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:2000',
        'category_id' => 'required|exists:material_categories,id',
        'quantity' => 'required|integer|min:1|max:9999',
        'status' => 'required|in:available,maintenance,retired',
        'location' => 'required|string|max:255',
        'serial_number' => 'nullable|string|max:100|unique:materials,serial_number',
        'purchase_date' => 'nullable|date|before_or_equal:today',
        'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];
}

public function messages(): array
{
    return [
        'name.required' => __('validation.required', ['attribute' => 'name']),
        // ... traductions
    ];
}
```

**StoreReservationRequest :**
```php
public function rules(): array
{
    return [
        'material_id' => 'required|exists:materials,id',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after:start_date',
        'quantity' => 'required|integer|min:1',
        'purpose' => 'required|string|max:1000',
    ];
}

public function withValidator($validator)
{
    $validator->after(function ($validator) {
        // Validation custom: disponibilité
        $service = app(ReservationService::class);
        if (!$service->checkAvailability($this->all())) {
            $validator->errors()->add('quantity', __('reservations.not_available'));
        }
    });
}
```

### États Machines
Voir **03-ValidationAndStates.md** section 2

---

## 7. Tests & DoD

### Tests Structure

```
tests/
├── Feature/
│   ├── Auth/
│   │   ├── LoginTest.php
│   │   ├── RegisterTest.php
│   │   └── PasswordResetTest.php
│   │
│   ├── Material/
│   │   ├── MaterialCrudTest.php
│   │   ├── MaterialSearchTest.php
│   │   └── MaterialPolicyTest.php
│   │
│   ├── Reservation/
│   │   ├── CreateReservationTest.php
│   │   ├── ApproveReservationTest.php
│   │   ├── ConflictDetectionTest.php
│   │   └── CancelReservationTest.php
│   │
│   ├── Project/
│   │   └── ProjectManagementTest.php
│   │
│   └── Event/
│       └── EventRSVPTest.php
│
└── Unit/
    ├── Models/
    │   ├── UserTest.php
    │   ├── MaterialTest.php
    │   └── ReservationTest.php
    │
    ├── Services/
    │   ├── ReservationServiceTest.php
    │   └── NotificationServiceTest.php
    │
    └── Policies/
        └── ReservationPolicyTest.php
```

### Exemple Test Feature

```php
// tests/Feature/Reservation/CreateReservationTest.php
public function test_user_can_create_reservation_if_material_available()
{
    $user = User::factory()->create();
    $user->assignRole('researcher');

    $material = Material::factory()->create(['quantity' => 5]);

    $response = $this->actingAs($user)->post('/reservations', [
        'material_id' => $material->id,
        'start_date' => now()->addDay(),
        'end_date' => now()->addDays(2),
        'quantity' => 2,
        'purpose' => 'Research experiment',
    ]);

    $response->assertRedirect('/reservations/my');
    $this->assertDatabaseHas('reservations', [
        'user_id' => $user->id,
        'material_id' => $material->id,
        'status' => 'pending',
    ]);
}

public function test_user_cannot_create_reservation_if_conflict()
{
    $user = User::factory()->create();
    $material = Material::factory()->create(['quantity' => 5]);

    // Existing reservation
    Reservation::factory()->create([
        'material_id' => $material->id,
        'start_date' => now()->addDay(),
        'end_date' => now()->addDays(3),
        'quantity' => 5,
        'status' => 'approved',
    ]);

    $response = $this->actingAs($user)->post('/reservations', [
        'material_id' => $material->id,
        'start_date' => now()->addDays(2),
        'end_date' => now()->addDays(4),
        'quantity' => 1,
        'purpose' => 'Test',
    ]);

    $response->assertStatus(422);
}
```

### Definition of Done

**Feature complète si :**
- [ ] Code implémenté selon specs
- [ ] Tests unitaires écrits et passent
- [ ] Tests feature écrits et passent
- [ ] Validation formulaires opérationnelle
- [ ] Permissions/Policies appliquées
- [ ] Traductions (ar, fr, en) complètes
- [ ] Responsive design vérifié (mobile/desktop)
- [ ] Notifications fonctionnelles
- [ ] Documentation code (PHPDoc)
- [ ] Review code passée
- [ ] Aucune régression détectée

---

## 8. Observabilité & KPIs

### Logs

**Laravel Log :**
```
storage/logs/laravel.log
```

**Niveaux :**
- `emergency` : Système down
- `error` : Erreurs nécessitant attention
- `warning` : Situations anormales mais non bloquantes
- `info` : Événements notables
- `debug` : Informations détaillées dev

**Activity Log (Spatie) :**
```php
activity()
    ->performedOn($reservation)
    ->causedBy($user)
    ->withProperties(['status' => 'approved'])
    ->log('Reservation approved');
```

### KPIs à Monitorer

**Réservations :**
- Nombre total par statut (pending, approved, rejected, completed)
- Taux d'approbation (approved / total demandes)
- Temps moyen validation (validated_at - created_at)
- Taux d'annulation

**Équipements :**
- Taux d'utilisation par équipement (% temps réservé)
- Équipements les plus demandés
- Temps moyen en maintenance
- Équipements sous-utilisés

**Utilisateurs :**
- Nombre inscriptions par mois
- Taux d'approbation inscriptions
- Utilisateurs actifs (derniers 30 jours)
- Répartition par rôle

**Projets :**
- Nombre projets actifs
- Soumissions par projet
- Moyenne membres par projet

**Événements :**
- Taux de participation (attendees / capacity)
- Événements les plus populaires

### Dashboard Analytics (V2)

```php
// app/Services/ReportService.php
public function getEquipmentUsageStats($dateFrom, $dateTo)
{
    return Reservation::query()
        ->whereBetween('start_date', [$dateFrom, $dateTo])
        ->where('status', 'approved')
        ->with('material')
        ->get()
        ->groupBy('material_id')
        ->map(function($reservations, $materialId) {
            $material = $reservations->first()->material;
            $totalDays = $reservations->sum(function($r) {
                return $r->start_date->diffInDays($r->end_date);
            });

            return [
                'material' => $material->name,
                'total_reservations' => $reservations->count(),
                'total_days' => $totalDays,
                'total_users' => $reservations->pluck('user_id')->unique()->count(),
            ];
        });
}
```

---

## 9. Roadmap

### MVP → V1 → V2 → Future

**MVP (Mois 1-2) :**
- Auth, Users, Materials, Reservations de base
- Validation workflow
- Dashboard basique

**V1 (Mois 3-4) :**
- Projects & Experiments (collaboration)
- Events & RSVP
- Notifications complètes
- UI polish

**V2 (Mois 5-6) :**
- Maintenance tracking
- Reports & Analytics
- Advanced search
- Calendrier complet
- Activity log

**Future (Post-V2) :**
- API REST pour intégrations tierces
- Mobile apps (Flutter) si besoin exprimé
- Integration LDAP/Active Directory (SSO)
- Advanced analytics (ML predictions utilisation)
- Integration systèmes inventaire externes
- QR codes équipements
- Signature électronique documents

---

## Prochaines étapes

- Consulter **web-user-stories.md** pour stories spécifiques web
- Voir **12-Usage-Guide.md** pour installation et démarrage
- Référencer **GAPS-TODO.md** pour clarifications nécessaires
