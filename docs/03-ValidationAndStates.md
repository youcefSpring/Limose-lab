# 03-ValidationAndStates.md

## Règles de Validation et Machines à États

Ce document centralise toutes les règles de validation des entrées utilisateur et les machines à états du système RLMS.

---

## 1. Validation des Données

### 1.1 Users (Utilisateurs)

#### Inscription / Création
```php
// users
name: required | string | max:255
email: required | email | unique:users,email | max:255
password: required | string | min:8 | confirmed
phone: nullable | regex:/^\+213[0-9]{9}$/ (format Algérie)
avatar: nullable | image | mimes:jpeg,png,jpg | max:2048 (Ko)
research_group: nullable | string | max:255
bio: nullable | string | max:1000
```

#### Mise à jour Profil
```php
name: required | string | max:255
email: required | email | unique:users,email,{user_id} | max:255
phone: nullable | regex:/^\+213[0-9]{9}$/
avatar: nullable | image | mimes:jpeg,png,jpg | max:2048
research_group: nullable | string | max:255
bio: nullable | string | max:1000
```

#### Changement Mot de Passe
```php
current_password: required | string
password: required | string | min:8 | confirmed | different:current_password
```

---

### 1.2 Materials (Équipements)

#### Création / Modification
```php
name: required | string | max:255
description: required | string | max:2000
category_id: required | exists:material_categories,id
quantity: required | integer | min:1 | max:9999
status: required | in:available,maintenance,retired
location: required | string | max:255
serial_number: nullable | string | max:100 | unique:materials,serial_number
purchase_date: nullable | date | before_or_equal:today
image: nullable | image | mimes:jpeg,png,jpg | max:2048
maintenance_schedule: nullable | in:weekly,monthly,quarterly,yearly
```

#### Categories de Matériel
```php
// material_categories
name: required | string | max:100 | unique:material_categories,name
description: nullable | string | max:500
```

**Exemples de catégories :**
- Microscopes
- Centrifugeuses
- Spectromètres
- Équipements de sécurité
- Verrerie
- Ordinateurs
- Logiciels

---

### 1.3 Reservations (Réservations)

#### Création
```php
material_id: required | exists:materials,id
start_date: required | date | after_or_equal:today
end_date: required | date | after:start_date
quantity: required | integer | min:1 | max:{material.quantity}
purpose: required | string | max:1000
notes: nullable | string | max:500

// Règles métier supplémentaires (Service Layer):
- Vérifier disponibilité de la quantité demandée pour la période
- Vérifier que material.status = 'available'
- Durée max: 30 jours (configurable)
- Pas plus de 3 réservations actives par utilisateur (configurable)
```

#### Validation par Material Manager
```php
status: required | in:approved,rejected
rejection_reason: required_if:status,rejected | string | max:500
```

---

### 1.4 Projects (Projets)

#### Création / Modification
```php
title: required | string | max:255
description: required | string | max:5000
start_date: required | date
end_date: nullable | date | after:start_date
status: required | in:active,completed,archived
assigned_users: required | array | min:1
assigned_users.*: exists:users,id
project_type: nullable | in:research,development,collaboration
```

---

### 1.5 Experiments (Soumissions)

#### Création
```php
project_id: required | exists:projects,id
title: required | string | max:255
description: required | string | max:5000
experiment_type: required | in:report,data,publication,other
experiment_date: required | date | before_or_equal:today
files: nullable | array | max:5
files.*: file | mimes:pdf,doc,docx,xls,xlsx,csv,zip | max:10240 (10MB)
```

#### Commentaires
```php
comment: required | string | max:2000
parent_id: nullable | exists:experiment_comments,id (pour réponses)
```

---

### 1.6 Events (Événements)

#### Création / Modification
```php
title: required | string | max:255
description: required | string | max:3000
event_date: required | date | after_or_equal:today
event_time: required | date_format:H:i
location: required | string | max:255
capacity: nullable | integer | min:1 | max:1000
event_type: required | in:public,private
target_roles: required_if:event_type,private | array
target_roles.*: in:admin,researcher,phd_student,partial_researcher,technician,material_manager,guest
image: nullable | image | mimes:jpeg,png,jpg | max:2048
```

---

### 1.7 Maintenance Logs

#### Création
```php
material_id: required | exists:materials,id
maintenance_type: required | in:preventive,corrective,inspection
description: required | string | max:2000
scheduled_date: required | date
completed_date: nullable | date | after_or_equal:scheduled_date
technician_id: required | exists:users,id
cost: nullable | numeric | min:0 | max:999999.99
notes: nullable | string | max:1000
```

---

## 2. Machines à États

### 2.1 User Status

```
┌─────────┐
│ pending │ (inscription initiale)
└────┬────┘
     │
     │ [Admin approuve + assigne rôle]
     ▼
┌─────────┐
│ active  │ ◄──────────────────┐
└────┬────┘                    │
     │                         │
     │ [Admin suspend]         │ [Durée suspension écoulée]
     ▼                         │
┌────────────┐                 │
│ suspended  │─────────────────┘
└────────────┘
     │
     │ [Admin ban définitif]
     ▼
┌─────────┐
│ banned  │ (état final)
└─────────┘
```

**États possibles :**
- `pending` : En attente validation admin
- `active` : Compte actif, peut se connecter
- `suspended` : Suspendu temporairement (+ date fin suspension)
- `banned` : Banni définitivement

**Transitions autorisées :**
- `pending` → `active` (admin approuve)
- `active` → `suspended` (admin suspend)
- `suspended` → `active` (admin réactive ou auto après date)
- `active` / `suspended` → `banned` (admin ban)

---

### 2.2 Material Status

```
┌───────────┐
│ available │ ◄─────────┐
└─────┬─────┘           │
      │                 │
      │ [Maintenance]   │ [Réparation terminée]
      ▼                 │
┌─────────────┐         │
│ maintenance │─────────┘
└─────────────┘
      │
      │ [Équipement hors service définitif]
      ▼
┌──────────┐
│ retired  │ (état final)
└──────────┘
```

**États possibles :**
- `available` : Disponible pour réservation
- `maintenance` : En maintenance, non réservable
- `retired` : Hors service définitivement

**Règles :**
- Si `maintenance` : nouvelles réservations impossibles, réservations futures annulées avec notification
- Si `retired` : suppression logique, historique conservé

---

### 2.3 Reservation Status

```
┌─────────┐
│ pending │ (création par utilisateur)
└────┬────┘
     │
     ├─────[Material Manager approuve]────────►┌──────────┐
     │                                          │ approved │
     │                                          └────┬─────┘
     │                                               │
     │                                               │ [Date fin atteinte ou manuelle]
     │                                               ▼
     │                                          ┌───────────┐
     │                                          │ completed │
     │                                          └───────────┘
     │
     ├─────[Material Manager rejette]─────────►┌──────────┐
     │                                          │ rejected │
     │                                          └──────────┘
     │
     └─────[Utilisateur annule]───────────────►┌───────────┐
                                                │ cancelled │
                                                └───────────┘
```

**États possibles :**
- `pending` : En attente validation
- `approved` : Approuvée, active
- `rejected` : Rejetée par manager
- `cancelled` : Annulée par utilisateur (seulement si pending ou approved avant date début)
- `completed` : Terminée

**Transitions autorisées :**
- `pending` → `approved` (material_manager/admin)
- `pending` → `rejected` (material_manager/admin)
- `pending` → `cancelled` (user owner)
- `approved` → `cancelled` (user owner, seulement avant start_date)
- `approved` → `completed` (auto ou manual)

**Règles métier :**
- Annulation possible seulement avant date début (approved) ou à tout moment si pending
- Notification obligatoire à chaque changement d'état
- Si material passe en maintenance : réservations approved futures → cancelled avec notification

---

### 2.4 Project Status

```
┌────────┐
│ active │ (création)
└───┬────┘
    │
    ├─────[Projet terminé]─────────►┌───────────┐
    │                                │ completed │
    │                                └─────┬─────┘
    │                                      │
    │                                      │ [Archivage après X mois]
    │                                      ▼
    │                                 ┌──────────┐
    │                                 │ archived │
    │                                 └──────────┘
    │
    └─────[Admin archive directement]►┌──────────┐
                                       │ archived │
                                       └──────────┘
```

**États possibles :**
- `active` : Projet en cours
- `completed` : Projet terminé
- `archived` : Projet archivé (lecture seule)

**Transitions autorisées :**
- `active` → `completed` (admin/project owner)
- `active` → `archived` (admin)
- `completed` → `archived` (auto ou admin)

---

### 2.5 Event Status (virtuel, basé sur dates)

États calculés dynamiquement :

```php
// Pas de colonne status en DB, calculé à la volée
if (event_date > now()) {
    return 'upcoming';
} elseif (event_date == today && event_time > now()->format('H:i')) {
    return 'upcoming';
} elseif (event_date == today && event_time <= now()->format('H:i')) {
    return 'ongoing';
} else {
    return 'completed';
}

// Ajout colonne cancelled pour annulations manuelles
if (cancelled_at !== null) {
    return 'cancelled';
}
```

**États virtuels :**
- `upcoming` : À venir
- `ongoing` : En cours
- `completed` : Terminé
- `cancelled` : Annulé (colonne cancelled_at en DB)

---

### 2.6 Maintenance Log Status

```
┌───────────┐
│ scheduled │ (création)
└─────┬─────┘
      │
      │ [Technicien commence travail]
      ▼
┌─────────────┐
│ in_progress │
└─────┬───────┘
      │
      │ [Travail terminé]
      ▼
┌───────────┐
│ completed │
└───────────┘
```

**États possibles :**
- `scheduled` : Planifiée, pas encore commencée
- `in_progress` : En cours
- `completed` : Terminée

---

## 3. Règles de Calcul et Contraintes

### 3.1 Disponibilité Matériel

**Quantité disponible pour une période :**
```sql
SELECT
    m.quantity - COALESCE(SUM(r.quantity), 0) as available_quantity
FROM materials m
LEFT JOIN reservations r ON r.material_id = m.id
    AND r.status = 'approved'
    AND (
        (r.start_date <= :end_date AND r.end_date >= :start_date)
    )
WHERE m.id = :material_id
    AND m.status = 'available'
GROUP BY m.id;
```

### 3.2 Conflits de Réservation

Une réservation est en conflit si :
```php
// Même matériel
// Période qui chevauche
// Quantité cumulée > material.quantity
// Status = approved

Conflict si :
(new_start <= existing_end) AND (new_end >= existing_start)
AND (SUM(quantity) > material.quantity)
```

---

### 3.3 Limite Réservations par Utilisateur

```php
// Configurable dans config/rlms.php
'reservation_limits' => [
    'max_active_per_user' => 3,
    'max_duration_days' => 30,
    'min_duration_hours' => 1,
],
```

---

### 3.4 Capacité Événements

```php
// Avant inscription
$attendees_count = EventAttendee::where('event_id', $event->id)
    ->where('status', 'confirmed')
    ->count();

if ($event->capacity && $attendees_count >= $event->capacity) {
    throw ValidationException::withMessages([
        'event' => 'Event is full'
    ]);
}
```

---

## 4. Messages d'Erreur Multilingues

### Structure fichiers de traduction

```
resources/lang/ar/validation.php
resources/lang/fr/validation.php
resources/lang/en/validation.php
```

### Exemples messages personnalisés

```php
// fr/validation.php
'custom' => [
    'reservation.start_date' => [
        'after_or_equal' => 'La date de début doit être aujourd\'hui ou dans le futur.',
    ],
    'reservation.quantity' => [
        'max' => 'La quantité demandée dépasse le stock disponible.',
    ],
    'phone' => [
        'regex' => 'Le format du téléphone doit être +213XXXXXXXXX',
    ],
],

// ar/validation.php (RTL)
'custom' => [
    'reservation.start_date' => [
        'after_or_equal' => 'يجب أن يكون تاريخ البدء اليوم أو في المستقبل.',
    ],
    // ...
],
```

---

## 5. Contraintes SQL (Database Level)

### Indexes pour Performance et Intégrité

```sql
-- Unicité
UNIQUE INDEX idx_users_email ON users(email);
UNIQUE INDEX idx_materials_serial ON materials(serial_number);

-- Performance queries fréquents
INDEX idx_reservations_status ON reservations(status);
INDEX idx_reservations_dates ON reservations(start_date, end_date);
INDEX idx_reservations_material ON reservations(material_id, status);

-- Foreign keys avec cascade approprié
ALTER TABLE reservations
    ADD CONSTRAINT fk_reservation_user
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;

ALTER TABLE reservations
    ADD CONSTRAINT fk_reservation_material
    FOREIGN KEY (material_id) REFERENCES materials(id) ON DELETE CASCADE;
```

---

### Contraintes Check (MySQL 8.0.16+)

```sql
-- Quantité positive
ALTER TABLE materials
    ADD CONSTRAINT chk_material_quantity
    CHECK (quantity >= 0);

-- Dates cohérentes
ALTER TABLE reservations
    ADD CONSTRAINT chk_reservation_dates
    CHECK (end_date > start_date);

-- Coût maintenance positif
ALTER TABLE maintenance_logs
    ADD CONSTRAINT chk_maintenance_cost
    CHECK (cost >= 0);
```

---

## 6. Validation Custom (Service Layer)

### Exemples validateurs métier

```php
// ReservationService.php
public function validateAvailability(Material $material, $startDate, $endDate, $quantity): bool
{
    $bookedQuantity = Reservation::where('material_id', $material->id)
        ->where('status', 'approved')
        ->where(function($query) use ($startDate, $endDate) {
            $query->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function($q) use ($startDate, $endDate) {
                      $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                  });
        })
        ->sum('quantity');

    return ($material->quantity - $bookedQuantity) >= $quantity;
}

public function validateUserReservationLimit(User $user): bool
{
    $activeCount = Reservation::where('user_id', $user->id)
        ->whereIn('status', ['pending', 'approved'])
        ->count();

    return $activeCount < config('rlms.reservation_limits.max_active_per_user', 3);
}
```

---

## Résumé des États

| Entité | États Possibles | État Initial | États Finaux |
|--------|----------------|--------------|--------------|
| **User** | pending, active, suspended, banned | pending | banned |
| **Material** | available, maintenance, retired | available | retired |
| **Reservation** | pending, approved, rejected, cancelled, completed | pending | rejected, cancelled, completed |
| **Project** | active, completed, archived | active | archived |
| **Event** | upcoming, ongoing, completed, cancelled | upcoming (calculé) | completed, cancelled |
| **Maintenance** | scheduled, in_progress, completed | scheduled | completed |

---

## Prochaines étapes

- Voir **04-DatabaseSchema.sql** pour implémentation SQL
- Consulter **10-Module.md** pour implémentation code Laravel
- Référencer **02-Workflows.md** pour utilisation des états dans les workflows
