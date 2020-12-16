<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class ConflictingParametersException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class ConflictingParametersException extends Exception
{
    /**
     * ConflictingParametersException constructor.
     */
    public function __construct()
    {
        parent::__construct('1 or more of the request parameters conflict with each other.');
    }
}
