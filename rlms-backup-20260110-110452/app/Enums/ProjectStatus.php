<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case ACTIVE = 'active';
    case COMPLETED = 'completed';
    case ARCHIVED = 'archived';

    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'Active',
            self::COMPLETED => 'Completed',
            self::ARCHIVED => 'Archived',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'success',
            self::COMPLETED => 'info',
            self::ARCHIVED => 'secondary',
        };
    }
}
