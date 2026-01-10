<?php

namespace App\Enums;

enum MaterialStatus: string
{
    case AVAILABLE = 'available';
    case MAINTENANCE = 'maintenance';
    case RETIRED = 'retired';

    public function label(): string
    {
        return match($this) {
            self::AVAILABLE => 'Available',
            self::MAINTENANCE => 'Under Maintenance',
            self::RETIRED => 'Retired',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::AVAILABLE => 'success',
            self::MAINTENANCE => 'warning',
            self::RETIRED => 'secondary',
        };
    }
}
