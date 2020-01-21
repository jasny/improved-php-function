<?php

namespace Improved\Tests\Functions;

use Improved as i;
use Improved\Tests\CallableProviderTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Improved\function_all
 */
class FunctionAllTest extends TestCase
{
    use CallableProviderTrait;

    public function test()
    {
        $accumulator = new \ArrayObject(['init']);

        $closure = function($acc) use ($accumulator) {
            $acc[] = 'closure';
        };

        $object = new class() {
            /** @var \ArrayObject */
            public $accumulator;

            function apply($acc) {
                $acc[] = 'object';
            }
        };
        $object->accumulator = $accumulator;

        $invokable = new class() {
            /** @var \ArrayObject */
            public $accumulator;

            function __invoke($acc) {
                $acc[] = 'invokable';
            }
        };
        $invokable->accumulator = $accumulator;

        $fn = i\function_all($closure, [$object, 'apply'], $invokable);
        $this->assertTrue(is_callable($fn));

        $fn($accumulator);
        $this->assertEquals(['init', 'closure', 'object', 'invokable'], $accumulator->getArrayCopy());
    }
}
