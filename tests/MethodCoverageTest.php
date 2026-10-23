<?php

declare(strict_types=1);

namespace Pashkevich\Loyverse\Tests;

use Pashkevich\Loyverse\Loyverse;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;

class MethodCoverageTest extends TestCase
{
    public function test_every_action_method_has_an_endpoint_test()
    {
        $actionMethods = $this->actionMethods();
        $coveredMethods = array_keys(EndpointTest::endpointProvider());

        sort($actionMethods);
        sort($coveredMethods);

        $this->assertSame($coveredMethods, $actionMethods);
    }

    /**
     * @return string[]
     */
    private function actionMethods(): array
    {
        $reflection = new ReflectionClass(Loyverse::class);
        $methods = [];

        foreach ($reflection->getTraitNames() as $trait) {
            if (! str_starts_with($trait, 'Pashkevich\\Loyverse\\Actions\\')) {
                continue;
            }

            foreach (new ReflectionClass($trait)->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                $methods[$method->getName()] = true;
            }
        }

        return array_keys($methods);
    }
}
