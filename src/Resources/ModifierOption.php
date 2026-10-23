<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ModifierOption
 *
 * @package Pashkevich\Loyverse\Resources
 */
class ModifierOption extends Resource
{
    /**
     * The option modifier id.
     *
     * @var string
     */
    public string $id;

    /**
     * The option modifier name.
     *
     * @var string
     */
    public string $name;

    /**
     * The option modifier price.
     *
     * @var float
     */
    public float $price;

    /**
     * Determines the position ot this modifier option in the modifier options list.
     *
     * @var int
     */
    public int $position;

    /**
     * The time when this resource was created.
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
     * The time when this resource was deleted.
     *
     * @var string|null
     */
    public ?string $deletedAt;
}
