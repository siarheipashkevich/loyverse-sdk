<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use GuzzleHttp\Psr7\Response;
use Pashkevich\Loyverse\Exceptions;
use Pashkevich\Loyverse\Loyverse;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ErrorHandlingTest extends TestCase
{
    use FakesHttpRequests;

    #[DataProvider('apiErrorProvider')]
    public function test_api_errors_are_mapped(string $code, int $status, string $exception): void
    {
        $loyverse = $this->loyverse();

        $this->expectRequest('GET', 'employees', [], new Response($status, [], json_encode([
            'errors' => [['code' => $code]],
        ])));

        $this->expectException($exception);

        $loyverse->employees();
    }

    /**
     * @return array<string, array{0: string, 1: int, 2: class-string<\Throwable>}>
     */
    public static function apiErrorProvider(): array
    {
        return [
            'internal server error' => ['INTERNAL_SERVER_ERROR', 500, Exceptions\InternalServerException::class],
            'bad request' => ['BAD_REQUEST', 400, Exceptions\BadRequestException::class],
            'incorrect value type' => ['INCORRECT_VALUE_TYPE', 400, Exceptions\IncorrectValueTypeException::class],
            'missing required parameter' => ['MISSING_REQUIRED_PARAMETER', 400, Exceptions\MissingRequiredParameterException::class],
            'invalid value' => ['INVALID_VALUE', 400, Exceptions\InvalidValueException::class],
            'invalid range' => ['INVALID_RANGE', 400, Exceptions\InvalidRangeException::class],
            'invalid cursor' => ['INVALID_CURSOR', 400, Exceptions\InvalidCursorException::class],
            'conflicting parameters' => ['CONFLICTING_PARAMETERS', 400, Exceptions\ConflictingParametersException::class],
            'unauthorized' => ['UNAUTHORIZED', 401, Exceptions\UnauthorizedException::class],
            'payment required' => ['PAYMENT_REQUIRED', 402, Exceptions\PaymentRequiredException::class],
            'forbidden' => ['FORBIDDEN', 403, Exceptions\ForbiddenException::class],
            'not found' => ['NOT_FOUND', 404, Exceptions\NotFoundException::class],
            'unsupported media type' => ['UNSUPPORTED_MEDIA_TYPE', 415, Exceptions\UnsupportedMediaTypeException::class],
            'rate limited' => ['RATE_LIMITED', 429, Exceptions\RateLimitedException::class],
        ];
    }

    public function test_unknown_exception(): void
    {
        $loyverse = $this->loyverse();

        $this->expectRequest('GET', 'employees', [], new Response(500));

        $this->expectException(Exceptions\UnknownException::class);

        $loyverse->employees();
    }

    public function test_exception_exposes_error_context(): void
    {
        $loyverse = $this->loyverse();

        $this->expectRequest('GET', 'employees', [], new Response(404, [], json_encode([
            'errors' => [[
                'code' => 'NOT_FOUND',
                'details' => 'The resource was not found',
                'field' => 'category_id',
            ]],
        ])));

        try {
            $loyverse->employees();
            $this->fail('Expected NotFoundException to be thrown.');
        } catch (Exceptions\NotFoundException $exception) {
            $this->assertSame(404, $exception->getStatus());
            $this->assertSame('NOT_FOUND', $exception->getErrorCode());
            $this->assertSame('The resource was not found', $exception->getDetails());
            $this->assertSame('category_id', $exception->getField());
            $this->assertCount(1, $exception->getErrors());
        }
    }

    public function test_rate_limited_exception_exposes_headers(): void
    {
        $loyverse = $this->loyverse();

        $this->expectRequest('GET', 'employees', [], new Response(429, [
            'Retry-After' => '120',
            'x-ratelimit-reset' => '1760000000',
        ], json_encode([
            'errors' => [['code' => 'RATE_LIMITED']],
        ])));

        try {
            $loyverse->employees();
            $this->fail('Expected RateLimitedException to be thrown.');
        } catch (Exceptions\RateLimitedException $exception) {
            $this->assertSame(120, $exception->getRetryAfter());
            $this->assertSame(1760000000, $exception->getRateLimitResetsAt());
        }
    }

    private function loyverse(): Loyverse
    {
        return new Loyverse('123', $this->fakeHttpClient());
    }
}
