<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class IncorrectValueTypeException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class IncorrectValueTypeException extends Exception
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
