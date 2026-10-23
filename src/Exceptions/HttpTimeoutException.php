<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

use Throwable;

class HttpTimeoutException extends TransportException
{
    public function __construct(string $message = 'The request to Loyverse timed out.', ?Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
