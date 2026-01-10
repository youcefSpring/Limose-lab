<?php

namespace App\Enums;

enum ExperimentStatus: string
{
    case PLANNED = 'planned';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match($this) {
            self::PLANNED => 'Planned',
            self::IN_PROGRESS => 'In Progress',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PLANNED => 'info',
            self::IN_PROGRESS => 'primary',
            self::COMPLETED => 'success',
            self::CANCELLED => 'secondary',
        };
    }
}
