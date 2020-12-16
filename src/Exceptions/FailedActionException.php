<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class FailedActionException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class FailedActionException extends Exception
{
    /**
     * A parameter's value is incorrect error.
     */
    protected const INVALID_VALUE = 'INVALID_VALUE';

    /**
     * FailedActionException constructor.
     *
     * @param array $error
     */
    public function __construct(array $error)
    {
        if ($error['errors']['code'] === self::INVALID_VALUE) {
            $message = sprintf('[%s] %s', $error['errors']['field'], $error['errors']['details']);
        } else {
            $message = $error['errors']['details'];
        }

        parent::__construct($message);
    }
}
