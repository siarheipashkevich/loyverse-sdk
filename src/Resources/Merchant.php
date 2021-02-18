<?php

namespace Pashkevich\Loyverse\Resources;

/**
 * Class Merchant
 *
 * @package Pashkevich\Loyverse\Resources
 */
class Merchant extends Resource
{
    /**
     * The merchant id.
     *
     * @var string
     */
    public string $id;

    /**
     * The merchant business name.
     *
     * @var string
     */
    public string $businessName;

    /**
     * The merchant email.
     *
     * @var string
     */
    public string $email;

    /**
     * The country code associated with the merchant account (ISO 3166-1-alpha-2 format).
     *
     * @var string
     */
    public string $country;

    /**
     * The merchant currency.
     *
     * @var array
     */
    public array $currency;

    /**
     * The date and time when the merchant account was created.
     *
     * @var string
     */
    public string $createdAt;
}
