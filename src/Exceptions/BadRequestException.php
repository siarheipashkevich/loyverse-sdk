<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class BadRequestException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class BadRequestException extends Exception
{
    /**
     * BadRequestException constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'General client error. The request was not understood by the server, generally due to bad syntax.'
        );
    }
}
