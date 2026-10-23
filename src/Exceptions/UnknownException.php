<?php

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class UnknownException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class UnknownException extends ApiException
{
    /**
     * UnknownException constructor.
     *
     * @param string $message
     */
    public function __construct(string $message = 'An unknown error occurred.')
    {
        parent::__construct($message);
    }
}
