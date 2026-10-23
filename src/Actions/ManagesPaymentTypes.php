<?php

namespace Pashkevich\Loyverse\Actions;

use Pashkevich\Loyverse\Resources\PaymentType;

/**
 * Trait ManagesPaymentTypes
 *
 * @package Pashkevich\Loyverse\Actions
 */
trait ManagesPaymentTypes
{
    /**
     * Get a list of payment types.
     *
     * @param array $parameters
     * @return array{payment_types: PaymentType[], cursor: string|null}
     */
    public function paymentTypes(array $parameters = []): array
    {
        return $this->transformPage($this->get('payment_types', $parameters), 'payment_types', PaymentType::class);
    }

    /**
     * Get a single payment type.
     *
     * @param string $paymentTypeId
     * @return PaymentType
     */
    public function paymentType(string $paymentTypeId): PaymentType
    {
        return new PaymentType($this->get("payment_types/$paymentTypeId"), $this);
    }
}
