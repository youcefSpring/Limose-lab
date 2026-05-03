# Models Updated for Enum Removal

## Completed:
- ✅ User.php - Removed UserStatus enum, replaced with string

## Remaining Models to Update:

### 1. Reservation.php
- Remove: `use App\Enums\ReservationStatus;`
- Change cast: `'status' => 'string'`
- Replace: `ReservationStatus::PENDING` → `'pending'`
- Replace: `ReservationStatus::APPROVED` → `'approved'`

### 2. Project.php
- Remove: `use App\Enums\ProjectStatus;`
- Change cast: `'status' => 'string'`
- Already fixed in views (using ->value)

### 3. Experiment.php
- Remove: `use App\Enums\ExperimentStatus;`
- Change cast: `'status' => 'string'`
- Replace: `ExperimentStatus::PLANNED` → `'planned'`
- Replace: `ExperimentStatus::IN_PROGRESS` → `'in_progress'`
- Replace: `ExperimentStatus::COMPLETED` → `'completed'`

### 4. MaintenanceLog.php
- Remove: `use App\Enums\MaintenanceStatus;`
- Remove: `use App\Enums\MaintenanceType;`
- Change casts: `'status' => 'string'`, `'type' => 'string'`
- Replace: `MaintenanceStatus::SCHEDULED` → `'scheduled'`
- Replace: `MaintenanceStatus::IN_PROGRESS` → `'in_progress'`
- Replace: `MaintenanceStatus::COMPLETED` → `'completed'`

### 5. Material.php
- Remove: `use App\Enums\MaterialStatus;`
- Change cast: `'status' => 'string'`

### 6. Event.php
- Check if it uses EventType enum
- If yes, replace with string
