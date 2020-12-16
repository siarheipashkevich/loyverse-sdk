<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class ValidationException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class ValidationException extends Exception
{
    /**
     * The array of errors.
     *
     * @var array
     */
    public array $errors;

    /**
     * ValidationException constructor.
     *
     * @param array $errors
     */
    public function __construct(array $errors)
    {
        parent::__construct('The given data failed to pass validation.');

        $this->errors = $errors;
    }

    /**
     * The array of errors.
     *
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }
}
