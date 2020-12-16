<?php

namespace Pashkevich\Loyverse\Tests;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Pashkevich\Loyverse\Loyverse;

class LoyverseSDKTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_making_basic_requests()
    {
        $loyverse = new Loyverse('123', $http = Mockery::mock(Client::class));

        $http->shouldReceive('request')->once()->with('GET', 'employees', [])->andReturn(
            $response = Mockery::mock(Response::class)
        );

        $response->shouldReceive('getStatusCode')->once()->andReturn(200);
        $response->shouldReceive('getBody')->once()->andReturn('{"employees": [{"key": "value"}]}');

        $this->assertCount(1, $loyverse->employees());
    }
}
