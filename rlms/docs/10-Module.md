# 10-Module.md

## Modules du Système RLMS

Ce document détaille chaque module du système avec ownership, permissions, et implémentation.

---

## 1. Module Authentication & User Management

### Ownership
- **Admin** : Gestion complète utilisateurs
- **Material Manager** : Lecture seule
- **Tous** : Gestion propre profil

### Domain Model
**Entités :**
- User (id, name, email, password, status, locale, avatar, research_group, bio)
- Role (Spatie)
- Permission (Spatie)

**États :** pending → active ↔ suspended → banned

### Routes & Endpoints
Voir 09-Complete-API-Endpoints.md sections 1, 3, 13

### Permissions Matrix

| Action | admin | material_manager | researcher | phd_student | technician | guest |
|--------|-------|------------------|------------|-------------|------------|-------|
| users.index | ✓ | - | - | - | - | - |
| users.show | ✓ | ✓ | own | own | own | own |
| users.approve | ✓ | - | - | - | - | - |
| users.suspend | ✓ | - | - | - | - | - |
| users.ban | ✓ | - | - | - | - | - |
| profile.edit | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| roles.manage | ✓ | - | - | - | - | - |

### Validation
Voir 03-ValidationAndStates.md section 1.1

### Workflows
Voir 02-Workflows.md sections 1, 9

---

## 2. Module Materials & Equipment Management

### Ownership
- **Admin** : Gestion complète
- **Material Manager** : Gestion complète
- **Technician** : Création/modification équipements
- **Tous auth** : Lecture

### Domain Model
**Entités :**
- Material (id, name, description, category_id, quantity, status, location, serial_number, purchase_date, maintenance_schedule)
- MaterialCategory (id, name, description)

**États :** available ↔ maintenance → retired

### Routes & Endpoints
Voir 09-Complete-API-Endpoints.md sections 4, 5

### Permissions Matrix

| Action | admin | material_manager | researcher | phd_student | technician | guest |
|--------|-------|------------------|------------|-------------|------------|-------|
| materials.index | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| materials.show | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| materials.create | ✓ | ✓ | - | - | ✓ | - |
| materials.update | ✓ | ✓ | - | - | ✓ | - |
| materials.delete | ✓ | ✓ | - | - | - | - |
| categories.manage | ✓ | ✓ | - | - | - | - |

### Business Rules
- Quantity >= 0
- Status change to maintenance → cancel future reservations
- Cannot delete if active reservations exist
- Serial number unique (if provided)

### Workflows
Voir 02-Workflows.md section 2

---

## 3. Module Reservations

### Ownership
- **Admin** : Lecture/validation toutes
- **Material Manager** : Validation réservations
- **Utilisateurs auth** : Création pour soi, lecture propres réservations

### Domain Model
**Entités :**
- Reservation (id, user_id, material_id, start_date, end_date, quantity, purpose, notes, status, validated_by, rejection_reason)

**États :** pending → approved/rejected/cancelled → completed

### Routes & Endpoints
Voir 09-Complete-API-Endpoints.md section 6

### Permissions Matrix

| Action | admin | material_manager | researcher | phd_student | technician | guest |
|--------|-------|------------------|------------|-------------|------------|-------|
| reservations.index | ✓ | ✓ | own | own | own | - |
| reservations.create | ✓ | ✓ | ✓ | ✓ | ✓ | - |
| reservations.approve | ✓ | ✓ | - | - | - | - |
| reservations.reject | ✓ | ✓ | - | - | - | - |
| reservations.cancel | owner | owner | owner | owner | owner | - |

### Business Rules
- Conflict detection : overlapping dates, quantity check
- Max active reservations per user : 3 (configurable)
- Max duration : 30 days (configurable)
- Cannot cancel after start_date (except admin)
- Notification on status change

### Workflows
Voir 02-Workflows.md section 3

---

## 4. Module Projects & Research

### Ownership
- **Admin** : Gestion complète
- **Researcher** : Création/gestion projets dont il est member
- **PhD Student** : Membre de projets

### Domain Model
**Entités :**
- Project (id, title, description, start_date, end_date, status, created_by, project_type)
- ProjectUser (pivot: project_id, user_id, role: owner/member/viewer)

**États :** active → completed → archived

### Routes & Endpoints
Voir 09-Complete-API-Endpoints.md section 7

### Permissions Matrix

| Action | admin | material_manager | researcher | phd_student | partial_researcher | technician | guest |
|--------|-------|------------------|------------|-------------|-------------------|------------|-------|
| projects.index | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | - |
| projects.create | ✓ | - | ✓ | - | - | - | - |
| projects.update | ✓ | - | owner | - | - | - | - |
| projects.view | ✓ | ✓ | member | member | member | member | - |
| projects.archive | ✓ | - | owner | - | - | - | - |

### Business Rules
- At least 1 member required
- Project creator automatically owner
- Only owner/admin can add/remove members
- Notifications on member assignment

### Workflows
Voir 02-Workflows.md section 5

---

## 5. Module Experiments & Submissions

### Ownership
- **Project members** : Soumission expériences
- **Tous project members** : Lecture/commentaires

### Domain Model
**Entités :**
- Experiment (id, project_id, user_id, title, description, experiment_type, experiment_date)
- ExperimentFile (id, experiment_id, file_name, file_path, file_size, mime_type)
- ExperimentComment (id, experiment_id, user_id, parent_id, comment)

### Routes & Endpoints
Voir 09-Complete-API-Endpoints.md section 8

### Permissions Matrix

| Action | admin | researcher | phd_student | member |
|--------|-------|------------|-------------|--------|
| experiments.create | ✓ | project member | project member | project member |
| experiments.view | ✓ | project member | project member | project member |
| experiments.comment | ✓ | project member | project member | project member |
| experiments.download | ✓ | project member | project member | project member |

### Business Rules
- Max 5 files per submission
- File size max 10MB
- Allowed types: pdf, doc, docx, xls, xlsx, csv, zip
- Comments can be nested (replies)
- Notifications on new submission/comment

### Workflows
Voir 02-Workflows.md section 5.2, 5.3

---

## 6. Module Events & Seminars

### Ownership
- **Admin** : Création/gestion tous événements
- **Utilisateurs with permission** : Création événements
- **Tous auth** : RSVP événements publics ou ciblés

### Domain Model
**Entités :**
- Event (id, title, description, event_date, event_time, location, capacity, event_type, target_roles, created_by, cancelled_at)
- EventAttendee (id, event_id, user_id, status)

**États (virtuels) :** upcoming → ongoing → completed, ou cancelled

### Routes & Endpoints
Voir 09-Complete-API-Endpoints.md section 9

### Permissions Matrix

| Action | admin | material_manager | researcher | phd_student | technician | guest |
|--------|-------|------------------|------------|-------------|------------|-------|
| events.index | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| events.create | ✓ | - | - | - | - | - |
| events.update | creator/admin | - | - | - | - | - |
| events.rsvp | ✓ | ✓ | ✓ | ✓ | ✓ | - |
| events.cancel | creator/admin | - | - | - | - | - |

### Business Rules
- Public events : accessible à tous
- Private events : seulement rôles ciblés
- Capacity check on RSVP
- Email reminders 24h before event
- Cannot RSVP after event date

### Workflows
Voir 02-Workflows.md section 6

---

## 7. Module Maintenance

### Ownership
- **Admin** : Gestion complète
- **Technician** : Création/gestion logs maintenance
- **Material Manager** : Lecture, création logs

### Domain Model
**Entités :**
- MaintenanceLog (id, material_id, technician_id, maintenance_type, description, scheduled_date, completed_date, cost, notes, status)

**États :** scheduled → in_progress → completed

### Routes & Endpoints
Voir 09-Complete-API-Endpoints.md section 10

### Permissions Matrix

| Action | admin | material_manager | technician | other |
|--------|-------|------------------|------------|-------|
| maintenance.index | ✓ | ✓ | ✓ | - |
| maintenance.create | ✓ | ✓ | ✓ | - |
| maintenance.start | ✓ | - | ✓ | - |
| maintenance.complete | ✓ | - | ✓ | - |

### Business Rules
- Material status → maintenance when log created
- Material status → available when log completed
- Notifications on maintenance completion
- Cost tracking optional

### Workflows
Voir 02-Workflows.md section 4

---

## 8. Module Reports & Analytics

### Ownership
- **Admin** : Accès tous rapports, export
- **Material Manager** : Rapports équipements
- **Researcher** : Rapports propres activités

### Routes & Endpoints
Voir 09-Complete-API-Endpoints.md section 11

### Permissions Matrix

| Action | admin | material_manager | researcher | other |
|--------|-------|------------------|------------|-------|
| reports.view | ✓ | ✓ | own | - |
| reports.export | ✓ | ✓ | - | - |

### Types de Rapports
1. **Equipment Usage** : utilisation par équipement/catégorie/période
2. **User Activity** : réservations, soumissions par utilisateur
3. **Reservations Summary** : statistiques réservations (approved, rejected, etc.)

### Technologies
- Chart.js / ApexCharts pour graphiques
- Laravel Excel pour exports Excel
- Barryvdh/laravel-dompdf pour exports PDF

### Workflows
Voir 02-Workflows.md section 7

---

## 9. Module Notifications

### Ownership
- **Système** : Envoi automatique
- **Utilisateurs** : Lecture propres notifications

### Domain Model
**Entités :**
- Notification (id, type, notifiable_type, notifiable_id, data, read_at)

### Types de Notifications
- ReservationApproved
- ReservationRejected
- ReservationCancelled
- MaintenanceDue
- MaintenanceCompleted
- EventReminder
- ProjectAssigned
- ExperimentSubmitted
- UserApproved

### Canaux
- **Database** : stockage in-app
- **Email** : via Laravel Mail + SMTP

### Routes & Endpoints
Voir 09-Complete-API-Endpoints.md section 12

### Workflows
Voir 02-Workflows.md section 8

---

## Tests & Definition of Done

### Tests requis par module
- **Unit tests** : Models, Services, Policies
- **Feature tests** : Controllers, Workflows complets
- **Browser tests** (Dusk) : Parcours utilisateurs critiques

### DoD (Definition of Done)
✓ Code implémenté selon spécifications
✓ Validation formulaires fonctionnelle
✓ Permissions/Policies appliquées
✓ Tests unitaires/feature passent
✓ Traductions (ar, fr, en) complètes
✓ Documentation code (PHPDoc)
✓ Responsive design vérifié
✓ Notifications opérationnelles

---

## Observabilité & KPIs

### Logs
- Laravel Log : errors, warnings
- Activity Log : actions utilisateurs critiques (Spatie Activity Log)

### KPIs à monitorer
- Nombre réservations par statut
- Taux d'approbation réservations
- Utilisation équipements (%)
- Temps moyen validation réservation
- Nombre maintenances par équipement
- Participation événements (%)

---

## Prochaines étapes

- Consulter **11-User-Stories.md** pour stories utilisateurs
- Voir **12-Usage-Guide.md** pour guide d'installation
