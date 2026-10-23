<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\Modifier;

/**
 * Trait ManagesModifiers
 */
trait ManagesModifiers
{
    /**
     * Get a list of modifiers.
     *
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    public function modifiers(array $parameters = []): array
    {
        return $this->getPage('modifiers', $parameters, 'modifiers', Modifier::class);
    }

    /**
     * Get a single modifier.
     */
    public function modifier(string $modifierId): Modifier
    {
        return $this->getResource("modifiers/$modifierId", Modifier::class);
    }

    /**
     * Create or update a single modifier.
     *
     * @param  array<string, mixed>  $data
     */
    public function createModifier(array $data): Modifier
    {
        return $this->resource($this->post('modifiers', $data), Modifier::class);
    }

    /**
     * Delete a single resource.
     *
     * @return array<string, mixed>
     */
    public function deleteModifier(string $modifierId): array
    {
        return $this->deleteResource("modifiers/$modifierId");
    }
}
