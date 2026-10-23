<?php

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class ForbiddenException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class ForbiddenException extends ApiException
{
    /**
     * ForbiddenException constructor.
     */
    public function __construct()
    {
        parent::__construct('The resource requested is not available with your permissions.');
    }
}
