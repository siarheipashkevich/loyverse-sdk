<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Store
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Store extends Resource
{
    /**
     * The id of the store.
     *
     * @var string
     */
    public string $id;

    /**
     * The name of the store.
     *
     * @var string
     */
    public string $name;

    /**
     * The email of the store.
     *
     * @var string
     */
    public string $address;

    /**
     * The phone number of the store.
     *
     * @var string
     */
    public string $phoneNumber;

    /**
     * The description of the store.
     *
     * @var string
     */
    public string $description;

    /**
     * The date/time the resource was created.
     *
     * @var string
     */
    public string $createdAt;

    /**
     * The date/time the resource was updated.
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
}
