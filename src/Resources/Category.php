<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Category
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Category extends Resource
{
    /**
     * The category id. If included in the POST request it will cause an update instead of a creating a new object.
     *
     * @var string
     */
    public string $id;

    /**
     * The name of the category.
     *
     * @var string
     */
    public string $name;

    /**
     * The color of the category.
     *
     * Enum: "GREY", "RED", "PINK", "ORANGE", "GREEN", "BLUE", "PURPLE".
     *
     * @var string
     */
    public string $color = 'GREY';

    /**
     * The date/time the resource was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The date/time the resource was deleted.
     *
     * @var string
     */
    public string $deletedAt;

    /**
     * Delete the given category.
     *
     * @return void
     */
    public function delete(): void
    {
        $this->loyverse->deleteCategory($this->id);
    }
}
