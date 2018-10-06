<?php

namespace Improved\Tests\Functions;

use function Improved\function_get_name;
use Improved\Tests\CallableProviderTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Improved\function_get_name
 * @covers \Improved\_function_get_class_name
 */
class FunctionGetNameTest extends TestCase
{
    use CallableProviderTrait;

    /**
     * @dataProvider callableProvider
     */
    public function test($callable, $name)
    {
        $result = function_get_name($callable);

        $this->assertEquals($name, $result);
    }
}
