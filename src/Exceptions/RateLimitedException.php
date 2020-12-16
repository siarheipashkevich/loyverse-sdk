<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class RateLimitedException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class RateLimitedException extends Exception
{
    /**
     * RateLimitedException constructor.
     */
    public function __construct()
    {
        parent::__construct('The request was not accepted because the application has exceeded the rate limit.');
    }
}
