<?php

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class PaymentRequiredException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class PaymentRequiredException extends ApiException
{
    /**
     * PaymentRequiredException constructor.
     */
    public function __construct()
    {
        parent::__construct('The subscription of account has lapsed.');
    }
}
