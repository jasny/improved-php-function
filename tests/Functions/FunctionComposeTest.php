<?php

namespace Ipl\Tests\Functions;

use function Ipl\function_compose;
use Ipl\Tests\CallableProviderTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ipl\function_compose
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
