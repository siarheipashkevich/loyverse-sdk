<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class InvalidCursorException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class InvalidCursorException extends Exception
{
    /**
     * InvalidCursorException constructor.
     */
    public function __construct()
    {
        parent::__construct('The pagination cursor is incorrect.');
    }
}
