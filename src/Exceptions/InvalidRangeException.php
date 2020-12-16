<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class InvalidRangeException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class InvalidRangeException extends Exception
{
    /**
     * InvalidRangeException constructor.
     */
    public function __construct()
    {
        parent::__construct('Specified time range is incorrect. For example, the end time is before the start time.');
    }
}
