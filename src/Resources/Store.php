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
     * The city of the store.
     *
     * @var string
     */
    public string $city;

    /**
     * The state of the store.
     *
     * @var string
     */
    public string $state;

    /**
     * The postal code of the store.
     *
     * @var string
     */
    public string $postalCode;

    /**
     * The country of the store.
     *
     * @var string
     */
    public string $country;

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
