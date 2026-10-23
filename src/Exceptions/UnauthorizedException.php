<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class UnauthorizedException
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
