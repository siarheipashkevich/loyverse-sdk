<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

use Throwable;

class TlsException extends TransportException
{
    public function __construct(string $message = 'The TLS connection to Loyverse failed.', ?Throwable $previous = null)
    {
        parent::__construct($message, $previous);
    }
}
