<?php

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class UnauthorizedException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class UnauthorizedException extends ApiException
{
    /**
     * UnauthorizedException constructor.
     */
    public function __construct()
    {
        parent::__construct('An authentication error. Request had a missing, malformed, or invalid authorization data');
    }
}
