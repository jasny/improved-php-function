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
        $param = $callable === 'strtoupper' && version_compare(phpversion(), '8', '<') ? 'str' : 'string';
    
        $result = function_call_named($callable, [$param => 'Hello World!']);

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
        $param = version_compare(phpversion(), '8', '<') ? 'str' : 'string';
        
        return [
            ['yzywyzyny', [$param => 'abawabana', 'from' => 'ab', 'to' => 'yz']],
            ['yzywyzyny', [$param => 'abawabana', 'from' => ['a' => 'y', 'b' => 'z']]],
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
     */
    public function testMissing($callable, $name)
    {
        $this->expectException(\ArgumentCountError::class);
        $this->expectExceptionMessage("Too few arguments to function $name(), missing str");

        function_call_named($callable, []);
    }

    public function testStrReplaceMissing()
    {
        $this->expectException(\ArgumentCountError::class);
        $this->expectExceptionMessage("Too few arguments to function str_replace(), missing search");
    
        function_call_named('str_replace', ['subject' => 'foo', 'replace' => 'o']);
    }
}
