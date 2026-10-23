<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class UnknownException
 */
class UnknownException extends ApiException
{
    /**
     * UnknownException constructor.
     */
    public function __construct(string $message = 'An unknown error occurred.')
    {
        parent::__construct($message);
    }
}
