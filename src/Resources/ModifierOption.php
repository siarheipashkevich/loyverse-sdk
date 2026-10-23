<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class ModifierOption
 */
class ModifierOption extends Resource
{
    /**
     * The option modifier id.
     */
    public string $id;

    /**
     * The option modifier name.
     */
    public string $name;

    /**
     * The option modifier price.
     */
    public float $price;

    /**
     * Determines the position ot this modifier option in the modifier options list.
     */
    public int $position;

    /**
     * The time when this resource was created.
     */
    public string $createdAt;

    /**
     * The time when this resource was updated.
     */
    public string $updatedAt;

    /**
     * The time when this resource was deleted.
     */
    public ?string $deletedAt;
}
