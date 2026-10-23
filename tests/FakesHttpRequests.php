<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

trait FakesHttpRequests
{
    protected ?MockHandler $mockHandler = null;

    protected function fakeHttpClient(): Client
    {
        $this->mockHandler = new MockHandler();

        return new Client([
            'http_errors' => false,
            'handler' => HandlerStack::create($this->mockHandler),
        ]);
    }

    protected function expectRequest(
        string $method,
        string $uri,
        array $options,
        ResponseInterface $response
    ): void {
        $this->mockHandler?->append(function (RequestInterface $request) use ($method, $uri, $options, $response) {
            $this->assertSame($method, $request->getMethod());
            $this->assertSame($uri, $request->getUri()->getPath());
            $this->assertEquals($options, $this->requestOptions($request));

            return $response;
        });
    }

    protected function requestOptions(RequestInterface $request): array
    {
        $options = [];

        $body = (string) $request->getBody();

        if ($body !== '') {
            $decoded = json_decode($body, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $options['json'] = $decoded;
            } else {
                $options['body'] = $body;
            }
        }

        $query = $request->getUri()->getQuery();

        if ($query !== '') {
            parse_str($query, $options['query']);
        }

        return $options;
    }

    protected function assertPostConditions(): void
    {
        if ($this->mockHandler !== null) {
            $this->assertCount(0, $this->mockHandler, 'Not all expected requests were made.');
        }
    }
}
