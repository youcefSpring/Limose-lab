<?php

namespace App\Enums;

enum MaintenanceType: string
{
    case ROUTINE = 'routine';
    case REPAIR = 'repair';
    case CALIBRATION = 'calibration';
    case INSPECTION = 'inspection';
    case UPGRADE = 'upgrade';

    public function label(): string
    {
        return match($this) {
            self::ROUTINE => 'Routine Maintenance',
            self::REPAIR => 'Repair',
            self::CALIBRATION => 'Calibration',
            self::INSPECTION => 'Inspection',
            self::UPGRADE => 'Upgrade',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ROUTINE => 'info',
            self::REPAIR => 'warning',
            self::CALIBRATION => 'primary',
            self::INSPECTION => 'secondary',
            self::UPGRADE => 'success',
        };
    }
}
