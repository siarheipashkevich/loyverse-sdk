<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

class InvalidValueException extends ApiException
{
    /**
     * InvalidValueException constructor.
     */
    public function __construct()
    {
        parent::__construct('A parameter\'s value is incorrect.');
    }
}
