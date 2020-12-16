<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class InvalidValueException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class InvalidValueException extends Exception
{
    /**
     * InvalidValueException constructor.
     */
    public function __construct()
    {
        parent::__construct('A parameter\'s value is incorrect.');
    }
}
