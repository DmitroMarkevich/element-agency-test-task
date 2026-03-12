<?php

namespace App\Enums;

enum PersonType: string
{
    case DIRECTOR = 'director';
    case WRITER = 'writer';
    case ACTOR = 'actor';
    case COMPOSER = 'composer';

    public function label(): string
    {
        return match($this) {
            self::DIRECTOR => 'Режисер',
            self::WRITER => 'Сценарист',
            self::ACTOR => 'Актор',
            self::COMPOSER => 'Композитор',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
