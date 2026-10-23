<?php

namespace Pashkevich\Loyverse;

use Pashkevich\Loyverse\Exceptions;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait MakesHttpRequests
 *
 * @package Pashkevich\Loyverse
 */
trait MakesHttpRequests
{
    /**
     * Make a GET request to Loyverse servers and return the response.
     *
     * @param string $uri
     * @param array $payload
     * @return mixed
     */
    public function get(string $uri, array $payload = [])
    {
        $options = empty($payload) ? [] : ['query' => $payload];

        return $this->request('GET', $uri, $options);
    }

    /**
     * Make a POST request to Loyverse servers and return the response.
     *
     * @param string $uri
     * @param array $payload
     * @return mixed
     */
    public function post(string $uri, array $payload = [])
    {
        $options = empty($payload) ? [] : ['json' => $payload];

        return $this->request('POST', $uri, $options);
    }

    /**
     * Make a PUT request to Loyverse servers and return the response.
     *
     * @param string $uri
     * @param array $payload
     * @return mixed
     */
    public function put(string $uri, array $payload = [])
    {
        $options = empty($payload) ? [] : ['json' => $payload];

        return $this->request('PUT', $uri, $options);
    }

    /**
     * Make a DELETE request to Loyverse servers and return the response.
     *
     * @param string $uri
     * @param array $payload
     * @return mixed
     */
    public function delete(string $uri, array $payload = [])
    {
        $options = empty($payload) ? [] : ['json' => $payload];

        return $this->request('DELETE', $uri, $options);
    }

    /**
     * Make a request with a raw body to Loyverse servers and return the response.
     *
     * @param string $verb
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return mixed
     */
    public function requestRaw(string $verb, string $uri, string $body, array $headers = [])
    {
        return $this->request($verb, $uri, [
            'body' => $body,
            'headers' => $headers,
        ]);
    }

    /**
     * Make a POST request with a raw body to Loyverse servers and return the response.
     *
     * @param string $uri
     * @param string $body
     * @param array $headers
     * @return mixed
     */
    public function postRaw(string $uri, string $body, array $headers = [])
    {
        return $this->requestRaw('POST', $uri, $body, $headers);
    }

    /**
     * Make request to Loyverse servers and return the response.
     *
     * @param string $verb
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    protected function request(string $verb, string $uri, array $options = [])
    {
        if (!array_key_exists('timeout', $options) && isset($this->timeout)) {
            $options['timeout'] = $this->timeout;
        }

        $response = $this->guzzle->request($verb, $uri, $options);

        $status = $response->getStatusCode();

        if ($status < 200 || $status >= 300) {
            $this->handleRequestError($response);
        }

        $responseBody = (string)$response->getBody();

        $decoded = json_decode($responseBody, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $responseBody;
    }

    /**
     * Handle the request error.
     *
     * @param ResponseInterface $response
     * @return void
     */
    protected function handleRequestError(ResponseInterface $response)
    {
        $body = json_decode((string)$response->getBody(), true);

        $errors = is_array($body) && isset($body['errors']) && is_array($body['errors'])
            ? $body['errors']
            : [];

        $error = $errors[0] ?? [];

        $code = isset($error['code']) ? (string)$error['code'] : null;

        $status = $response->getStatusCode();

        $retryAfter = $code === 'RATE_LIMITED' ? $response->getHeaderLine('Retry-After') : null;

        $exceptions = [
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
        ];

        $class = $code !== null && isset($exceptions[$code])
            ? $exceptions[$code]
            : Exceptions\UnknownException::class;

        /** @var Exceptions\ApiException $exception */
        $exception = new $class();

        throw $exception->setContext($status, $errors, $code, $retryAfter);
    }

    /**
     * Retry the callback or fail after x seconds.
     *
     * @param int $timeout
     * @param callable $callback
     * @param int $sleep
     * @return mixed
     */
    public function retry(int $timeout, callable $callback, int $sleep = 5)
    {
        $start = time();

        beginning:

        if ($output = $callback()) {
            return $output;
        }

        if (time() - $start < $timeout) {
            sleep($sleep);

            goto beginning;
        }

        throw new Exceptions\TimeoutException($output);
    }
}
