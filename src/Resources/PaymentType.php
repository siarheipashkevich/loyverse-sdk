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
     * Enum: "CASH", "NONINTEGRATEDCARD", "CHECK", "WORLDPAY", "COINEY", "IZETTLE", "SUMUP", "TYRO", "CHECURITY",
     * "SMARTPAY", "YOCO", "NICEPAY", "PAYGATE", "EZETAP", "FIRSTDATA", "SOFTBANK", "ONEPAY", "KICC", "MERCADOPAGO",
     * "OTHER".
     *
     * @var string
     */
    public string $type;

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
