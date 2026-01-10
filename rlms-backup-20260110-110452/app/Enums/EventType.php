<?php

namespace App\Enums;

enum EventType: string
{
    case SEMINAR = 'seminar';
    case WORKSHOP = 'workshop';
    case CONFERENCE = 'conference';
    case MEETING = 'meeting';
    case TRAINING = 'training';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::SEMINAR => 'Seminar',
            self::WORKSHOP => 'Workshop',
            self::CONFERENCE => 'Conference',
            self::MEETING => 'Meeting',
            self::TRAINING => 'Training',
            self::OTHER => 'Other',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::SEMINAR => 'presentation',
            self::WORKSHOP => 'tools',
            self::CONFERENCE => 'users',
            self::MEETING => 'calendar',
            self::TRAINING => 'book-open',
            self::OTHER => 'star',
        };
    }
}
