<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class PaymentRequiredException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class PaymentRequiredException extends Exception
{
    /**
     * PaymentRequiredException constructor.
     */
    public function __construct()
    {
        parent::__construct('The subscription of account has lapsed.');
    }
}
