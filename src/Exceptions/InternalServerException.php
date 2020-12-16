<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class InternalServerException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class InternalServerException extends Exception
{
    /**
     * InternalServerException constructor.
     */
    public function __construct()
    {
        parent::__construct('Generic internal server error. Try again later.');
    }
}
