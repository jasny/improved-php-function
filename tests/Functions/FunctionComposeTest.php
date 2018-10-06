<?php

namespace Improved\Tests\Functions;

use function Improved\function_compose;
use Improved\Tests\CallableProviderTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Improved\function_compose
 */
class FunctionComposeTest extends TestCase
{
    use CallableProviderTrait;

    /**
     * @dataProvider callableProvider
     */
    public function test($callable)
    {
        $fn = function_compose(
            $callable,
            function ($str) {
                return str_replace(' ', '', $str);
            },
            'md5'
        );

        $this->assertTrue(is_callable($fn));

        $result = $fn('Hello World');

        $this->assertSame(md5('HELLOWORLD'), $result);
    }
}
