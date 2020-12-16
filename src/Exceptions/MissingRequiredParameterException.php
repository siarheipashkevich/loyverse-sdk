<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class MissingRequiredParameterException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class MissingRequiredParameterException extends Exception
{
    /**
     * MissingRequiredParameterException constructor.
     */
    public function __construct()
    {
        parent::__construct('A required path, query, or body parameter is missing.');
    }
}
