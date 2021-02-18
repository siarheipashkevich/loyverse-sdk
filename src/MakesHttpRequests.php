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
     * Make request to Loyverse servers and return the response.
     *
     * @param string $verb
     * @param string $uri
     * @param array $options
     * @return mixed
     */
    protected function request(string $verb, string $uri, array $options = [])
    {
        $response = $this->guzzle->request($verb, $uri, $options);

        if ($response->getStatusCode() != 200) {
            $this->handleRequestError($response);
        }

        $responseBody = (string)$response->getBody();

        return json_decode($responseBody, true) ?: $responseBody;
    }

    /**
     * Handle the request error.
     *
     * @param ResponseInterface $response
     * @return void
     */
    protected function handleRequestError(ResponseInterface $response)
    {
        $errors = json_decode((string)$response->getBody(), true)['errors'] ?? [];

        $error = $errors[0] ?? [];

        $code = $error['code'] ?? null;

        switch ($code) {
            case 'INTERNAL_SERVER_ERROR':
                throw new Exceptions\InternalServerException();

            case 'BAD_REQUEST':
                throw new Exceptions\BadRequestException();

            case 'INCORRECT_VALUE_TYPE':
                throw new Exceptions\IncorrectValueTypeException();

            case 'MISSING_REQUIRED_PARAMETER':
                throw new Exceptions\MissingRequiredParameterException();

            case 'INVALID_VALUE':
                throw new Exceptions\InvalidValueException();

            case 'INVALID_RANGE':
                throw new Exceptions\InvalidRangeException();

            case 'INVALID_CURSOR':
                throw new Exceptions\InvalidCursorException();

            case 'CONFLICTING_PARAMETERS':
                throw new Exceptions\ConflictingParametersException();

            case 'UNAUTHORIZED':
                throw new Exceptions\UnauthorizedException();

            case 'PAYMENT_REQUIRED':
                throw new Exceptions\PaymentRequiredException();

            case 'FORBIDDEN':
                throw new Exceptions\ForbiddenException();

            case 'NOT_FOUND':
                throw new Exceptions\NotFoundException();

            case 'UNSUPPORTED_MEDIA_TYPE':
                throw new Exceptions\UnsupportedMediaTypeException();

            case 'RATE_LIMITED':
                throw new Exceptions\RateLimitedException();

            default:
                throw new Exceptions\UnknownException();
        }
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
