<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

class MissingRequiredParameterException extends ApiException
{
    /**
     * MissingRequiredParameterException constructor.
     */
    public function __construct()
    {
        parent::__construct('A required path, query, or body parameter is missing.');
    }
}
