# 02-Workflows.md

## Workflows Métier du Système

Ce document décrit les workflows principaux du Research Laboratory Management System (RLMS).

---

## 1. Workflow d'Authentification

### 1.1 Inscription (Registration)

```
┌─────────────┐
│ Utilisateur │
│ visite /register
└──────┬──────┘
       │
       ├── Remplit formulaire (name, email, password, role souhaité)
       │
       ▼
┌─────────────────┐
│  Validation     │
│  - Email unique │
│  - Password min 8 chars
│  - Name requis  │
└──────┬──────────┘
       │
       ├── [Valide] ───────────────────────┐
       │                                    │
       ▼                                    ▼
┌─────────────────┐              ┌──────────────────┐
│ Créer User      │              │ Envoyer Email    │
│ status: pending │              │ Verification     │
│ (pas de rôle)   │              │                  │
└──────┬──────────┘              └─────────┬────────┘
       │                                    │
       │◄───────────────────────────────────┘
       │
       ├── [Admin approuve + assigne rôle]
       │
       ▼
┌─────────────────┐
│ User activé     │
│ status: active  │
│ + rôle assigné  │
└─────────────────┘
```

**États :**
- `pending` : En attente validation admin
- `active` : Compte activé, peut se connecter
- `suspended` : Compte suspendu temporairement
- `banned` : Compte banni définitivement

---

### 1.2 Connexion (Login)

```
┌─────────────┐
│ Utilisateur │
│ visite /login
└──────┬──────┘
       │
       ├── Saisit email + password
       │
       ▼
┌─────────────────┐
│  Validation     │
│  credentials    │
└──────┬──────────┘
       │
       ├── [Invalide] ──► Erreur "Identifiants incorrects"
       │
       ├── [Valide mais status != active] ──► Erreur "Compte non activé"
       │
       ├── [Valide et active] ────┐
       │                           │
       ▼                           ▼
┌─────────────────┐     ┌──────────────────┐
│ Créer Session   │     │ Redirect vers    │
│ Laravel         │────►│ Dashboard        │
└─────────────────┘     └──────────────────┘
```

---

### 1.3 Réinitialisation Mot de Passe

```
User ──► /forgot-password ──► Saisit email ──► Envoyer token par email
                                                        │
                                                        ▼
User clique lien email ──► /reset-password/{token} ──► Nouveau password
                                                        │
                                                        ▼
                                              Mot de passe mis à jour
                                              Redirect vers /login
```

---

## 2. Workflow de Gestion des Équipements

### 2.1 Ajout d'un Équipement

```
┌──────────────────┐
│ Admin/Technician │
└────────┬─────────┘
         │
         ├── Accède /materials/create
         │
         ▼
┌──────────────────────────────────┐
│ Formulaire Création Équipement   │
│ - Name                            │
│ - Description                     │
│ - Category                        │
│ - Quantity                        │
│ - Status (available/maintenance)  │
│ - Location                        │
└────────┬─────────────────────────┘
         │
         ▼
┌──────────────────┐
│  Validation      │
└────────┬─────────┘
         │
         ├── [Valide] ──► Créer Material ──► Redirect /materials
         │
         └── [Invalide] ──► Afficher erreurs
```

---

### 2.2 Modification d'un Équipement

```
Admin/Technician ──► Clique "Modifier" ──► /materials/{id}/edit
                                                │
                                                ▼
                                    Formulaire pré-rempli
                                                │
                                                ▼
                                        Soumettre changements
                                                │
                                                ▼
                                         Mise à jour DB
                                                │
                                                ▼
                                    Notification si changement majeur
                                    (ex: équipement en maintenance)
```

---

## 3. Workflow de Réservation d'Équipements

### 3.1 Création de Réservation (Utilisateur)

```
┌─────────────────────┐
│ Researcher/Student  │
└──────────┬──────────┘
           │
           ├── Parcourt /materials (liste équipements)
           │
           ├── Filtre par catégorie/disponibilité (AJAX)
           │
           ▼
┌──────────────────────┐
│ Sélectionne matériel │
│ + Date/Heure début   │
│ + Date/Heure fin     │
│ + Commentaire (opt.) │
└──────────┬───────────┘
           │
           ▼
┌───────────────────────┐
│  Validation           │
│  - Dates valides      │
│  - Pas de conflit     │
│  - Quantité dispo     │
└──────────┬────────────┘
           │
           ├── [Invalide] ──► Erreur affichée (AJAX)
           │
           ├── [Valide] ────┐
           │                │
           ▼                ▼
┌──────────────────┐  ┌─────────────────────┐
│ Créer Reservation│  │ Notification à      │
│ status: pending  │  │ Material Manager    │
└──────────┬───────┘  └─────────────────────┘
           │
           ▼
┌──────────────────────┐
│ Notification Email + │
│ DB à l'utilisateur   │
│ "Demande envoyée"    │
└──────────────────────┘
```

---

### 3.2 Validation de Réservation (Material Manager / Admin)

```
┌──────────────────────────┐
│ Material Manager / Admin │
└──────────┬───────────────┘
           │
           ├── Accède /reservations (tableau des demandes pending)
           │
           ▼
┌─────────────────────────┐
│ Voit liste réservations │
│ pending avec détails    │
└──────────┬──────────────┘
           │
           ├───[Option A: Approuver]───────────────────┐
           │                                            │
           ├───[Option B: Rejeter]─────────────────┐   │
           │                                        │   │
           ▼                                        ▼   ▼
┌──────────────────────┐              ┌────────────────────────┐
│ Status: rejected     │              │ Status: approved       │
│ + Motif (optionnel)  │              │ + Date validation      │
└──────────┬───────────┘              └────────┬───────────────┘
           │                                    │
           ▼                                    ▼
┌──────────────────────────────┐   ┌────────────────────────────┐
│ Notification Utilisateur:    │   │ Notification Utilisateur:  │
│ "Réservation refusée"        │   │ "Réservation approuvée"    │
│ Email + DB                   │   │ Email + DB                 │
└──────────────────────────────┘   └────────────────────────────┘
```

**États de réservation :**
- `pending` : En attente d'approbation
- `approved` : Approuvée, utilisateur peut utiliser l'équipement
- `rejected` : Refusée par manager
- `completed` : Utilisation terminée
- `cancelled` : Annulée par l'utilisateur

---

### 3.3 Utilisation et Fin de Réservation

```
┌────────────────────────┐
│ Réservation approved   │
└──────────┬─────────────┘
           │
           ├── [Date début atteinte]
           │
           ▼
┌─────────────────────────┐
│ Utilisateur utilise     │
│ l'équipement            │
└──────────┬──────────────┘
           │
           ├── [Date fin atteinte]
           │
           ▼
┌─────────────────────────┐
│ Status: completed       │
│ (automatique ou manuel) │
└──────────┬──────────────┘
           │
           ▼
┌─────────────────────────┐
│ Équipement redevient    │
│ disponible pour autres  │
└─────────────────────────┘
```

---

## 4. Workflow de Maintenance d'Équipements

### 4.1 Signalement Maintenance

```
┌──────────────────────┐
│ Technician/Admin     │
└──────────┬───────────┘
           │
           ├── Détecte problème équipement
           │
           ▼
┌────────────────────────────┐
│ Accède /materials/{id}/edit│
│ Change status: maintenance │
│ + Description problème     │
│ + Date estimée réparation  │
└──────────┬───────────────────┘
           │
           ▼
┌─────────────────────────────────┐
│ Material status = maintenance   │
│ + Créer MaintenanceLog          │
└──────────┬──────────────────────┘
           │
           ▼
┌──────────────────────────────────────┐
│ Notifications:                       │
│ - Utilisateurs avec réservations     │
│   futures sur cet équipement         │
│ - Admin/Material Manager             │
└──────────────────────────────────────┘
```

---

### 4.2 Fin de Maintenance

```
┌──────────────────────┐
│ Technician           │
└──────────┬───────────┘
           │
           ├── Réparation terminée
           │
           ▼
┌────────────────────────────┐
│ Update MaintenanceLog      │
│ - completed_at: now()      │
│ - Notes réparation         │
└──────────┬───────────────────┘
           │
           ▼
┌────────────────────────────┐
│ Material status: available │
└──────────┬───────────────────┘
           │
           ▼
┌─────────────────────────────┐
│ Notification utilisateurs   │
│ "Équipement de nouveau dispo"│
└─────────────────────────────┘
```

---

## 5. Workflow de Gestion de Projets

### 5.1 Création de Projet

```
┌──────────────────────┐
│ Admin / Researcher   │
└──────────┬───────────┘
           │
           ├── Accède /projects/create
           │
           ▼
┌──────────────────────────────┐
│ Formulaire Projet            │
│ - Title                      │
│ - Description                │
│ - Start date                 │
│ - End date (optional)        │
│ - Assigned users (multiple)  │
│ - Status: active             │
└──────────┬───────────────────┘
           │
           ▼
┌──────────────────────┐
│ Créer Project        │
└──────────┬───────────┘
           │
           ▼
┌────────────────────────────────┐
│ Notifications membres assignés │
│ Email + DB                     │
└────────────────────────────────┘
```

---

### 5.2 Soumission d'Expérience/Résultats

```
┌──────────────────────────┐
│ Membre du projet         │
└──────────┬───────────────┘
           │
           ├── Accède /projects/{id}
           │
           ├── Clique "Soumettre résultats"
           │
           ▼
┌────────────────────────────┐
│ Formulaire Soumission      │
│ - Title                    │
│ - Description              │
│ - Fichiers (PDF, Excel...) │
│ - Type: experiment/report  │
└──────────┬─────────────────┘
           │
           ▼
┌──────────────────────┐
│ Upload fichiers      │
│ storage/submissions/ │
└──────────┬───────────┘
           │
           ▼
┌──────────────────────┐
│ Créer Experiment     │
│ + lien Project       │
└──────────┬───────────┘
           │
           ▼
┌─────────────────────────────────┐
│ Notifications:                  │
│ - Chef de projet (si défini)    │
│ - Autres membres du projet      │
│ "Nouvelle soumission ajoutée"   │
└─────────────────────────────────┘
```

---

### 5.3 Collaboration (Commentaires)

```
Membre du projet ──► Accède /projects/{id}
                              │
                              ▼
                     Voit liste expériences/soumissions
                              │
                              ▼
                     Clique sur soumission
                              │
                              ▼
                     Thread de commentaires (AJAX)
                              │
                              ▼
                     Ajoute commentaire
                              │
                              ▼
                     Notification autres membres
```

---

## 6. Workflow de Gestion d'Événements

### 6.1 Création d'Événement

```
┌──────────────────────┐
│ Admin / Organizer    │
└──────────┬───────────┘
           │
           ├── Accède /events/create
           │
           ▼
┌──────────────────────────────┐
│ Formulaire Événement         │
│ - Title                      │
│ - Description                │
│ - Date/Heure                 │
│ - Location                   │
│ - Capacity (max attendees)   │
│ - Type: public/private       │
│ - Target roles (si private)  │
└──────────┬───────────────────┘
           │
           ▼
┌──────────────────────┐
│ Créer Event          │
└──────────┬───────────┘
           │
           ▼
┌─────────────────────────────────┐
│ Notifications:                  │
│ - Si public: tous utilisateurs  │
│ - Si private: rôles ciblés      │
│ Email + DB                      │
└─────────────────────────────────┘
```

---

### 6.2 Inscription à un Événement (RSVP)

```
┌──────────────────────┐
│ Utilisateur          │
└──────────┬───────────┘
           │
           ├── Parcourt /events (calendrier ou liste)
           │
           ├── Clique sur événement
           │
           ▼
┌──────────────────────────────┐
│ Détails événement            │
│ - Infos                      │
│ - Places disponibles         │
│ - Bouton "S'inscrire"        │
└──────────┬───────────────────┘
           │
           ├── [Si places disponibles] ────┐
           │                               │
           ├── [Si complet] ──► "Événement complet"
           │                               │
           ▼                               ▼
┌──────────────────────┐       ┌─────────────────────────┐
│ Créer EventAttendee  │       │ Notification:           │
│ user_id, event_id    │──────►│ "Inscription confirmée" │
│ status: confirmed    │       │ Email + DB              │
└──────────────────────┘       └─────────────────────────┘
```

---

### 6.3 Rappels Événements

```
┌─────────────────┐
│ Cron Job        │
│ (daily)         │
└────────┬────────┘
         │
         ├── Vérifie événements dans les prochaines 24h
         │
         ▼
┌────────────────────────────┐
│ Pour chaque événement:     │
│ - Récupère inscrits        │
│ - Envoie email reminder    │
│ - Envoie notif DB          │
└────────────────────────────┘
```

---

## 7. Workflow de Rapports et Exports

### 7.1 Génération de Rapport

```
┌──────────────────────┐
│ Admin / Manager      │
└──────────┬───────────┘
           │
           ├── Accède /reports
           │
           ▼
┌────────────────────────────┐
│ Sélectionne type rapport:  │
│ - Equipment usage          │
│ - User activity            │
│ - Reservations summary     │
│ - Project progress         │
└──────────┬─────────────────┘
           │
           ├── Sélectionne période (date range)
           │
           ▼
┌─────────────────────────────┐
│ Query DB + calculs          │
│ (peut être async si lourd)  │
└──────────┬──────────────────┘
           │
           ▼
┌─────────────────────────────┐
│ Affichage rapport HTML      │
│ + graphiques (Chart.js)     │
│ + option Export PDF/Excel   │
└─────────────────────────────┘
```

---

### 7.2 Export PDF/Excel

```
User clique "Export" ──► Job queued (Laravel Queue)
                                    │
                                    ▼
                         Worker génère fichier (PDF/Excel)
                                    │
                                    ▼
                         Stockage storage/reports/
                                    │
                                    ▼
                         Notification user + lien download
```

---

## 8. Workflow de Notifications

### 8.1 Notification Email

```
Event trigger ──► NotificationService::send()
                            │
                            ├── Créer notification DB
                            │
                            ├── Queue email job
                            │
                            ▼
                  Worker envoie email (SMTP)
                            │
                            ▼
                  Log envoi (success/failed)
```

---

### 8.2 Notification Database (In-App)

```
Event trigger ──► Créer record table notifications
                            │
                            ├── user_id
                            ├── type
                            ├── data (JSON)
                            ├── read_at: null
                            │
                            ▼
User connecté ──► AJAX polling /notifications/unread
                            │
                            ▼
                  Affiche badge compteur
                            │
User clique ──► Mark as read ──► Update read_at = now()
```

---

## 9. Workflow d'Administration Utilisateurs

### 9.1 Approbation Inscription

```
┌──────────────────────┐
│ Admin                │
└──────────┬───────────┘
           │
           ├── Accède /users?status=pending
           │
           ▼
┌────────────────────────────┐
│ Liste users pending        │
│ + infos demandées          │
└──────────┬─────────────────┘
           │
           ├── Clique "Approuver"
           │
           ▼
┌────────────────────────────┐
│ Modal: Assigner rôle       │
│ - researcher               │
│ - phd_student              │
│ - technician               │
│ - etc.                     │
└──────────┬─────────────────┘
           │
           ▼
┌────────────────────────────┐
│ Update User:               │
│ - status: active           │
│ - assignRole(selected)     │
└──────────┬─────────────────┘
           │
           ▼
┌──────────────────────────────┐
│ Notification utilisateur:    │
│ "Compte activé - rôle: XXX"  │
│ Email + DB                   │
└──────────────────────────────┘
```

---

### 9.2 Suspension/Bannissement

```
Admin ──► Accède /users/{id}
                  │
                  ├── Option "Suspend" ou "Ban"
                  │
                  ▼
          Modal: Raison + durée (si suspension)
                  │
                  ▼
          Update User:
          - status: suspended/banned
          - suspended_until: date (si suspension)
          - reason: texte
                  │
                  ▼
          Notification utilisateur
          + Déconnexion forcée si connecté
```

---

## Résumé des États Principaux

### User Status
- `pending` → `active` → `suspended` → `active` (ou `banned`)

### Reservation Status
- `pending` → `approved` / `rejected` / `cancelled`
- `approved` → `completed`

### Material Status
- `available` ↔ `maintenance` ↔ `available`
- `reserved` (virtuel, déduit des réservations actives)

### Project Status
- `active` → `completed` / `archived`

### Event Status
- `upcoming` → `ongoing` → `completed` / `cancelled`

---

## Prochaines étapes

- Consulter **03-ValidationAndStates.md** pour règles de validation détaillées
- Voir **10-Module.md** pour implémentation technique de chaque workflow
