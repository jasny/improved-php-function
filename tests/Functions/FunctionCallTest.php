<?php

namespace Improved\Tests\Functions;

use function Improved\function_call;
use Improved\Tests\CallableProviderTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Improved\function_call
 */
class FunctionCallTest extends TestCase
{
    use CallableProviderTrait;

    /**
     * @dataProvider callableProvider
     */
    public function test($callable)
    {
        $result = function_call($callable, 'Hello World!');

        $this->assertSame('HELLO WORLD!', $result);
    }


    public function testStrReplace()
    {
        $result = function_call('str_replace', 'nan', 'blam', 'bananas nano conan');

        $this->assertEquals('bablamas blamo coblam', $result);
    }
}
