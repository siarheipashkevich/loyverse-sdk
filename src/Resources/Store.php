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
     * @var string|null
     */
    public ?string $id;

    /**
     * The name of the store.
     *
     * @var string|null
     */
    public ?string $name;

    /**
     * The email of the store.
     *
     * @var string|null
     */
    public ?string $address;

    /**
     * The city of the store.
     *
     * @var string|null
     */
    public ?string $city;

    /**
     * The state of the store.
     *
     * @var string|null
     */
    public ?string $state;

    /**
     * The postal code of the store.
     *
     * @var string|null
     */
    public ?string $postalCode;

    /**
     * The country of the store.
     *
     * @var string|null
     */
    public ?string $country;

    /**
     * The phone number of the store.
     *
     * @var string|null
     */
    public ?string $phoneNumber;

    /**
     * The description of the store.
     *
     * @var string|null
     */
    public ?string $description;

    /**
     * The time when this resource was created.
     *
     * @var string|null
     */
    public ?string $createdAt;

    /**
     * The time when this resource was updated.
     *
     * @var string|null
     */
    public ?string $updatedAt;

    /**
     * The time when this resource was deleted.
     *
     * @var string|null
     */
    public ?string $deletedAt;
}
