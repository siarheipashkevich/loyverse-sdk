<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class PaymentType extends Resource
{
    /**
     * The payment type id.
     */
    public string $id;

    /**
     * The payment type name.
     */
    public string $name;

    /**
     * The payment type.
     */
    public string $type;

    /**
     * The list of store ids where this payment type is available.
     *
     * @var string[]
     */
    public array $stores;

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
