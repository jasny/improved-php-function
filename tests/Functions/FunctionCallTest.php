<?php

namespace Ipl\Tests\Functions;

use function Ipl\function_call;
use Ipl\Tests\CallableProviderTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ipl\function_call
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
