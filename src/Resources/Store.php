<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Store
 */
class Store extends Resource
{
    /**
     * The id of the store.
     */
    public string $id;

    /**
     * The name of the store.
     */
    public string $name;

    /**
     * The email of the store.
     */
    public ?string $address;

    /**
     * The city of the store.
     */
    public ?string $city;

    /**
     * The state of the store.
     */
    public ?string $state = null;

    /**
     * The postal code of the store.
     */
    public ?string $postalCode;

    /**
     * The country of the store.
     */
    public ?string $country = null;

    /**
     * The phone number of the store.
     */
    public ?string $phoneNumber;

    /**
     * The description of the store.
     */
    public ?string $description;

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
