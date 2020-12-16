<?php

namespace Pashkevich\Loyverse;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Pashkevich\Loyverse\Exceptions\{FailedActionException, NotFoundException, TimeoutException, ValidationException};

/**
 * Trait MakesHttpRequests
 *
 * @package Pashkevich\Loyverse
 */
trait MakesHttpRequests
{
    /**
     * Make a GET request to Forge servers and return the response.
     *
     * @param string $uri
     * @return mixed
     */
    public function get(string $uri)
    {
        return $this->request('GET', $uri);
    }

    /**
     * Make a POST request to Forge servers and return the response.
     *
     * @param string $uri
     * @param array $payload
     * @return mixed
     */
    public function post(string $uri, array $payload = [])
    {
        return $this->request('POST', $uri, $payload);
    }

    /**
     * Make a PUT request to Forge servers and return the response.
     *
     * @param string $uri
     * @param array $payload
     * @return mixed
     */
    public function put(string $uri, array $payload = [])
    {
        return $this->request('PUT', $uri, $payload);
    }

    /**
     * Make a DELETE request to Forge servers and return the response.
     *
     * @param string $uri
     * @param array $payload
     * @return mixed
     */
    public function delete(string $uri, array $payload = [])
    {
        return $this->request('DELETE', $uri, $payload);
    }

    /**
     * Make request to Forge servers and return the response.
     *
     * @param string $verb
     * @param string $uri
     * @param array $payload
     * @return mixed
     */
    protected function request(string $verb, string $uri, array $payload = [])
    {
        $response = $this->guzzle->request($verb, $uri, empty($payload) ? [] : ['form_params' => $payload]);

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
        if ($response->getStatusCode() === 422) {
            throw new ValidationException(json_decode((string)$response->getBody(), true));
        }

        if ($response->getStatusCode() === 404) {
            throw new NotFoundException();
        }

        if ($response->getStatusCode() === 400) {
            throw new FailedActionException(json_decode((string)$response->getBody(), true));
        }

        throw new Exception((string)$response->getBody());
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

        throw new TimeoutException($output);
    }
}
