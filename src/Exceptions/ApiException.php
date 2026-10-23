<?php

namespace Pashkevich\Loyverse\Exceptions;

use Exception;
use Throwable;

/**
 * Class ApiException
 *
 * @package Pashkevich\Loyverse\Exceptions
 */
class ApiException extends Exception
{
    /**
     * The HTTP status code of the response.
     *
     * @var int
     */
    protected int $status = 0;

    /**
     * The list of errors returned by the API.
     *
     * @var array
     */
    protected array $errors = [];

    /**
     * The error code returned by the API.
     *
     * @var string|null
     */
    protected ?string $errorCode = null;

    /**
     * The details of the first error.
     *
     * @var string|null
     */
    protected ?string $details = null;

    /**
     * The field related to the first error.
     *
     * @var string|null
     */
    protected ?string $field = null;

    /**
     * The number of seconds to wait before retrying the request.
     *
     * @var int|null
     */
    protected ?int $retryAfter = null;

    /**
     * ApiException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Attach the error context from the API response.
     *
     * @param int $status
     * @param array $errors
     * @param string|null $errorCode
     * @param string|null $retryAfter
     * @return $this
     */
    public function setContext(
        int $status,
        array $errors = [],
        ?string $errorCode = null,
        ?string $retryAfter = null
    ): self {
        $this->status = $status;
        $this->errors = $errors;
        $this->errorCode = $errorCode;

        $error = $errors[0] ?? [];

        $this->details = isset($error['details']) ? (string)$error['details'] : null;
        $this->field = isset($error['field']) ? (string)$error['field'] : null;

        if ($retryAfter !== null && $retryAfter !== '') {
            if (is_numeric($retryAfter)) {
                $this->retryAfter = (int)$retryAfter;
            } elseif (($timestamp = strtotime($retryAfter)) !== false) {
                $this->retryAfter = max(0, $timestamp - time());
            }
        }

        return $this;
    }

    /**
     * Get the HTTP status code of the response.
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Get the list of errors returned by the API.
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * Get the error code returned by the API.
     *
     * @return string|null
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    /**
     * Get the details of the first error.
     *
     * @return string|null
     */
    public function getDetails(): ?string
    {
        return $this->details;
    }

    /**
     * Get the field related to the first error.
     *
     * @return string|null
     */
    public function getField(): ?string
    {
        return $this->field;
    }

    /**
     * Get the number of seconds to wait before retrying the request.
     *
     * @return int|null
     */
    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }
}
