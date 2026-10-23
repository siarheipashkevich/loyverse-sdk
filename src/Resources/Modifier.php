<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

use Pashkevich\Loyverse\Loyverse;

class Modifier extends Resource
{
    /**
     * The modifier id.
     */
    public string $id;

    /**
     * The modifier name.
     */
    public string $name;

    /**
     * Determines the position of this modifier in the modifiers list.
     */
    public int $position;

    /**
     * The list of store ids where this modifier is available.
     *
     * @var string[]
     */
    public array $stores;

    /**
     * The list of modifier options.
     *
     * @var array<int, ModifierOption>
     */
    public array $modifierOptions = [];

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

    /**
     * Modifier constructor.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes, ?Loyverse $loyverse = null)
    {
        parent::__construct($attributes, $loyverse);

        $this->modifierOptions = $this->transformNested('modifier_options', ModifierOption::class);
    }

    /**
     * Update the given modifier.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(array $data): Modifier
    {
        return $this->client()->createModifier(array_merge($data, ['id' => $this->id]));
    }

    /**
     * Delete the given modifier.
     *
     * @return array<string, mixed>
     */
    public function delete(): array
    {
        return $this->client()->deleteModifier($this->id);
    }
}
