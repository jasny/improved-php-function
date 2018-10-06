<?php

namespace Improved\Tests\Functions;

use const Improved\function_operator;
use function Improved\function_partial;
use const Improved\FUNCTION_ARGUMENT_PLACEHOLDER as ___;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Improved\function_partial
 */
class FunctionPartialTest extends TestCase
{
    public static function stringReplace($search, $replace, $subject)
    {
        return str_replace($search, $replace, $subject);
    }

    public function provider()
    {
        $closure = function($search, $replace, $subject) {
            return str_replace($search, $replace, $subject);
        };

        $object = new class() {
            function stringReplace($search, $replace, $subject) {
                return str_replace($search, $replace, $subject);
            }
        };

        $invokable = new class() {
            function __invoke($search, $replace, $subject) {
                return str_replace($search, $replace, $subject);
            }
        };

        return [
            ['str_replace', ],
            [$closure, '{closure}'],
            [[__CLASS__, 'stringReplace'], get_called_class() . '::stringReplace'],
            [__CLASS__ . '::stringReplace', get_called_class() . '::stringReplace'],
            [[$object, 'stringReplace'], '{class@anonymous}::stringReplace'],
            [$invokable, '{class@anonymous}']
        ];
    }

    /**
     * @dataProvider provider
     */
    public function testOneArgument($callable)
    {
        $fn = function_partial($callable, ' ', ___, 'hello sweet world');

        $this->assertTrue(is_callable($fn));

        $this->assertEquals('hello/sweet/world', $fn('/'));
        $this->assertEquals('hello-sweet-world', $fn('-'));
    }

    /**
     * @dataProvider provider
     */
    public function testTwoArguments($callable)
    {
        $fn = function_partial($callable, ___, ___, 'hello sweet world');

        $this->assertTrue(is_callable($fn));

        $this->assertEquals('heLLo sweet worLd', $fn('l', 'L'));
        $this->assertEquals('hëëllo swëëëët world', $fn('e', 'ëë'));
    }

    /**
     * @dataProvider provider
     */
    public function testZeroArguments($callable)
    {
        $fn = function_partial($callable, 'world', 'planet', 'hello sweet world');

        $this->assertTrue(is_callable($fn));

        $this->assertEquals('hello sweet planet', $fn());
    }


    public function testOperator()
    {
        $tenthOf = function_partial('/', ___, 10);

        $this->assertEquals(12, $tenthOf(120));
        $this->assertEquals(4.2, $tenthOf(42));
    }


    /**
     * @dataProvider provider
     * @expectedException \ArgumentCountError
     */
    public function testMissingArguments($callable, $type)
    {
        $this->expectExceptionMessage("Too few arguments to function {$type}(), 1 passed while 2 expected");

        $fn = function_partial($callable, ___, ___, 'hello sweet world');
        $fn(' ');
    }

    public function nonCallableProvider()
    {
        return [
            ['-not-a-function-', 'string'],
            [[42, 100, 'foo'], 'array'],
            [(object)['foo' => 'bar'], 'object']
        ];
    }

    /**
     * @dataProvider nonCallableProvider
     * @expectedException TypeError
     */
    public function testTypeError($nonCallable, $type)
    {
        $this->expectExceptionMessage("Argument 1 passed to Improved\\function_partial() must be callable, $type given");

        function_partial($nonCallable);
    }
}
