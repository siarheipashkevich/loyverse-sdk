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
     * @return array{shifts: Shift[], cursor: string}
     */
    public function shifts(array $parameters = []): array
    {
        $response = $this->get('shifts', $parameters);

        return [
            'shifts' => $this->transformCollection($response['shifts'], Shift::class),
            'cursor' => $response['cursor'],
        ];
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
