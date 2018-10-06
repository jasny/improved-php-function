<?php

namespace Ipl\Tests\Functions;

use function Ipl\function_get_name;
use Ipl\Tests\CallableProviderTrait;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ipl\function_get_name
 * @covers \Ipl\_function_get_class_name
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
