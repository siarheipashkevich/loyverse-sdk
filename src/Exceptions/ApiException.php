<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Exceptions;

use Exception;
use Throwable;

/**
 * Class ApiException
 */
class ApiException extends Exception
{
    /**
     * The HTTP status code of the response.
     */
    protected int $status = 0;

    /**
     * The list of errors returned by the API.
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $errors = [];

    /**
     * The error code returned by the API.
     */
    protected ?string $errorCode = null;

    /**
     * The details of the first error.
     */
    protected ?string $details = null;

    /**
     * The field related to the first error.
     */
    protected ?string $field = null;

    /**
     * The number of seconds to wait before retrying the request.
     */
    protected ?int $retryAfter = null;

    /**
     * ApiException constructor.
     */
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Attach the error context from the API response.
     *
     * @param  array<int, array<string, mixed>>  $errors
     * @return $this
     */
    public function setContext(
        int $status,
        array $errors = [],
        ?string $errorCode = null,
        ?string $retryAfter = null
    ): static {
        $this->status = $status;
        $this->errors = $errors;
        $this->errorCode = $errorCode;

        $error = $errors[0] ?? [];

        $this->details = isset($error['details']) ? (string) $error['details'] : null;
        $this->field = isset($error['field']) ? (string) $error['field'] : null;

        if ($retryAfter !== null && $retryAfter !== '') {
            if (is_numeric($retryAfter)) {
                $this->retryAfter = (int) $retryAfter;
            } elseif (($timestamp = strtotime($retryAfter)) !== false) {
                $this->retryAfter = max(0, $timestamp - time());
            }
        }

        return $this;
    }

    /**
     * Get the HTTP status code of the response.
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Get the list of errors returned by the API.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get the error code returned by the API.
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * Get the details of the first error.
     */
    public function getDetails(): ?string
    {
        return $this->details;
    }

    /**
     * Get the field related to the first error.
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * Get the number of seconds to wait before retrying the request.
     */
    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }
}
