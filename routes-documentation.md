# RLMS Routes Documentation

## Overview
This document describes all the routes available in the Research Laboratory Management System (RLMS).

## Public Routes

### Home
- `GET /` - Welcome page

## Authenticated Routes
All routes below require authentication (`auth` and `verified` middleware).

### Dashboard
- `GET /dashboard` - User dashboard (role-based view)

### Profile
- `GET /profile` - Edit profile page
- `PATCH /profile` - Update profile
- `DELETE /profile` - Delete account

### Materials
- `GET /materials` - List all materials (materials.index)
- `GET /materials/create` - Create material form (materials.create)
- `POST /materials` - Store new material (materials.store)
- `GET /materials/{material}` - Show material details (materials.show)
- `GET /materials/{material}/edit` - Edit material form (materials.edit)
- `PATCH /materials/{material}` - Update material (materials.update)
- `DELETE /materials/{material}` - Delete material (materials.destroy)

### Material Categories
- `GET /material-categories` - List all categories (material-categories.index)
- `GET /material-categories/create` - Create category form (material-categories.create)
- `POST /material-categories` - Store new category (material-categories.store)
- `GET /material-categories/{category}` - Show category details (material-categories.show)
- `GET /material-categories/{category}/edit` - Edit category form (material-categories.edit)
- `PATCH /material-categories/{category}` - Update category (material-categories.update)
- `DELETE /material-categories/{category}` - Delete category (material-categories.destroy)

### Reservations
- `GET /reservations` - List all reservations (reservations.index)
- `GET /reservations/create` - Create reservation form (reservations.create)
- `POST /reservations` - Store new reservation (reservations.store)
- `GET /reservations/{reservation}` - Show reservation details (reservations.show)
- `GET /reservations/{reservation}/edit` - Edit reservation form (reservations.edit)
- `PATCH /reservations/{reservation}` - Update reservation (reservations.update)
- `DELETE /reservations/{reservation}` - Delete reservation (reservations.destroy)
- `POST /reservations/{reservation}/approve` - Approve reservation (reservations.approve)
- `POST /reservations/{reservation}/reject` - Reject reservation (reservations.reject)
- `POST /reservations/{reservation}/cancel` - Cancel reservation (reservations.cancel)

### Projects
- `GET /projects` - List all projects (projects.index)
- `GET /projects/create` - Create project form (projects.create)
- `POST /projects` - Store new project (projects.store)
- `GET /projects/{project}` - Show project details (projects.show)
- `GET /projects/{project}/edit` - Edit project form (projects.edit)
- `PATCH /projects/{project}` - Update project (projects.update)
- `DELETE /projects/{project}` - Delete project (projects.destroy)
- `GET /projects/{project}/members` - Manage project members (projects.members)

### Experiments
- `GET /experiments` - List all experiments (experiments.index)
- `GET /experiments/create` - Create experiment form (experiments.create)
- `POST /experiments` - Store new experiment (experiments.store)
- `GET /experiments/{experiment}` - Show experiment details (experiments.show)
- `GET /experiments/{experiment}/edit` - Edit experiment form (experiments.edit)
- `PATCH /experiments/{experiment}` - Update experiment (experiments.update)
- `DELETE /experiments/{experiment}` - Delete experiment (experiments.destroy)
- `POST /experiments/{experiment}/upload-file` - Upload file to experiment (experiments.upload-file)
- `GET /experiments/{experiment}/files/{file}/download` - Download experiment file (experiments.download-file)
- `DELETE /experiments/{experiment}/files/{file}` - Delete experiment file (experiments.delete-file)
- `POST /experiments/{experiment}/comments` - Add comment to experiment (experiments.add-comment)

### Events
- `GET /events` - List all events (events.index)
- `GET /events/create` - Create event form (events.create)
- `POST /events` - Store new event (events.store)
- `GET /events/{event}` - Show event details (events.show)
- `GET /events/{event}/edit` - Edit event form (events.edit)
- `PATCH /events/{event}` - Update event (events.update)
- `DELETE /events/{event}` - Delete event (events.destroy)
- `POST /events/{event}/rsvp` - RSVP to event (events.rsvp)
- `DELETE /events/{event}/rsvp` - Cancel RSVP (events.rsvp.cancel)
- `POST /events/{event}/comments` - Add comment to event (events.add-comment)

### Maintenance Logs
- `GET /maintenance` - List all maintenance logs (maintenance.index)
- `GET /maintenance/create` - Create maintenance log form (maintenance.create)
- `POST /maintenance` - Store new maintenance log (maintenance.store)
- `GET /maintenance/{maintenance}` - Show maintenance log details (maintenance.show)
- `GET /maintenance/{maintenance}/edit` - Edit maintenance log form (maintenance.edit)
- `PATCH /maintenance/{maintenance}` - Update maintenance log (maintenance.update)
- `DELETE /maintenance/{maintenance}` - Delete maintenance log (maintenance.destroy)
- `POST /maintenance/{maintenance}/complete` - Mark maintenance as complete (maintenance.complete)

### Notifications
- `GET /notifications` - List all notifications (notifications.index)
- `POST /notifications/{notification}/mark-read` - Mark notification as read (notifications.mark-read)
- `POST /notifications/mark-all-read` - Mark all notifications as read (notifications.mark-all-read)
- `DELETE /notifications/{notification}` - Delete notification (notifications.destroy)

### Users (Admin Only)
- `GET /users` - List all users (users.index) - Requires admin permission
- `GET /users/create` - Create user form (users.create) - Requires admin permission
- `POST /users` - Store new user (users.store) - Requires admin permission
- `GET /users/{user}` - Show user details (users.show) - Requires admin permission
- `GET /users/{user}/edit` - Edit user form (users.edit) - Requires admin permission
- `PATCH /users/{user}` - Update user (users.update) - Requires admin permission
- `DELETE /users/{user}` - Delete user (users.destroy) - Requires admin permission

## Authentication Routes
Defined in `routes/auth.php`:
- Login routes
- Registration routes
- Password reset routes
- Email verification routes

## Route Parameters

### Query Parameters
Many list routes support the following query parameters:
- `filter` - Filter results (e.g., `?filter=pending`, `?filter=active`)
- `search` - Search term
- `sort` - Sort field
- `order` - Sort order (asc/desc)
- `page` - Pagination page number

### Examples
```
GET /reservations?filter=pending
GET /materials?search=microscope
GET /events?filter=upcoming
GET /notifications?filter=unread
GET /maintenance?filter=overdue
```

## Middleware

### Global Middleware
- `web` - Web middleware group (sessions, CSRF, cookies, etc.)

### Route-Specific Middleware
- `auth` - Requires authentication
- `verified` - Requires email verification
- `can:viewAny,App\Models\User` - Authorization policy check

## Notes
- All routes use named routes for easy reference in views
- Resource routes follow RESTful conventions
- Custom actions use POST/DELETE methods with descriptive names
- File operations (upload/download) have dedicated routes
- Admin routes are protected by authorization policies
