<?php

namespace Improved\Tests\Functions;

use Improved as i;
use Improved\Tests\CallableProviderTrait;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversFunction('Improved\function_pipe')]
class FunctionPipeTest extends TestCase
{
    use CallableProviderTrait;

    #[DataProvider('callableProvider')]
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
}
