# SGLR Routes Summary

## Overview
This document provides a comprehensive overview of all routes implemented for the Scientific Research Laboratory Management System (SGLR).

## API Routes (Version 1)
Base URL: `/api/v1`

### Authentication Routes
- `POST /api/v1/auth/register` - User registration
- `POST /api/v1/auth/login` - User login
- `POST /api/v1/auth/logout` - User logout (Protected)
- `POST /api/v1/auth/refresh` - Refresh JWT token (Protected)
- `GET /api/v1/auth/me` - Get current user info (Protected)
- `PUT /api/v1/auth/profile` - Update user profile (Protected)
- `PUT /api/v1/auth/password` - Change password (Protected)
- `POST /api/v1/auth/forgot-password` - Request password reset
- `POST /api/v1/auth/reset-password` - Reset password
- `POST /api/v1/auth/verify-email` - Verify email address
- `POST /api/v1/auth/resend-verification` - Resend verification email (Protected)

### User Management Routes (Admin Only)
- `GET /api/v1/users` - List all users
- `POST /api/v1/users` - Create new user
- `GET /api/v1/users/{user}` - Get user details
- `PUT /api/v1/users/{user}` - Update user
- `DELETE /api/v1/users/{user}` - Delete user
- `PUT /api/v1/users/{user}/status` - Update user status
- `PUT /api/v1/users/{user}/role` - Update user role
- `GET /api/v1/users/{user}/activity` - Get user activity

### Researcher Management Routes
- `GET /api/v1/researchers` - List researchers
- `POST /api/v1/researchers` - Create researcher profile
- `GET /api/v1/researchers/search` - Search researchers
- `GET /api/v1/researchers/domains` - Get research domains
- `GET /api/v1/researchers/institutions` - Get institutions
- `GET /api/v1/researchers/{researcher}` - Get researcher details
- `PUT /api/v1/researchers/{researcher}` - Update researcher
- `DELETE /api/v1/researchers/{researcher}` - Delete researcher
- `POST /api/v1/researchers/{researcher}/sync-orcid` - Sync with ORCID
- `GET /api/v1/researchers/{researcher}/publications` - Get publications
- `GET /api/v1/researchers/{researcher}/projects` - Get projects
- `GET /api/v1/researchers/{researcher}/collaborations` - Get collaborations
- `GET /api/v1/researchers/{researcher}/statistics` - Get statistics
- `POST /api/v1/researchers/{researcher}/upload-photo` - Upload photo
- `POST /api/v1/researchers/{researcher}/upload-cv` - Upload CV

### Project Management Routes
- `GET /api/v1/projects` - List projects
- `POST /api/v1/projects` - Create project
- `GET /api/v1/projects/search` - Search projects
- `GET /api/v1/projects/my-projects` - Get user's projects
- `GET /api/v1/projects/{project}` - Get project details
- `PUT /api/v1/projects/{project}` - Update project
- `DELETE /api/v1/projects/{project}` - Delete project
- `PUT /api/v1/projects/{project}/status` - Update project status
- `POST /api/v1/projects/{project}/members` - Add project member
- `DELETE /api/v1/projects/{project}/members/{researcher}` - Remove member
- `PUT /api/v1/projects/{project}/members/{researcher}/role` - Update member role
- `GET /api/v1/projects/{project}/timeline` - Get project timeline
- `GET /api/v1/projects/{project}/statistics` - Get project statistics
- `POST /api/v1/projects/{project}/documents` - Upload documents
- `GET /api/v1/projects/{project}/documents` - Get documents
- `POST /api/v1/projects/{project}/archive` - Archive project

### Publication Management Routes
- `GET /api/v1/publications` - List publications
- `POST /api/v1/publications` - Create publication
- `GET /api/v1/publications/search` - Search publications
- `GET /api/v1/publications/types` - Get publication types
- `GET /api/v1/publications/recent` - Get recent publications
- `GET /api/v1/publications/{publication}` - Get publication details
- `PUT /api/v1/publications/{publication}` - Update publication
- `DELETE /api/v1/publications/{publication}` - Delete publication
- `PUT /api/v1/publications/{publication}/status` - Update status
- `POST /api/v1/publications/{publication}/authors` - Add author
- `DELETE /api/v1/publications/{publication}/authors/{researcher}` - Remove author
- `GET /api/v1/publications/{publication}/bibtex` - Export BibTeX
- `GET /api/v1/publications/{publication}/citations` - Get citations
- `POST /api/v1/publications/{publication}/upload-pdf` - Upload PDF
- `POST /api/v1/publications/import-doi` - Import from DOI
- `POST /api/v1/publications/import-bibtex` - Import from BibTeX

### Equipment Management Routes
- `GET /api/v1/equipment` - List equipment
- `POST /api/v1/equipment` - Create equipment
- `GET /api/v1/equipment/search` - Search equipment
- `GET /api/v1/equipment/categories` - Get categories
- `GET /api/v1/equipment/available` - Get available equipment
- `GET /api/v1/equipment/{equipment}` - Get equipment details
- `PUT /api/v1/equipment/{equipment}` - Update equipment
- `DELETE /api/v1/equipment/{equipment}` - Delete equipment
- `PUT /api/v1/equipment/{equipment}/status` - Update status
- `GET /api/v1/equipment/{equipment}/availability` - Check availability
- `POST /api/v1/equipment/{equipment}/upload-photo` - Upload photo
- `POST /api/v1/equipment/{equipment}/upload-manual` - Upload manual
- `GET /api/v1/equipment/{equipment}/maintenance-history` - Get maintenance history

### Equipment Reservation Routes
- `GET /api/v1/reservations` - List reservations
- `POST /api/v1/reservations` - Create reservation
- `GET /api/v1/reservations/my-reservations` - Get user's reservations
- `GET /api/v1/reservations/{reservation}` - Get reservation details
- `PUT /api/v1/reservations/{reservation}` - Update reservation
- `DELETE /api/v1/reservations/{reservation}` - Cancel reservation
- `PUT /api/v1/reservations/{reservation}/approve` - Approve reservation
- `PUT /api/v1/reservations/{reservation}/reject` - Reject reservation
- `POST /api/v1/reservations/{reservation}/check-in` - Check in equipment
- `POST /api/v1/reservations/{reservation}/check-out` - Check out equipment

### Event Management Routes
- `GET /api/v1/events` - List events
- `POST /api/v1/events` - Create event
- `GET /api/v1/events/search` - Search events
- `GET /api/v1/events/types` - Get event types
- `GET /api/v1/events/upcoming` - Get upcoming events
- `GET /api/v1/events/my-events` - Get user's events
- `GET /api/v1/events/{event}` - Get event details
- `PUT /api/v1/events/{event}` - Update event
- `DELETE /api/v1/events/{event}` - Delete event
- `PUT /api/v1/events/{event}/status` - Update event status
- `POST /api/v1/events/{event}/register` - Register for event
- `DELETE /api/v1/events/{event}/register` - Unregister from event
- `GET /api/v1/events/{event}/registrations` - Get registrations
- `PUT /api/v1/events/{event}/registrations/{registration}/approve` - Approve registration
- `PUT /api/v1/events/{event}/registrations/{registration}/reject` - Reject registration
- `POST /api/v1/events/{event}/upload-attachment` - Upload attachment
- `GET /api/v1/events/{event}/export-attendees` - Export attendees
- `POST /api/v1/events/{event}/send-certificates` - Send certificates

### Collaboration Management Routes
- `GET /api/v1/collaborations` - List collaborations
- `POST /api/v1/collaborations` - Create collaboration
- `GET /api/v1/collaborations/search` - Search collaborations
- `GET /api/v1/collaborations/types` - Get collaboration types
- `GET /api/v1/collaborations/countries` - Get countries
- `GET /api/v1/collaborations/network` - Get network analysis
- `GET /api/v1/collaborations/dashboard` - Get coordinator dashboard
- `GET /api/v1/collaborations/{collaboration}` - Get collaboration details
- `PUT /api/v1/collaborations/{collaboration}` - Update collaboration
- `DELETE /api/v1/collaborations/{collaboration}` - Delete collaboration
- `PUT /api/v1/collaborations/{collaboration}/status` - Update status
- `POST /api/v1/collaborations/{collaboration}/invitations` - Send invitation
- `GET /api/v1/collaborations/{collaboration}/agreement` - Generate agreement
- `POST /api/v1/collaborations/{collaboration}/documents` - Upload document
- `POST /api/v1/collaborations/{collaboration}/archive` - Archive collaboration

### Funding Management Routes
- `GET /api/v1/funding` - List funding sources
- `POST /api/v1/funding` - Create funding source
- `GET /api/v1/funding/{funding}` - Get funding details
- `PUT /api/v1/funding/{funding}` - Update funding source
- `DELETE /api/v1/funding/{funding}` - Delete funding source
- `GET /api/v1/funding/{funding}/budget` - Get budget details

### Project Funding Routes
- `POST /api/v1/project-funding` - Create project funding
- `PUT /api/v1/project-funding/{projectFunding}` - Update project funding
- `DELETE /api/v1/project-funding/{projectFunding}` - Delete project funding

### Analytics Routes
- `GET /api/v1/analytics/dashboard` - Get dashboard analytics
- `GET /api/v1/analytics/researchers` - Get researcher analytics
- `GET /api/v1/analytics/projects` - Get project analytics
- `GET /api/v1/analytics/publications` - Get publication analytics
- `GET /api/v1/analytics/equipment` - Get equipment analytics
- `GET /api/v1/analytics/personal` - Get personal analytics

### File Management Routes
- `POST /api/v1/files/upload` - Upload file
- `GET /api/v1/files/{encodedPath}/download` - Download file
- `GET /api/v1/files/{encodedPath}/info` - Get file info
- `DELETE /api/v1/files/{encodedPath}` - Delete file
- `POST /api/v1/files/cleanup` - Cleanup old files
- `GET /api/v1/files/statistics` - Get file statistics

### Mobile App Routes
Base URL: `/api/mobile/v1`

#### Public Mobile Routes
- `POST /api/mobile/v1/auth/login` - Mobile login
- `GET /api/mobile/v1/public/researchers` - Public researchers list
- `GET /api/mobile/v1/public/publications` - Public publications list
- `GET /api/mobile/v1/public/events` - Public events list

#### Protected Mobile Routes
- `GET /api/mobile/v1/dashboard` - Mobile dashboard
- `GET /api/mobile/v1/notifications` - Get notifications
- `PUT /api/mobile/v1/notifications/{id}/read` - Mark notification as read
- `GET /api/mobile/v1/profile` - Get mobile profile
- `PUT /api/mobile/v1/profile` - Update mobile profile

## Web Routes

### Public Routes
- `GET /` - Home page

### Protected Routes (Authenticated Users)
- `GET /dashboard` - Main dashboard
- `GET /dashboard/profile` - User profile
- `GET /dashboard/notifications` - Notifications
- `GET /dashboard/settings` - User settings

### Module Web Interfaces
Each module has standard CRUD web interfaces:
- Researchers (`/researchers/*`)
- Projects (`/projects/*`)
- Publications (`/publications/*`)
- Equipment (`/equipment/*`)
- Events (`/events/*`)
- Collaborations (`/collaborations/*`)
- Funding (`/funding/*`)

### Admin Routes (Admin Only)
Base URL: `/admin`
- User management
- System settings
- Analytics and reports
- System logs
- File management
- Backup and maintenance

### Lab Manager Routes (Lab Manager Only)
Base URL: `/lab-manager`
- Equipment management
- Event management
- Reports

### Utility Routes
- `GET /api-docs` - API documentation
- `GET /lang/{locale}` - Language switching

## Route Model Binding

The following models support automatic route model binding:

1. **User** - Supports ID or email lookup
2. **Researcher** - Standard ID lookup
3. **Project** - Supports ID or slug lookup
4. **Publication** - Supports ID or DOI lookup
5. **Equipment** - Standard ID lookup
6. **Reservation** - Standard ID lookup
7. **Event** - Supports ID or slug lookup
8. **Registration** - Standard ID lookup
9. **Collaboration** - Standard ID lookup
10. **Funding** - Standard ID lookup
11. **ProjectFunding** - Standard ID lookup
12. **EncodedPath** - Base64 decoded file paths with security validation

## Middleware

### Global Middleware
- **LocaleMiddleware** - Handles multilingual support (Arabic, French, English)

### API Middleware
- **Sanctum** - Stateful API authentication
- **Throttling** - Rate limiting for API endpoints

### Route Middleware
- **role** - Role-based access control
- **locale** - Language handling

### Rate Limiting
- **api** - 60 requests per minute per user/IP
- **auth** - 5 authentication attempts per minute per IP
- **uploads** - 10 file uploads per minute per user/IP

## Security Features

1. **Authentication** - Laravel Sanctum with JWT tokens
2. **Authorization** - Role-based access control (Admin, Lab Manager, Researcher, Visitor)
3. **File Security** - Base64 encoded paths with validation
4. **Rate Limiting** - Configurable throttling for different endpoints
5. **Input Validation** - Comprehensive form request validation
6. **CORS** - Cross-origin resource sharing for API access

## Multilingual Support

The system supports three languages:
- **Arabic (ar)** - Primary language with RTL support
- **French (fr)** - Secondary language
- **English (en)** - International language

Language detection priority:
1. URL parameter (`?lang=ar`)
2. Session storage
3. User preference (authenticated users)
4. Accept-Language header
5. Default to Arabic

## Testing Endpoints

To test the API endpoints, you can use tools like:
- **Postman** - GUI-based API testing
- **curl** - Command-line testing
- **Laravel's built-in testing** - PHPUnit tests

Example API call:
```bash
curl -X GET "http://localhost:8000/api/v1/researchers" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_JWT_TOKEN"
```

## Notes

1. All API routes are protected by Sanctum authentication except public endpoints
2. Role-based access control is enforced at the controller level
3. File uploads support multiple categories and types
4. Mobile app routes are optimized for mobile clients
5. All routes support pagination where applicable
6. Search endpoints support advanced filtering
7. Export/import functionality is available for publications and other data