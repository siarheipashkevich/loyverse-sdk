<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class UnsupportedMediaTypeException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class UnsupportedMediaTypeException extends Exception
{
    /**
     * UnsupportedMediaTypeException constructor.
     */
    public function __construct()
    {
        parent::__construct('The server does not accept the submitted content-type.');
    }
}
