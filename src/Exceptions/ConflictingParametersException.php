<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

class ConflictingParametersException extends ApiException
{
    /**
     * ConflictingParametersException constructor.
     */
    public function __construct()
    {
        parent::__construct('1 or more of the request parameters conflict with each other.');
    }
}
