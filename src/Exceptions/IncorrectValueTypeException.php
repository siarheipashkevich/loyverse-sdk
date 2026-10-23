<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

class IncorrectValueTypeException extends ApiException
{
    /**
     * IncorrectValueTypeException constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'The JSON value type for the field is incorrect. For example, a string instead of an integer.'
        );
    }
}
