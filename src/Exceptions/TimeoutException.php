<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

use Exception;

/**
 * Class TimeoutException
 */
class TimeoutException extends Exception
{
    /**
     * The output returned from the operation.
     *
     * @var array<string, mixed>|null
     */
    public ?array $output;

    /**
     * TimeoutException constructor.
     *
     * @param  array<string, mixed>|null  $output
     */
    public function __construct(?array $output = null)
    {
        parent::__construct('Script timed out while waiting for the process to complete.');

        $this->output = $output;
    }

    /**
     * The output returned from the operation.
     *
     * @return array<string, mixed>|null
     */
    public function output(): ?array
    {
        return $this->output;
    }
}
