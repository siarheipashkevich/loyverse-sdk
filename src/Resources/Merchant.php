<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Resources;

class Merchant extends Resource
{
    /**
     * The merchant id.
     */
    public string $id;

    /**
     * The merchant business name.
     */
    public string $businessName;

    /**
     * The merchant email.
     */
    public string $email;

    /**
     * The country code associated with the merchant account (ISO 3166-1-alpha-2 format).
     */
    public string $country;

    /**
     * The merchant currency.
     *
     * @var array<string, mixed>
     */
    public array $currency;

    /**
     * The date and time when the merchant account was created.
     */
    public string $createdAt;
}
