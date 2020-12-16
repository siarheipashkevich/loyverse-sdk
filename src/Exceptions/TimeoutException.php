<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class TimeoutException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class TimeoutException extends Exception
{
    /**
     * The output returned from the operation.
     *
     * @var array
     */
    public array $output;

    /**
     * TimeoutException constructor.
     *
     * @param array $output
     */
    public function __construct(array $output)
    {
        parent::__construct('Script timed out while waiting for the process to complete.');

        $this->output = $output;
    }

    /**
     * The output returned from the operation.
     *
     * @return array
     */
    public function output(): array
    {
        return $this->output;
    }
}
