<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\PaymentType;

trait ManagesPaymentTypes
{
    /**
     * Get a list of payment types.
     *
     * @param  array<string, mixed>  $parameters
     * @return array<string, mixed>
     */
    public function paymentTypes(array $parameters = []): array
    {
        return $this->getPage('payment_types', $parameters, 'payment_types', PaymentType::class);
    }

    /**
     * Get a single payment type.
     */
    public function paymentType(string $paymentTypeId): PaymentType
    {
        return $this->getResource("payment_types/$paymentTypeId", PaymentType::class);
    }
}
