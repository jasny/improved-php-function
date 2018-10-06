<?php

namespace Improved\Tests\Functions;

use function Improved\function_tail_recursion;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Improved\function_tail_recursion
 */
class FunctionTailRecursionTest extends TestCase
{
    public function test()
    {
        $sum_of_range = function_tail_recursion(function ($from, $to, $acc = 0) use (&$sum_of_range) {
            if ($from > $to) {
                return $acc;
            }

            return $sum_of_range($from + 1, $to, $acc + $from);
        });

        $this->assertTrue(is_callable($sum_of_range));

        $result = $sum_of_range(1, 10000);

        $this->assertEquals(50005000, $result);
    }
}
