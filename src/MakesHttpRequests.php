<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse;

use Psr\Http\Message\ResponseInterface;

trait MakesHttpRequests
{
    /**
     * Make a GET request to Loyverse servers and return the response.
     *
     * @param array<string, mixed> $payload
     */
    public function get(string $uri, array $payload = []): mixed
    {
        $options = empty($payload) ? [] : ['query' => $payload];

        return $this->request('GET', $uri, $options);
    }

    /**
     * Make a POST request to Loyverse servers and return the response.
     *
     * @param array<string, mixed> $payload
     */
    public function post(string $uri, array $payload = []): mixed
    {
        $options = empty($payload) ? [] : ['json' => $payload];

        return $this->request('POST', $uri, $options);
    }

    /**
     * Make a PUT request to Loyverse servers and return the response.
     *
     * @param array<string, mixed> $payload
     */
    public function put(string $uri, array $payload = []): mixed
    {
        $options = empty($payload) ? [] : ['json' => $payload];

        return $this->request('PUT', $uri, $options);
    }

    /**
     * Make a DELETE request to Loyverse servers and return the response.
     *
     * @param array<string, mixed> $payload
     */
    public function delete(string $uri, array $payload = []): mixed
    {
        $options = empty($payload) ? [] : ['json' => $payload];

        return $this->request('DELETE', $uri, $options);
    }

    /**
     * Make a request with a raw body to Loyverse servers and return the response.
     *
     * @param array<string, string> $headers
     */
    public function requestRaw(string $verb, string $uri, string $body, array $headers = []): mixed
    {
        return $this->request($verb, $uri, [
            'body' => $body,
            'headers' => $headers,
        ]);
    }

    /**
     * Make a POST request with a raw body to Loyverse servers and return the response.
     *
     * @param array<string, string> $headers
     */
    public function postRaw(string $uri, string $body, array $headers = []): mixed
    {
        return $this->requestRaw('POST', $uri, $body, $headers);
    }

    /**
     * Make request to Loyverse servers and return the response.
     *
     * @param array<string, mixed> $options
     */
    protected function request(string $verb, string $uri, array $options = []): mixed
    {
        if (! array_key_exists('timeout', $options)) {
            $options['timeout'] = $this->timeout;
        }

        $response = $this->guzzle->request($verb, $uri, $options);

        $status = $response->getStatusCode();

        if ($status < 200 || $status >= 300) {
            $this->handleRequestError($response);
        }

        $responseBody = (string) $response->getBody();

        $decoded = json_decode($responseBody, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $responseBody;
    }

    /**
     * Handle the request error.
     */
    protected function handleRequestError(ResponseInterface $response): never
    {
        $body = json_decode((string) $response->getBody(), true);

        $errors = is_array($body) && isset($body['errors']) && is_array($body['errors'])
            ? $body['errors']
            : [];

        $error = $errors[0] ?? [];

        $code = isset($error['code']) ? (string) $error['code'] : null;

        $status = $response->getStatusCode();

        $retryAfter = $code === 'RATE_LIMITED' ? $response->getHeaderLine('Retry-After') : null;

        $class = match ($code) {
            'INTERNAL_SERVER_ERROR' => Exceptions\InternalServerException::class,
            'BAD_REQUEST' => Exceptions\BadRequestException::class,
            'INCORRECT_VALUE_TYPE' => Exceptions\IncorrectValueTypeException::class,
            'MISSING_REQUIRED_PARAMETER' => Exceptions\MissingRequiredParameterException::class,
            'INVALID_VALUE' => Exceptions\InvalidValueException::class,
            'INVALID_RANGE' => Exceptions\InvalidRangeException::class,
            'INVALID_CURSOR' => Exceptions\InvalidCursorException::class,
            'CONFLICTING_PARAMETERS' => Exceptions\ConflictingParametersException::class,
            'UNAUTHORIZED' => Exceptions\UnauthorizedException::class,
            'PAYMENT_REQUIRED' => Exceptions\PaymentRequiredException::class,
            'FORBIDDEN' => Exceptions\ForbiddenException::class,
            'NOT_FOUND' => Exceptions\NotFoundException::class,
            'UNSUPPORTED_MEDIA_TYPE' => Exceptions\UnsupportedMediaTypeException::class,
            'RATE_LIMITED' => Exceptions\RateLimitedException::class,
            default => Exceptions\UnknownException::class,
        };

        $exception = new $class();

        throw $exception->setContext($status, $errors, $code, $retryAfter);
    }

    /**
     * Retry the callback or fail after x seconds.
     *
     * @deprecated Use retryOnRateLimit() instead.
     */
    #[\Deprecated('Use retryOnRateLimit() instead.')]
    public function retry(int $timeout, callable $callback, int $sleep = 5): mixed
    {
        $start = time();

        while (true) {
            $output = $callback();

            if ($output) {
                return $output;
            }

            if (time() - $start >= $timeout) {
                throw new Exceptions\TimeoutException(is_array($output) ? $output : null);
            }

            sleep($sleep);
        }
    }

    /**
     * Retry the callback when the API rate limit is exceeded.
     */
    public function retryOnRateLimit(
        callable $callback,
        int $maxAttempts = 3,
        int $baseDelay = 1,
        ?callable $sleeper = null
    ): mixed {
        $attempt = 0;

        while (true) {
            try {
                return $callback();
            } catch (Exceptions\RateLimitedException $exception) {
                $attempt++;

                if ($attempt >= $maxAttempts) {
                    throw $exception;
                }

                $delay = $exception->getRetryAfter();

                if ($delay === null) {
                    $delay = $baseDelay * (2 ** ($attempt - 1));
                }

                $delay = max(0, (int) $delay);

                if ($sleeper !== null) {
                    $sleeper($delay);
                } else {
                    sleep($delay);
                }
            }
        }
    }
}
