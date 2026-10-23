<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Enums\Concerns;

trait HasValues
{
    /**
     * Get all enum values.
     *
     * @return string[]
     */
    public static function values(): array
    {
        return array_map(static fn (self $case): string => $case->value, self::cases());
    }
}
