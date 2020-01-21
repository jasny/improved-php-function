<?php

namespace Improved\Tests\Functions;

use Improved as i;
use Improved\Tests\CallableProviderTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Improved\function_compose
 * @covers \Improved\function_pipe
 */
class FunctionPipeTest extends TestCase
{
    use CallableProviderTrait;

    /**
     * @dataProvider callableProvider
     */
    public function test($callable)
    {
        $fn = i\function_pipe(
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

    /**
     * @deprecated
     * @dataProvider callableProvider
     */
    public function testCompose($callable)
    {
        $fn = i\function_compose(
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
