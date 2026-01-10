<?php

namespace App\Enums;

enum MaintenanceStatus: string
{
    case SCHEDULED = 'scheduled';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match($this) {
            self::SCHEDULED => 'Scheduled',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::SCHEDULED => 'info',
            self::IN_PROGRESS => 'warning',
            self::COMPLETED => 'success',
        };
    }
}
