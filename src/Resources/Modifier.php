<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Modifier
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Modifier extends Resource
{
    /**
     * The modifier id.
     *
     * @var string
     */
    public string $id;

    /**
     * The modifier name.
     *
     * @var string
     */
    public string $name;

    /**
     * Determines the position of this modifier in the modifiers list.
     *
     * @var int
     */
    public int $position;

    /**
     * The list of store ids where this modifier is available.
     *
     * @var array
     */
    public array $stores;

    /**
     * The list of modifier options.
     *
     * @var array
     */
    public array $modifierOptions;

    /**
     * The date/time the resource was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The time when this resource was updated.
     *
     * @var string
     */
    public string $updatedAt;

    /**
     * The date/time the resource was deleted.
     *
     * @var string
     */
    public string $deletedAt;

    /**
     * Update the given modifier.
     *
     * @param array $data
     * @return Modifier
     */
    public function update(array $data): Modifier
    {
        return $this->loyverse->createModifier(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given modifier.
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->loyverse->deleteModifier($this->id);
    }
}
