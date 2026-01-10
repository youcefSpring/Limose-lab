# 09-Complete-API-Endpoints.md

## Routes Web et Endpoints du Système RLMS

**Note :** Ce système est Web-only (pas d'API REST externe). Tous les endpoints sont des routes web Laravel retournant soit des vues Blade, soit des réponses JSON pour AJAX.

---

## Convention de Notation

```
METHOD /path
Auth: [required/public]
Middleware: [list]
Permissions: [list]
Request: [parameters]
Response: [type]
```

---

## 1. Authentication Routes

### 1.1 Afficher Formulaire Connexion
```
GET /login
Auth: public (guest only)
Response: View (auth.login)
```

### 1.2 Traiter Connexion
```
POST /login
Auth: public (guest only)
Request: {
    email: string,
    password: string,
    remember: boolean (optional)
}
Response (success):
    Redirect /dashboard
Response (error):
    422 { errors: {...} }
```

### 1.3 Déconnexion
```
POST /logout
Auth: required
Response: Redirect /login
```

### 1.4 Afficher Formulaire Inscription
```
GET /register
Auth: public (guest only)
Response: View (auth.register)
```

### 1.5 Traiter Inscription
```
POST /register
Auth: public (guest only)
Request: {
    name: string,
    email: string,
    password: string,
    password_confirmation: string,
    phone: string (optional),
    research_group: string (optional)
}
Response (success):
    Redirect /dashboard (avec message "En attente d'approbation")
Response (error):
    422 { errors: {...} }
```

### 1.6 Afficher Formulaire Mot de Passe Oublié
```
GET /forgot-password
Auth: public (guest only)
Response: View (auth.forgot-password)
```

### 1.7 Envoyer Lien Réinitialisation
```
POST /forgot-password
Auth: public
Request: { email: string }
Response:
    200 { message: "Reset link sent" }
    422 { errors: {...} }
```

### 1.8 Afficher Formulaire Réinitialisation
```
GET /reset-password/{token}
Auth: public (guest only)
Query: email=xxx
Response: View (auth.reset-password)
```

### 1.9 Traiter Réinitialisation
```
POST /reset-password
Auth: public
Request: {
    token: string,
    email: string,
    password: string,
    password_confirmation: string
}
Response:
    Redirect /login (success)
    422 { errors: {...} }
```

---

## 2. Dashboard Routes

### 2.1 Tableau de Bord Principal
```
GET /dashboard
Auth: required
Middleware: auth, check-user-status
Response: View (dashboard.index)
- Adapté selon rôle utilisateur
```

---

## 3. Profile Routes

### 3.1 Voir Profil
```
GET /profile
Auth: required
Response: View (profile.show)
```

### 3.2 Éditer Profil
```
GET /profile/edit
Auth: required
Response: View (profile.edit)
```

### 3.3 Mettre à Jour Profil
```
PATCH /profile
Auth: required
Request: {
    name: string,
    email: string,
    phone: string (optional),
    avatar: file (optional),
    research_group: string (optional),
    bio: string (optional),
    locale: string (ar|fr|en)
}
Response:
    Redirect /profile (success)
    422 { errors: {...} }
```

### 3.4 Changer Mot de Passe
```
PUT /profile/password
Auth: required
Request: {
    current_password: string,
    password: string,
    password_confirmation: string
}
Response:
    200 { message: "Password updated" }
    422 { errors: {...} }
```

---

## 4. Materials Routes

### 4.1 Liste Équipements
```
GET /materials
Auth: required
Permission: view-materials
Query: {
    category: int (optional),
    status: string (optional),
    search: string (optional),
    page: int (optional)
}
Response: View (materials.index)
- Support pagination
- Filtres AJAX
```

### 4.2 Recherche AJAX Équipements
```
GET /materials/search
Auth: required
Permission: view-materials
Query: {
    q: string,
    category: int (optional),
    status: string (optional)
}
Response: 200 JSON {
    data: [
        {
            id: int,
            name: string,
            category: string,
            quantity: int,
            available_quantity: int,
            status: string,
            location: string,
            image: string|null
        }
    ],
    meta: { total, per_page, current_page }
}
```

### 4.3 Détails Équipement
```
GET /materials/{id}
Auth: required
Permission: view-materials
Response: View (materials.show)
- Détails complets
- Historique réservations
- Planning disponibilité
```

### 4.4 Formulaire Création Équipement
```
GET /materials/create
Auth: required
Permission: manage-materials
Response: View (materials.create)
```

### 4.5 Créer Équipement
```
POST /materials
Auth: required
Permission: manage-materials
Request: {
    name: string,
    description: string,
    category_id: int,
    quantity: int,
    status: string (available|maintenance|retired),
    location: string,
    serial_number: string (optional),
    purchase_date: date (optional),
    image: file (optional),
    maintenance_schedule: string (optional)
}
Response:
    Redirect /materials/{id} (success)
    422 { errors: {...} }
```

### 4.6 Formulaire Édition Équipement
```
GET /materials/{id}/edit
Auth: required
Permission: manage-materials
Response: View (materials.edit)
```

### 4.7 Mettre à Jour Équipement
```
PUT /materials/{id}
Auth: required
Permission: manage-materials
Request: [same as create]
Response:
    Redirect /materials/{id} (success)
    422 { errors: {...} }
```

### 4.8 Supprimer Équipement
```
DELETE /materials/{id}
Auth: required
Permission: manage-materials
Response:
    Redirect /materials (success)
    403 (if has active reservations)
```

---

## 5. Material Categories Routes

### 5.1 Liste Catégories
```
GET /materials/categories
Auth: required
Permission: view-materials
Response: View (materials.categories.index)
```

### 5.2 Créer Catégorie
```
POST /materials/categories
Auth: required
Permission: manage-materials
Request: {
    name: string,
    description: string (optional)
}
Response:
    Redirect /materials/categories (success)
    422 { errors: {...} }
```

---

## 6. Reservations Routes

### 6.1 Liste Toutes Réservations
```
GET /reservations
Auth: required
Permission: approve-reservations OR admin
Query: {
    status: string (optional),
    material_id: int (optional),
    user_id: int (optional),
    date_from: date (optional),
    date_to: date (optional)
}
Response: View (reservations.index)
```

### 6.2 Mes Réservations
```
GET /reservations/my
Auth: required
Response: View (reservations.my-reservations)
```

### 6.3 Réservations en Attente (Material Manager)
```
GET /reservations/pending
Auth: required
Permission: approve-reservations
Response: View (reservations.pending)
```

### 6.4 Détails Réservation
```
GET /reservations/{id}
Auth: required
Policy: view (owner or manager)
Response: View (reservations.show)
```

### 6.5 Formulaire Création Réservation
```
GET /reservations/create
Auth: required
Permission: create-reservations
Query: {
    material_id: int (optional, pre-select)
}
Response: View (reservations.create)
```

### 6.6 Créer Réservation
```
POST /reservations
Auth: required
Permission: create-reservations
Request: {
    material_id: int,
    start_date: datetime,
    end_date: datetime,
    quantity: int,
    purpose: string,
    notes: string (optional)
}
Response:
    Redirect /reservations/my (success)
    422 { errors: {...} }
    409 { message: "Conflict detected", conflicts: [...] }
```

### 6.7 Vérifier Disponibilité AJAX
```
POST /reservations/check-availability
Auth: required
Request: {
    material_id: int,
    start_date: datetime,
    end_date: datetime,
    quantity: int
}
Response: 200 JSON {
    available: boolean,
    available_quantity: int,
    conflicts: [...]
}
```

### 6.8 Approuver Réservation
```
POST /reservations/{id}/approve
Auth: required
Permission: approve-reservations
Response:
    200 { message: "Reservation approved" }
    403 (no permission)
```

### 6.9 Rejeter Réservation
```
POST /reservations/{id}/reject
Auth: required
Permission: approve-reservations
Request: {
    rejection_reason: string
}
Response:
    200 { message: "Reservation rejected" }
    422 { errors: {...} }
```

### 6.10 Annuler Réservation
```
POST /reservations/{id}/cancel
Auth: required
Policy: cancel (owner only, before start_date)
Response:
    200 { message: "Reservation cancelled" }
    403 (not allowed)
```

### 6.11 Calendrier Réservations
```
GET /reservations/calendar
Auth: required
Query: {
    material_id: int (optional),
    month: string (YYYY-MM, optional)
}
Response: View (reservations.calendar)
- FullCalendar integration
```

### 6.12 Données Calendrier AJAX
```
GET /reservations/calendar/data
Auth: required
Query: {
    start: datetime,
    end: datetime,
    material_id: int (optional)
}
Response: 200 JSON [
    {
        id: int,
        title: string,
        start: datetime,
        end: datetime,
        color: string,
        extendedProps: {...}
    }
]
```

---

## 7. Projects Routes

### 7.1 Liste Projets
```
GET /projects
Auth: required
Permission: view-projects
Query: {
    status: string (optional),
    user_id: int (optional, filter by member)
}
Response: View (projects.index)
```

### 7.2 Détails Projet
```
GET /projects/{id}
Auth: required
Policy: view (member or admin)
Response: View (projects.show)
- Détails projet
- Liste expériences/soumissions
- Membres
```

### 7.3 Dashboard Projet
```
GET /projects/{id}/dashboard
Auth: required
Policy: view
Response: View (projects.dashboard)
- Statistiques
- Activité récente
```

### 7.4 Formulaire Création Projet
```
GET /projects/create
Auth: required
Permission: manage-projects
Response: View (projects.create)
```

### 7.5 Créer Projet
```
POST /projects
Auth: required
Permission: manage-projects
Request: {
    title: string,
    description: string,
    start_date: date,
    end_date: date (optional),
    project_type: string (optional),
    assigned_users: array (user IDs)
}
Response:
    Redirect /projects/{id} (success)
    422 { errors: {...} }
```

### 7.6 Formulaire Édition Projet
```
GET /projects/{id}/edit
Auth: required
Policy: update (owner or admin)
Response: View (projects.edit)
```

### 7.7 Mettre à Jour Projet
```
PUT /projects/{id}
Auth: required
Policy: update
Request: [same as create]
Response:
    Redirect /projects/{id} (success)
    422 { errors: {...} }
```

### 7.8 Ajouter Membre
```
POST /projects/{id}/members
Auth: required
Policy: update
Request: {
    user_id: int,
    role: string (member|viewer)
}
Response:
    200 { message: "Member added" }
    422 { errors: {...} }
```

### 7.9 Retirer Membre
```
DELETE /projects/{id}/members/{user_id}
Auth: required
Policy: update
Response:
    200 { message: "Member removed" }
```

---

## 8. Experiments Routes

### 8.1 Liste Expériences (d'un projet)
```
GET /projects/{project_id}/experiments
Auth: required
Policy: view project
Response: View (experiments.index)
```

### 8.2 Détails Expérience
```
GET /experiments/{id}
Auth: required
Policy: view
Response: View (experiments.show)
- Détails
- Fichiers attachés
- Commentaires
```

### 8.3 Formulaire Soumission Expérience
```
GET /projects/{project_id}/experiments/create
Auth: required
Permission: submit-experiments
Policy: member of project
Response: View (experiments.create)
```

### 8.4 Soumettre Expérience
```
POST /projects/{project_id}/experiments
Auth: required
Permission: submit-experiments
Request: {
    title: string,
    description: string,
    experiment_type: string (report|data|publication|other),
    experiment_date: date,
    files: array (files, max 5)
}
Response:
    Redirect /experiments/{id} (success)
    422 { errors: {...} }
```

### 8.5 Télécharger Fichier Expérience
```
GET /experiments/files/{file_id}/download
Auth: required
Policy: view experiment
Response: File download
```

### 8.6 Ajouter Commentaire
```
POST /experiments/{id}/comments
Auth: required
Policy: view experiment
Request: {
    comment: string,
    parent_id: int (optional, for replies)
}
Response:
    200 JSON { comment: {...} }
    422 { errors: {...} }
```

---

## 9. Events Routes

### 9.1 Liste Événements
```
GET /events
Auth: required
Permission: view-events
Query: {
    type: string (upcoming|past, optional),
    month: string (YYYY-MM, optional)
}
Response: View (events.index)
```

### 9.2 Calendrier Événements
```
GET /events/calendar
Auth: required
Permission: view-events
Response: View (events.calendar)
```

### 9.3 Données Calendrier Événements AJAX
```
GET /events/calendar/data
Auth: required
Query: {
    start: date,
    end: date
}
Response: 200 JSON [
    {
        id: int,
        title: string,
        start: datetime,
        description: string,
        location: string,
        attendees_count: int,
        capacity: int|null
    }
]
```

### 9.4 Détails Événement
```
GET /events/{id}
Auth: required
Permission: view-events
Response: View (events.show)
- Détails
- Liste inscrits
- Bouton RSVP
```

### 9.5 Formulaire Création Événement
```
GET /events/create
Auth: required
Permission: manage-events
Response: View (events.create)
```

### 9.6 Créer Événement
```
POST /events
Auth: required
Permission: manage-events
Request: {
    title: string,
    description: string,
    event_date: date,
    event_time: time,
    location: string,
    capacity: int (optional),
    event_type: string (public|private),
    target_roles: array (if private),
    image: file (optional)
}
Response:
    Redirect /events/{id} (success)
    422 { errors: {...} }
```

### 9.7 Formulaire Édition Événement
```
GET /events/{id}/edit
Auth: required
Policy: update (creator or admin)
Response: View (events.edit)
```

### 9.8 Mettre à Jour Événement
```
PUT /events/{id}
Auth: required
Policy: update
Request: [same as create]
Response:
    Redirect /events/{id} (success)
    422 { errors: {...} }
```

### 9.9 S'inscrire à Événement (RSVP)
```
POST /events/{id}/rsvp
Auth: required
Permission: rsvp-events
Response:
    200 { message: "RSVP confirmed" }
    409 { message: "Event is full" }
```

### 9.10 Annuler Inscription
```
DELETE /events/{id}/rsvp
Auth: required
Response:
    200 { message: "RSVP cancelled" }
```

### 9.11 Annuler Événement
```
POST /events/{id}/cancel
Auth: required
Policy: update
Response:
    200 { message: "Event cancelled" }
```

---

## 10. Maintenance Routes

### 10.1 Liste Logs Maintenance
```
GET /maintenance
Auth: required
Permission: view-maintenance
Query: {
    material_id: int (optional),
    status: string (optional)
}
Response: View (maintenance.index)
```

### 10.2 Planning Maintenance
```
GET /maintenance/schedule
Auth: required
Permission: view-maintenance
Response: View (maintenance.schedule)
- Vue calendrier
```

### 10.3 Détails Log Maintenance
```
GET /maintenance/{id}
Auth: required
Permission: view-maintenance
Response: View (maintenance.show)
```

### 10.4 Formulaire Création Log
```
GET /maintenance/create
Auth: required
Permission: manage-maintenance
Query: {
    material_id: int (optional)
}
Response: View (maintenance.create)
```

### 10.5 Créer Log Maintenance
```
POST /maintenance
Auth: required
Permission: manage-maintenance
Request: {
    material_id: int,
    maintenance_type: string (preventive|corrective|inspection),
    description: string,
    scheduled_date: date,
    cost: decimal (optional),
    notes: string (optional)
}
Response:
    Redirect /maintenance/{id} (success)
    422 { errors: {...} }
```

### 10.6 Démarrer Maintenance
```
POST /maintenance/{id}/start
Auth: required
Permission: manage-maintenance
Response:
    200 { message: "Maintenance started" }
```

### 10.7 Terminer Maintenance
```
POST /maintenance/{id}/complete
Auth: required
Permission: manage-maintenance
Request: {
    completed_date: date,
    notes: string (optional),
    cost: decimal (optional)
}
Response:
    200 { message: "Maintenance completed" }
    422 { errors: {...} }
```

---

## 11. Reports Routes

### 11.1 Dashboard Rapports
```
GET /reports
Auth: required
Permission: view-reports
Response: View (reports.index)
```

### 11.2 Rapport Utilisation Équipements
```
GET /reports/equipment-usage
Auth: required
Permission: view-reports
Query: {
    date_from: date,
    date_to: date,
    material_id: int (optional),
    category_id: int (optional)
}
Response: View (reports.equipment-usage)
- Graphiques + tableaux
```

### 11.3 Rapport Activité Utilisateurs
```
GET /reports/user-activity
Auth: required
Permission: view-reports
Query: {
    date_from: date,
    date_to: date,
    user_id: int (optional),
    role: string (optional)
}
Response: View (reports.user-activity)
```

### 11.4 Résumé Réservations
```
GET /reports/reservations-summary
Auth: required
Permission: view-reports
Query: {
    date_from: date,
    date_to: date,
    status: string (optional)
}
Response: View (reports.reservations-summary)
```

### 11.5 Export Rapport PDF
```
GET /reports/{type}/export/pdf
Auth: required
Permission: export-reports
Query: [same as report type]
Response: PDF file download
```

### 11.6 Export Rapport Excel
```
GET /reports/{type}/export/excel
Auth: required
Permission: export-reports
Query: [same as report type]
Response: Excel file download
```

---

## 12. Notifications Routes

### 12.1 Liste Notifications
```
GET /notifications
Auth: required
Response: View (notifications.index)
```

### 12.2 Notifications Non Lues AJAX
```
GET /notifications/unread
Auth: required
Response: 200 JSON {
    count: int,
    notifications: [
        {
            id: string,
            type: string,
            data: {...},
            created_at: datetime
        }
    ]
}
```

### 12.3 Marquer Comme Lue
```
POST /notifications/{id}/read
Auth: required
Response:
    200 { message: "Marked as read" }
```

### 12.4 Marquer Toutes Comme Lues
```
POST /notifications/read-all
Auth: required
Response:
    200 { message: "All marked as read" }
```

---

## 13. Admin Routes

### 13.1 Dashboard Admin
```
GET /admin/dashboard
Auth: required
Role: admin
Response: View (admin.dashboard)
```

### 13.2 Liste Utilisateurs
```
GET /admin/users
Auth: required
Permission: manage-users
Query: {
    status: string (optional),
    role: string (optional),
    search: string (optional)
}
Response: View (admin.users.index)
```

### 13.3 Utilisateurs en Attente
```
GET /admin/users/pending
Auth: required
Permission: approve-users
Response: View (admin.users.pending)
```

### 13.4 Approuver Utilisateur
```
POST /admin/users/{id}/approve
Auth: required
Permission: approve-users
Request: {
    role: string
}
Response:
    200 { message: "User approved" }
    422 { errors: {...} }
```

### 13.5 Suspendre Utilisateur
```
POST /admin/users/{id}/suspend
Auth: required
Permission: manage-users
Request: {
    suspended_until: datetime (optional),
    suspension_reason: string
}
Response:
    200 { message: "User suspended" }
```

### 13.6 Bannir Utilisateur
```
POST /admin/users/{id}/ban
Auth: required
Permission: manage-users
Request: {
    reason: string
}
Response:
    200 { message: "User banned" }
```

### 13.7 Réactiver Utilisateur
```
POST /admin/users/{id}/activate
Auth: required
Permission: manage-users
Response:
    200 { message: "User activated" }
```

### 13.8 Gestion Rôles/Permissions
```
GET /admin/roles
Auth: required
Permission: manage-users
Response: View (admin.roles.index)

GET /admin/roles/{id}/edit
Auth: required
Permission: manage-users
Response: View (admin.roles.edit)

PUT /admin/roles/{id}
Auth: required
Permission: manage-users
Request: {
    permissions: array (permission IDs)
}
Response: Redirect /admin/roles
```

---

## 14. Locale Routes

### 14.1 Changer Langue
```
POST /locale
Auth: required
Request: {
    locale: string (ar|fr|en)
}
Response:
    Redirect back
```

---

## Codes de Statut HTTP

| Code | Signification |
|------|---------------|
| 200 | OK - Succès |
| 201 | Created - Ressource créée |
| 204 | No Content - Succès sans contenu |
| 302 | Redirect - Redirection |
| 401 | Unauthorized - Non authentifié |
| 403 | Forbidden - Non autorisé |
| 404 | Not Found - Ressource introuvable |
| 409 | Conflict - Conflit (ex: réservation) |
| 422 | Unprocessable Entity - Validation échouée |
| 500 | Internal Server Error - Erreur serveur |

---

## Format des Réponses d'Erreur

```json
{
    "message": "The given data was invalid.",
    "errors": {
        "field_name": [
            "Error message 1",
            "Error message 2"
        ]
    }
}
```

---

## Prochaines étapes

- Consulter **10-Module.md** pour implémentation détaillée
- Voir **02-Workflows.md** pour usage des endpoints dans les workflows
