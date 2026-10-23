<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

/**
 * Class NotFoundException
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
