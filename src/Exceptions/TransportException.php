<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

use Throwable;

class TransportException extends LoyverseException
{
    public function __construct(string $message = 'The request could not be completed.', ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
