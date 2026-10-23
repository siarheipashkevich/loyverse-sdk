<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Shift;

/**
 * Trait ManagesShifts
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesShifts
{
    /**
     * Get a list of shifts.
     *
     * @param array $parameters
     * @return array{shifts: Shift[], cursor: string|null}
     */
    public function shifts(array $parameters = []): array
    {
        return $this->transformPage($this->get('shifts', $parameters), 'shifts', Shift::class);
    }

    /**
     * Get a single shift.
     *
     * @param string $shiftId
     * @return Shift
     */
    public function shift(string $shiftId): Shift
    {
        return new Shift($this->get("shifts/$shiftId"), $this);
    }
}
