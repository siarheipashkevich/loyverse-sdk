<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Modifier;

/**
 * Trait ManagesModifiers
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesModifiers
{
    /**
     * Get a list of modifiers.
     *
     * @param array $parameters
     * @return Modifier[]
     */
    public function modifiers(array $parameters = []): array
    {
        return $this->transformCollection($this->get('modifiers', $parameters)['modifiers'], Modifier::class);
    }

    /**
     * Get a single modifier.
     *
     * @param string $modifierId
     * @return Modifier
     */
    public function modifier(string $modifierId): Modifier
    {
        return new Modifier($this->get("modifiers/$modifierId"), $this);
    }

    /**
     * Create or update a single modifier.
     *
     * @param array $data
     * @return Modifier
     */
    public function createModifier(array $data): Modifier
    {
        $item = $this->post('modifiers', $data);

        return new Modifier($item, $this);
    }

    /**
     * Delete a single resource.
     *
     * @param string $modifierId
     * @return array
     */
    public function deleteModifier(string $modifierId): array
    {
        return $this->delete("modifiers/$modifierId");
    }
}
