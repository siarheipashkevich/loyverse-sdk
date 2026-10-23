<?php

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class NotFoundException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class NotFoundException extends ApiException
{
    /**
     * NotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('The resource was not found.');
    }
}
