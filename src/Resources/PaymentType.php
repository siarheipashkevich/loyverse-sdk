<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class PaymentType
 *
 * @package Pashkevich\Loyverse\Resources
 */
class PaymentType extends Resource
{
    /**
     * The payment type id.
     *
     * @var string
     */
    public string $id;

    /**
     * The payment type name.
     *
     * @var string
     */
    public string $name;

    /**
     * The payment type.
     *
     * @var string
     */
    public string $type;

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
