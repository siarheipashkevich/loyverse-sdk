<?php

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class InternalServerException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class InternalServerException extends ApiException
{
    /**
     * InternalServerException constructor.
     */
    public function __construct()
    {
        parent::__construct('Generic internal server error. Try again later.');
    }
}
