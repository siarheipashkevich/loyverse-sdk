<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Shift;

trait ManagesShifts
{
    /**
     * Get a list of shifts.
     *
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    public function shifts(array $parameters = []): array
    {
        return $this->getPage('shifts', $parameters, 'shifts', Shift::class);
    }

    /**
     * Get a single shift.
     */
    public function shift(string $shiftId): Shift
    {
        return $this->getResource("shifts/$shiftId", Shift::class);
    }
}
