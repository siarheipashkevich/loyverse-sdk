<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

class UnsupportedMediaTypeException extends ApiException
{
    /**
     * UnsupportedMediaTypeException constructor.
     */
    public function __construct()
    {
        parent::__construct('The server does not accept the submitted content-type.');
    }
}
