<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class ForbiddenException
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
