# 01-SystemOverview.md

## Vue d'ensemble du système

Le **Research Laboratory Management System (RLMS)** est une plateforme web monolithique construite avec Laravel, permettant la gestion complète des activités d'un laboratoire de recherche scientifique.

---

## Architecture Globale

### Type : Monolithique Web (Architecture A)

```
┌─────────────────────────────────────────────────────────────┐
│                      UTILISATEURS                           │
│  (Navigateur Web - Desktop/Mobile)                         │
└────────────────┬────────────────────────────────────────────┘
                 │
                 │ HTTPS
                 │
┌────────────────▼────────────────────────────────────────────┐
│              SERVEUR WEB (Nginx/Apache)                     │
│                                                              │
│  ┌──────────────────────────────────────────────────────┐  │
│  │           APPLICATION LARAVEL (MVC)                   │  │
│  │                                                        │  │
│  │  ┌─────────────┐  ┌──────────────┐  ┌─────────────┐ │  │
│  │  │   Routes    │  │ Controllers  │  │   Models    │ │  │
│  │  │   (Web)     │◄─┤   (Logic)    │◄─┤ (Eloquent)  │ │  │
│  │  └─────────────┘  └──────────────┘  └──────┬──────┘ │  │
│  │                                              │        │  │
│  │  ┌─────────────┐  ┌──────────────┐         │        │  │
│  │  │   Views     │  │ Middleware   │         │        │  │
│  │  │ (Blade+CSS) │  │(Auth, Perms) │         │        │  │
│  │  └─────────────┘  └──────────────┘         │        │  │
│  │                                              │        │  │
│  │  ┌─────────────┐  ┌──────────────┐         │        │  │
│  │  │  Services   │  │  Policies    │         │        │  │
│  │  │  (Business) │  │ (AuthZ)      │         │        │  │
│  │  └─────────────┘  └──────────────┘         │        │  │
│  │                                              │        │  │
│  │  ┌─────────────┐  ┌──────────────┐         │        │  │
│  │  │   Jobs      │  │ Notifications│         │        │  │
│  │  │  (Queue)    │  │  (Email/DB)  │         │        │  │
│  │  └─────────────┘  └──────────────┘         │        │  │
│  └──────────────────────────────────────────┬─┴────────┘  │
└─────────────────────────────────────────────┼─────────────┘
                                               │
                 ┌─────────────────────────────┼───────────────┐
                 │                             │               │
         ┌───────▼────────┐         ┌─────────▼──────┐  ┌────▼─────┐
         │   MySQL DB     │         │ Storage (Files)│  │  Cache   │
         │  (Persistent)  │         │  (Local/Cloud) │  │  (Redis) │
         └────────────────┘         └────────────────┘  └──────────┘
```

---

## Composants Principaux

### 1. Couche Présentation (Frontend)

**Technologies :**
- Blade Templates (Laravel)
- Tailwind CSS (responsive, mobile-first)
- Alpine.js / Axios (AJAX, interactivité)
- Chart.js / ApexCharts (visualisations)

**Responsabilités :**
- Affichage interface utilisateur multilingue (ar, fr, en)
- Formulaires dynamiques avec validation côté client
- Tableaux interactifs avec filtres AJAX
- Calendrier d'événements et réservations
- Dashboards avec graphiques
- Support RTL pour l'arabe

---

### 2. Couche Application (Backend Laravel)

**Routes Web (`routes/web.php`) :**
- Routes publiques (login, register, forgot-password)
- Routes protégées par auth middleware
- Routes avec permissions Spatie

**Controllers :**
- `AuthController` - Authentification
- `UserController` - Gestion utilisateurs
- `MaterialController` - Équipements et inventaire
- `ReservationController` - Réservations
- `ProjectController` - Projets de recherche
- `ExperimentController` - Soumissions expériences
- `EventController` - Événements et séminaires
- `ReportController` - Rapports et analytics
- `NotificationController` - Notifications

**Middleware :**
- `auth` - Authentification requise
- `role:admin` - Vérification rôle (Spatie)
- `permission:manage-materials` - Vérification permission
- `locale` - Gestion langue i18n

**Services (Business Logic) :**
- `UserService` - Logique métier utilisateurs
- `ReservationService` - Workflow réservations
- `NotificationService` - Envoi notifications
- `ReportService` - Génération rapports
- `MaintenanceService` - Gestion maintenance équipements

**Policies (Authorization) :**
- `MaterialPolicy` - Autorisation équipements
- `ReservationPolicy` - Autorisation réservations
- `ProjectPolicy` - Autorisation projets

---

### 3. Couche Données

**Base de données MySQL :**
- Tables normalisées (voir 04-DatabaseSchema.sql)
- Relations Eloquent (hasMany, belongsTo, belongsToMany)
- Soft deletes pour données critiques
- Indexation pour performance

**Modèles Eloquent principaux :**
- `User` - Utilisateurs
- `Role` - Rôles (Spatie)
- `Permission` - Permissions (Spatie)
- `Material` - Équipements/matériel
- `Reservation` - Réservations
- `Project` - Projets de recherche
- `Experiment` - Expériences/soumissions
- `Event` - Événements
- `Notification` - Notifications DB
- `MaintenanceLog` - Logs maintenance

**Storage (Fichiers) :**
- `storage/app/public/` - Fichiers publics
- `storage/app/private/` - Fichiers privés (rapports, soumissions)
- Organisation : `{type}/{year}/{month}/{filename}`
- Validation : type MIME, taille max, extensions autorisées

---

### 4. Système de Permissions

**Spatie Laravel Permission :**

```
roles
  ├── admin (super-admin)
  ├── material_manager
  ├── researcher
  ├── phd_student
  ├── partial_researcher
  ├── technician
  └── guest

permissions
  ├── manage-users
  ├── manage-materials
  ├── approve-reservations
  ├── create-reservations
  ├── manage-projects
  ├── submit-experiments
  ├── manage-events
  ├── view-reports
  └── export-reports
```

**Matrice d'autorisation (voir 10-Module.md pour détails complets)**

---

### 5. Système de Notifications

**Canaux :**
1. **Email** (Laravel Mail + SMTP)
   - Confirmation réservation
   - Rappels événements
   - Alertes maintenance

2. **Database** (table `notifications`)
   - Notifications in-app
   - Historique consultable
   - Marquage lu/non-lu

3. **AJAX Polling** (optionnel)
   - Vérification périodique nouvelles notifications
   - Badge compteur dynamique

**Types de notifications :**
- `ReservationApproved`
- `ReservationRejected`
- `MaintenanceDue`
- `EventReminder`
- `ProjectDeadline`
- `ExperimentSubmitted`

---

### 6. Workflow de Réservation

```
Utilisateur                Material Manager          Système
    │                            │                       │
    ├──[Créer réservation]──────►│                       │
    │                            │                       │
    │                            ├──[Vérifier dispo]────►│
    │                            │◄─────[OK/Conflit]─────┤
    │                            │                       │
    │                            ├──[Approuver/Rejeter]  │
    │◄───[Notification email]────┤                       │
    │◄───[Notification DB]────────────────────────────────┤
    │                            │                       │
    └──[Utiliser équipement]     │                       │
       (si approuvé)              │                       │
```

---

## Diagramme de Flux Données

```
┌──────────────┐
│ Utilisateur  │
└──────┬───────┘
       │
       │ 1. Requête HTTP (GET/POST)
       ▼
┌─────────────────┐
│  Routes Web     │
└──────┬──────────┘
       │
       │ 2. Dispatch vers Controller
       ▼
┌─────────────────┐
│  Middleware     │──► Auth, Permissions, Locale
└──────┬──────────┘
       │
       │ 3. Vérifications OK
       ▼
┌─────────────────┐
│  Controller     │
└──────┬──────────┘
       │
       │ 4. Appel Service/Model
       ▼
┌─────────────────┐
│  Service        │──► Business Logic
└──────┬──────────┘
       │
       │ 5. Requête DB via Eloquent
       ▼
┌─────────────────┐
│  Model          │
└──────┬──────────┘
       │
       │ 6. Query SQL
       ▼
┌─────────────────┐
│  MySQL DB       │
└──────┬──────────┘
       │
       │ 7. Résultats
       ▼
┌─────────────────┐
│  View (Blade)   │──► Rendu HTML + CSS + JS
└──────┬──────────┘
       │
       │ 8. Réponse HTTP
       ▼
┌──────────────────┐
│  Utilisateur     │
└──────────────────┘
```

---

## Sécurité

### Authentification
- Laravel Breeze/Jetstream
- Password hashing (bcrypt)
- Email verification
- Password reset sécurisé

### Autorisation
- Spatie Permission (RBAC)
- Policies Laravel
- Middleware de vérification

### Protection
- CSRF tokens (Laravel par défaut)
- XSS prevention (Blade escaping)
- SQL injection (Eloquent ORM)
- Rate limiting (throttle middleware)
- Input validation (Form Requests)

### Fichiers
- Validation type MIME
- Limitation taille (max 10MB par fichier)
- Stockage sécurisé (hors public/ si sensible)
- Noms de fichiers sanitisés

---

## Performance

### Optimisations
- Query optimization (eager loading, indexes)
- Cache (Redis/File) pour données fréquentes
- AJAX pour éviter rechargements complets
- Lazy loading des images
- Minification CSS/JS (Laravel Mix/Vite)

### Scalabilité
- Queue jobs pour tâches longues (emails, exports)
- Pagination des résultats
- Recherche optimisée avec indexes

---

## Internationalisation (i18n)

### Langues supportées
- Arabe (ar) - RTL
- Français (fr)
- Anglais (en)

### Implémentation
```
resources/lang/
  ├── ar/
  │   ├── auth.php
  │   ├── messages.php
  │   ├── validation.php
  │   └── ...
  ├── fr/
  │   └── ...
  └── en/
      └── ...
```

### Détection langue
1. Préférence utilisateur (DB)
2. Session utilisateur
3. Header Accept-Language navigateur
4. Langue par défaut (configuré selon choix utilisateur)

---

## Prochaines étapes

- Consulter **02-Workflows.md** pour workflows détaillés
- Voir **04-DatabaseSchema.sql** pour structure complète DB
- Lire **10-Module.md** pour détails de chaque module
