<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class NotFoundException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class NotFoundException extends Exception
{
    /**
     * NotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('The resource you are looking for could not be found.');
    }
}
