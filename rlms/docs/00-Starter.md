# 00-Starter.md

## Introduction

**Nom du projet :** Research Laboratory Management System (RLMS)

**Objectif :** Système de gestion complet pour un laboratoire de recherche scientifique, permettant de gérer les utilisateurs, équipements, projets, événements, et soumissions de recherche avec une interface moderne et dynamique.

---

## Architecture choisie

**Type A : Laravel Web only**

L'application est une plateforme web uniquement, sans API mobile dédiée. Toutes les fonctionnalités sont accessibles via navigateur web.

**Justification :**
- Le système cible principalement des utilisateurs de bureau (chercheurs, administrateurs)
- Pas de besoin d'applications mobiles natives mentionné
- Interface responsive avec Tailwind CSS pour l'accès mobile via navigateur
- AJAX pour interactions dynamiques sans rechargement de page

---

## Stack Technique

| Couche | Technologie | Version |
|--------|-------------|---------|
| **Backend** | Laravel | 11+ |
| **Frontend** | Tailwind CSS | Latest |
| **Interactions dynamiques** | AJAX (Alpine.js / Axios) | Latest |
| **Base de données** | MySQL | 8.0+ |
| **Authentification** | Laravel Sanctum/Jetstream | Latest |
| **Stockage fichiers** | Laravel Storage | - |
| **Visualisation données** | Chart.js / ApexCharts | Latest |
| **Serveur Web** | Nginx / Apache | - |
| **PHP** | PHP | 8.2+ |

---

## Langues et Internationalisation (i18n)

**Langues supportées :**
- Arabe (ar) - RTL
- Français (fr)
- Anglais (en)

**Configuration :**
- Support multilingue complet avec Laravel Localization
- Fichiers de traduction : `resources/lang/{ar,fr,en}/`
- Détection automatique de la langue via préférences utilisateur ou navigateur
- Support RTL pour l'arabe via Tailwind directives

---

## Contraintes et Décisions Techniques

### Authentification
- **Laravel Breeze ou Jetstream** pour auth de base
- **Spatie Laravel Permission** pour gestion des rôles et permissions
- Pas de JWT (Web only)

### Paiements
- **Aucun système de paiement** requis (confirmé)
- Accès gratuit aux fonctionnalités du laboratoire

### Notifications
- **Email notifications** (Laravel Mail + SMTP)
- **Database notifications** (stockées en DB)
- **Pas de WebSockets** (Pusher/Reverb non requis)
- Notifications AJAX pour alertes dynamiques dans l'interface

### Validation des réservations
- **Hybrid approval system :**
  - Rôle "Material Management" peut approuver/rejeter les réservations
  - Administrateurs peuvent également gérer toutes les réservations
  - Workflow : pending → approved/rejected

### Mode offline
- Non applicable (Web only, nécessite connexion Internet)

### Sécurité
- CSRF protection (Laravel par défaut)
- XSS protection
- SQL injection protection via Eloquent ORM
- Rate limiting sur routes sensibles
- Validation stricte des entrées utilisateur
- File upload validation (type, taille, extensions)

---

## Modules Principaux

1. **User Management** - Gestion utilisateurs, rôles, profils
2. **Materials & Equipment Management** - Inventaire, réservations, maintenance
3. **Project & Experiment Management** - Projets, soumissions, collaboration
4. **Events & Seminars** - Événements, RSVP, calendrier
5. **Reports & Analytics** - Rapports d'utilisation, exports, dashboard
6. **Notifications & Alerts** - Email, DB notifications, alertes système

---

## Rôles Utilisateurs

| Rôle | Code | Description |
|------|------|-------------|
| **Administrator** | `admin` | Gestion complète du système |
| **Researcher** | `researcher` | Chercheur avec projets, réservations |
| **PhD Student** | `phd_student` | Doctorant avec accès recherche |
| **Partial Researcher** | `partial_researcher` | Chercheur avec accès limité |
| **Technician** | `technician` | Gestion inventaire et maintenance |
| **Material Manager** | `material_manager` | Validation réservations équipements |
| **Guest** | `guest` | Accès lecture seule limité |

---

## Priorités MVP

**Phase 1 - MVP (Minimum Viable Product) :**
1. Authentication & User Management
2. Basic Equipment Inventory
3. Reservation System with approval workflow
4. User Dashboard

**Phase 2 - V1 :**
1. Project Management
2. Experiment Submission
3. Event Management
4. Email Notifications

**Phase 3 - V2 :**
1. Reports & Analytics Dashboard
2. Maintenance Tracking
3. Advanced Search & Filters
4. Export functionality (PDF/Excel)

---

## Environnement de Développement

**Requis :**
- PHP >= 8.2
- Composer
- Node.js >= 18 et npm
- MySQL 8.0+
- Git

**Recommandé :**
- Laravel Valet / Herd (macOS)
- Docker avec Laravel Sail
- VS Code avec extensions Laravel

---

## Structure du Projet

```
rlms/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   ├── Policies/
│   ├── Services/
│   └── ...
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   ├── lang/{ar,fr,en}/
│   └── js/
├── routes/
│   └── web.php
├── public/
├── storage/
├── tests/
└── docs/ (cette documentation)
```

---

## Prochaines Étapes

1. Lire 01-SystemOverview.md pour architecture détaillée
2. Consulter 04-DatabaseSchema.sql pour structure DB
3. Suivre 12-Usage-Guide.md pour installation
4. Référencer 10-Module.md pour détails des modules
5. Consulter GAPS-TODO.md pour infos manquantes et décisions en suspens
