<?php

namespace App\Enums;

enum UserStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case SUSPENDED = 'suspended';
    case BANNED = 'banned';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::ACTIVE => 'Active',
            self::SUSPENDED => 'Suspended',
            self::BANNED => 'Banned',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::ACTIVE => 'success',
            self::SUSPENDED => 'info',
            self::BANNED => 'danger',
        };
    }
}
