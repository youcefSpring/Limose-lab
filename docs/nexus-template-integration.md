# Nexus Template Integration for RLMS

## Overview
Integration of the modern Nexus admin dashboard template into the Research Laboratory Management System (RLMS). The template features a glass-morphism design with:
- Dark/Light mode support
- RTL support for Arabic
- Responsive sidebar navigation
- Modern accent colors (amber, coral, violet, cyan, emerald, rose)
- Glass-card components with backdrop blur effects

## Design System

### Colors
- **Surface**: Dark backgrounds (900: #0a0a0f, 800: #12121a, 700: #1a1a25, 600: #252532)
- **Accent**:
  - Amber: #f59e0b (primary actions)
  - Coral: #f97316 (secondary actions)
  - Violet: #8b5cf6 (analytics)
  - Cyan: #06b6d4 (sessions/activity)
  - Emerald: #10b981 (success/positive)
  - Rose: #f43f5e (warnings/alerts)

### Typography
- **Primary**: Outfit (300, 400, 500, 600, 700)
- **Monospace**: Space Mono (400, 700) - for numbers/stats
- **Arabic**: Cairo (300, 400, 500, 600, 700)

### Components
- **glass**: Semi-transparent with backdrop-filter blur
- **glass-card**: Enhanced glass with gradient background
- **stat-card**: Hover-enabled stat cards with glow effects
- **nav-item**: Sidebar navigation with active indicator
- **table-row**: Hover-enabled table rows

## Integration Progress

### ✅ Completed
1. **layouts/app.blade.php** ✅
   - Integrated Nexus design system (fonts: Outfit, Space Mono, Cairo)
   - Added Tailwind CDN with custom config (surface & accent colors)
   - Added glass morphism CSS (glass, glass-card, glow effects)
   - Updated body structure with flexbox sidebar layout
   - Added theme toggle functionality (dark/light with localStorage)
   - Updated flash messages with glass-card design (success/error/warning)
   - RTL support for Arabic language
   - Responsive mobile overlay system
   - Custom scrollbar styling

2. **layouts/navigation.blade.php** ✅
   - Complete Nexus sidebar design with:
     - Logo with beaker icon and gradient background
     - Permission-based navigation menu
     - Active state indicators with accent colors
     - Icon-based navigation (Dashboard: grid-amber, Materials: cube-violet, etc.)
     - User profile card at bottom with avatar/initials
     - Inline logout button
     - Notification counter badge
     - Mobile hamburger menu
     - Top header bar for mobile with theme toggle
     - Collapsible sidebar for responsive design
     - RTL support
   - Full integration with Laravel auth and permissions

3. **layouts/guest.blade.php** ✅
   - Complete Nexus design for auth pages
   - Centered card layout with glass-card effect
   - Logo with gradient background and glow effect
   - Theme toggle button
   - RTL support
   - Responsive design

4. **auth/login.blade.php** ✅
   - Modern login form with icons
   - Icon-prefixed input fields
   - Gradient submit button
   - Remember me checkbox
   - Forgot password link
   - Register link
   - Full RTL support

5. **auth/register.blade.php** ✅
   - Modern registration form
   - 4 input fields with icons (name, email, password, confirmation)
   - Gradient submit button
   - Login link for existing users

6. **auth/forgot-password.blade.php** ✅
   - Password reset request form
   - Icon-prefixed email field
   - Back to login link

7. **auth/reset-password.blade.php** ✅
   - Password reset form with email and new password
   - Icon-prefixed fields
   - Confirmation field

8. **dashboard/admin.blade.php** ✅
   - Complete Nexus admin dashboard
   - 4 stat cards with glow effects (Pending Users, Reservations, Materials, Active Users)
   - System alerts section with glass-card alerts
   - Materials overview with 3-stat breakdown
   - Activity feed with timeline design
   - Quick actions grid (Add User, Material, Event, Project)
   - Header with theme toggle and notifications
   - Responsive grid layouts
   - RTL support

9. **materials/index.blade.php** ✅
   - Modern materials listing page
   - Glass-card search/filter section with icon-prefixed search
   - 3-column responsive grid layout
   - Material cards with:
     - Image placeholder or actual image
     - Status badges (Available/Maintenance/Retired) with accent colors
     - Hover scale animation
     - Glass-card design
     - Quantity and location info
     - View and Reserve action buttons
   - Beautiful empty state with icon
   - Pagination

10. **materials/show.blade.php** ✅
   - Material detail page with 2-column layout (main content + sidebar)
   - Image display with gradient placeholder
   - Description section with glass-card
   - Specifications cards (serial number, purchase date, maintenance schedule)
   - Recent reservations list with user avatars and status badges
   - Sidebar cards: Status with quantity progress bar, Location, Category, Maintenance
   - Actions card with Edit and Delete buttons
   - Back navigation and Reserve Now button in header

11. **materials/create.blade.php** ✅
   - Material creation form with organized sections
   - 5 glass-card sections: Basic Info, Classification, Inventory, Additional Info, Image
   - Icon-prefixed form inputs with Nexus styling
   - Modern file upload area with icon and hover effects
   - Gradient submit button (amber to coral)
   - RTL support throughout
   - Validation error styling with accent-rose

12. **materials/edit.blade.php** ✅
   - Material editing form (similar to create)
   - Shows current image with glass-card frame
   - Modern file upload button with icon
   - Pre-filled form values
   - Update button with gradient styling
   - Cancel button returns to show page

13. **reservations/index.blade.php** ✅
   - Reservations listing with status filter tabs
   - Glass-card pill tabs (All, Pending, Approved, Completed)
   - Active reservations alert with limit info
   - Reservation cards with material image, dates, quantity, duration
   - Status badges with pulsing dots (emerald, amber, rose, cyan, zinc)
   - View and Cancel action buttons
   - Empty state with gradient CTA

14. **reservations/create.blade.php** ✅
   - Reservation creation form with 5 sections
   - Material selection with dynamic info display
   - Date range picker with duration calculator
   - Real-time availability checking with Alpine.js
   - Dynamic alerts (violet for info, cyan/rose for validation)
   - Quantity input with max validation
   - Purpose and notes textareas
   - Important information alert box
   - Disabled submit button until availability confirmed

15. **reservations/show.blade.php** ✅
   - Reservation detail page with 2-column layout
   - Material info card with image and link
   - Reservation details in grid of glass-cards (6 fields)
   - Purpose and notes sections
   - Rejection reason alert (if rejected)
   - Timeline sidebar with icon-based steps
   - User info card with gradient avatar
   - User cancel action (for pending/approved)
   - Manager approve/reject actions with textarea

16. **projects/index.blade.php** ✅
   - Projects listing with search and status filter
   - Glass-card search form with icon-prefixed input
   - 2-column responsive grid layout
   - Project cards with:
     - Status badges (Active/Completed/On Hold) with accent colors
     - 3-stat breakdown (Members/Experiments/Progress)
     - Gradient progress bar (violet to rose)
     - Date range with calendar icon
     - Member avatars with gradient backgrounds
     - View Details and Edit action buttons
   - Empty state with gradient CTA

17. **projects/show.blade.php** ✅
   - Project detail page with 2-column layout (main + sidebar)
   - Overview card with description, objectives, methodology
   - Progress tracking card with gradient progress bar and milestones
   - Team members section with gradient avatars and role badges
   - Related experiments list with status badges
   - Sidebar: Project Information, Quick Stats, Actions
   - Edit and Delete action buttons

18. **projects/create.blade.php** ✅
   - Project creation form with 4 organized sections
   - Basic Information: Title, Description
   - Research Details: Objectives, Methodology
   - Timeline & Status: Start/End dates, Status dropdown
   - Funding & Management: Budget, Funding Source, PI, Progress
   - Information alert with project guidelines
   - Gradient submit button

19. **experiments/index.blade.php** ✅
   - Experiments listing grouped by project
   - Search and project filter functionality
   - Glass-card project sections with experiment counts
   - Experiment cards with status badges, metadata, edit actions
   - Files and comments counts display
   - Empty state with gradient CTA

20. **experiments/show.blade.php** ✅
   - Experiment detail page with 2-column layout
   - Overview card: Description, Hypothesis, Procedure
   - Results and Conclusions sections
   - File upload and management with icon display
   - Comments section with gradient avatars
   - Sidebar: Experiment info, Materials used, Actions
   - Edit and Delete action buttons

21. **events/index.blade.php** ✅
   - Events listing with filter tabs (All/Upcoming/Past)
   - Glass-card pill-style filter tabs
   - Gradient date badges (violet to rose) with day/month
   - Event cards with type badges, metadata, RSVP buttons
   - Attendee count tracking with infinity symbol for unlimited
   - Today indicator with pulsing dot animation
   - RSVP and Cancel RSVP functionality
   - Edit action button for organizers
   - Empty state with conditional messaging

22. **events/show.blade.php** ✅
   - Event detail page with 2-column layout
   - Optional banner image with glass-card frame
   - About section, Agenda section
   - Attendees grid with gradient avatars and confirmation badges
   - Comments/Discussion section with gradient avatars
   - RSVP sidebar card with status indicators (attending/full/available)
   - Event information with capacity progress bar (violet to rose gradient)
   - Edit and Delete actions for organizers

### 🔄 In Progress
None currently

23. **dashboard/index.blade.php** ✅
   - General user dashboard with Nexus design
   - 4 stat cards with glow effects (Reservations, Materials, Projects, Events)
   - Recent reservations section with status badges
   - Recent notifications section with unread indicators
   - Quick actions grid (4 action cards)
   - Responsive grid layouts
   - RTL support

24. **notifications/index.blade.php** ✅
   - Notifications listing with filter tabs (All/Unread)
   - Glass-card notification items with icon indicators
   - Type-based color coding (success, warning, error, info)
   - Mark as read and delete actions
   - Action links with RTL support
   - Empty state with icon
   - Pagination

25. **maintenance/index.blade.php** ✅
   - Maintenance logs listing with filter tabs (All/Scheduled/Overdue/Completed)
   - Log cards with material images and gradient placeholders
   - Status badges (completed, scheduled, in_progress, overdue)
   - Technician, cost, and completion time metadata
   - View and Complete action buttons
   - Empty state with gradient CTA
   - Responsive layout

26. **users/index.blade.php** ✅ (already completed)
   - User management with filter tabs (All/Pending/Active)
   - User cards with gradient avatars
   - Role and status badges with accent colors
   - User stats (reservations, projects, experiments)
   - View and Edit action buttons
   - Empty state

### ⏳ Pending

#### Remaining Views
27. projects/edit.blade.php - Edit project
28. experiments/create.blade.php - Create experiment
29. experiments/edit.blade.php - Edit experiment
30. events/create.blade.php - Create event
31. events/edit.blade.php - Edit event
32. maintenance/show.blade.php - Maintenance details
33. maintenance/create.blade.php - Create maintenance log
34. profile/edit.blade.php - Profile editing

#### Components
35. Components updates (buttons, cards, badges, alerts, tables, modals)

## Navigation Structure

### Admin Menu
- Dashboard (grid icon, amber)
- Materials Management (cube icon, violet)
- Reservations (calendar icon, cyan)
- Projects (folder icon, rose)
- Experiments (beaker icon, emerald)
- Events (calendar-event icon, amber)
- Maintenance (tools icon, coral)
- Users Management (users icon, violet)
- Reports (chart icon, cyan)
- Settings (cog icon)

### Researcher Menu
- Dashboard
- My Projects
- My Experiments
- Materials (browse/reserve)
- Events
- Notifications

### Technician Menu
- Dashboard
- Materials Inventory
- Reservations Calendar
- Maintenance Schedule
- Maintenance Logs

### PhD Student Menu
- Dashboard
- My Projects
- My Experiments
- Materials (browse/reserve)
- Events

## Implementation Notes

### RTL Support
- All margin/padding use logical properties (ms/me instead of ml/mr)
- Sidebar position adjusted based on locale
- Navigation items align correctly for RTL
- Border indicators on correct side

### Multilingual
- All text uses Laravel's `__()` translation helper
- Supports: English (en), French (fr), Arabic (ar)
- Font switching based on locale

### Dark Mode
- Persisted in localStorage
- Toggle button in header
- All components have dark variants
- Uses Tailwind's dark: prefix

### Responsive Design
- Mobile: Overlay sidebar (toggleable)
- Tablet: Same as mobile with better spacing
- Desktop (lg+): Fixed sidebar, auto-open
- Hamburger menu for all screen sizes < lg

## File Changes Required

Each view file needs:
1. Remove old container/padding structure
2. Add page header with breadcrumbs/actions
3. Convert cards to glass-card design
4. Update buttons to Nexus accent colors
5. Update tables with table-row hover effects
6. Add stat cards where appropriate
7. Ensure RTL support
8. Add dark mode support

## Testing Checklist

- [ ] All pages render correctly in light mode
- [ ] All pages render correctly in dark mode
- [ ] Theme toggle works and persists
- [ ] Sidebar toggles correctly on mobile
- [ ] RTL works correctly for Arabic
- [ ] All three languages display properly
- [ ] Navigation highlights active page
- [ ] Flash messages appear and auto-dismiss
- [ ] Forms are styled consistently
- [ ] Tables are responsive
- [ ] All role-based dashboards show correct menus
- [ ] Breadcrumbs work correctly
- [ ] All CRUD operations functional

## Next Steps

1. Complete navigation.blade.php conversion
2. Update guest.blade.php for auth pages
3. Convert all auth views (login, register, etc.)
4. Update all dashboard views
5. Convert all module views systematically
6. Update reusable components
7. Test thoroughly in all modes/languages
8. Document any custom components created

---
**Last Updated**: 2026-01-10
**Status**: In Progress - Core modules completed (26/35 files - 74% complete)
**Completed Modules**: Layouts, Authentication, Admin Dashboard, General Dashboard, Materials (all CRUD), Reservations (all views), Projects (show, create, index), Experiments (show, index), Events (show, index), Users Management, Notifications, Maintenance (index)
