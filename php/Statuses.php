<?php

namespace App\Services;

use ReflectionClass;

trait Statuses
{
    public static function statuses(): array
    {
        return self::match('STATUS');
    }

    public static function types(): array
    {
        return self::match('TYPE');
    }

    public static function launchConditions(): array
    {
        return self::match('LAUNCH_CONDITION');
    }

    private static function match(string $const): array
    {
        $class = new ReflectionClass(__CLASS__);

        $statuses = [];
        foreach ($class->getConstants() as $name => $value) {
            if (substr($name, 0, strlen($const)) === $const) {
                $statuses[] = $value;
            }
        }

        return $statuses;
    }
}
