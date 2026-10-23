<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

class InvalidCursorException extends ApiException
{
    /**
     * InvalidCursorException constructor.
     */
    public function __construct()
    {
        parent::__construct('The pagination cursor is incorrect.');
    }
}
