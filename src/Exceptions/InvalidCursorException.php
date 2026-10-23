<?php

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class InvalidCursorException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class InvalidCursorException extends ApiException
{
    /**
     * InvalidCursorException constructor.
     */
    public function __construct()
    {
        parent::__construct('The pagination cursor is incorrect.');
    }
}
