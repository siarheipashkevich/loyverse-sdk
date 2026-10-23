<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class RateLimitedException
 */
class RateLimitedException extends ApiException
{
    /**
     * RateLimitedException constructor.
     */
    public function __construct()
    {
        parent::__construct('The request was not accepted because the application has exceeded the rate limit.');
    }
}
