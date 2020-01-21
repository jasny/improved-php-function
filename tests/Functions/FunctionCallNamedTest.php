<?php

namespace Improved\Tests\Functions;

use function Improved\function_call_named;
use Improved\Tests\CallableProviderTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Improved\function_call_named
 */
class FunctionCallNamedTest extends TestCase
{
    use CallableProviderTrait;

    /**
     * @dataProvider callableProvider
     */
    public function test($callable)
    {
        $result = function_call_named($callable, ['str' => 'Hello World!']);

        $this->assertSame('HELLO WORLD!', $result);
    }

    public function strReplaceNamedArgProvider()
    {
        return [
            ['bablamas blamo coblam', ['subject' => 'bananas nano conan', 'search' => 'nan', 'replace' => 'blam']],
            ['bablamas blamo coblam', ['search' => 'nan', 'subject' => 'bananas nano conan', 'replace' => 'blam']],
            ['bablamas blamo coblam', ['replace' => 'blam', 'search' => 'nan', 'subject' => 'bananas nano conan']]
        ];
    }

    /**
     * @dataProvider strReplaceNamedArgProvider
     */
    public function testStrReplace($expect, array $args)
    {
        $this->assertEquals($expect, function_call_named('str_replace', $args));
    }

    public function strTrNamedArgProvider()
    {
        return [
            ['yzywyzyny', ['str' => 'abawabana', 'from' => 'ab', 'to' => 'yz']],
            ['yzywyzyny', ['str' => 'abawabana', 'from' => ['a' => 'y', 'b' => 'z']]],
        ];
    }

    /**
     * @dataProvider strTrNamedArgProvider
     */
    public function testStrTr($expect, array $args)
    {
        $this->assertEquals($expect, function_call_named('strtr', $args));
    }

    public function testDateTime()
    {
        $date = new \DateTime("2017-01-02T00:00:00+0000");
        $this->assertEquals('2017-01-02', function_call_named([$date, 'format'], ['format' => 'Y-m-d']));
    }


    /**
     * @dataProvider callableProvider
     * @expectedException \ArgumentCountError
     */
    public function testMissing($callable, $name)
    {
        $this->expectExceptionMessage("Too few arguments to function $name(), missing str");

        function_call_named($callable, []);
    }

    /**
     * @expectedException \ArgumentCountError
     * @expectedExceptionMessage Too few arguments to function str_replace(), missing search
     */
    public function testStrReplaceMissing()
    {
        function_call_named('str_replace', ['subject' => 'foo', 'replace' => 'o']);
    }
}
