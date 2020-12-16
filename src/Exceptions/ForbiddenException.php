<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class ForbiddenException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class ForbiddenException extends Exception
{
    /**
     * ForbiddenException constructor.
     */
    public function __construct()
    {
        parent::__construct('The resource requested is not available with your permissions.');
    }
}
