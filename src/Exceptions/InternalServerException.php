<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

class InternalServerException extends ApiException
{
    /**
     * InternalServerException constructor.
     */
    public function __construct()
    {
        parent::__construct('Generic internal server error. Try again later.');
    }
}
