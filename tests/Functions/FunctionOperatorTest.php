<?php

namespace Ipl\Tests\Functions;

use function Ipl\function_operator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Ipl\function_operator
 */
class FunctionOperatorTest extends TestCase
{
    public function arithmeticProvider()
    {
        return [
            ['+', [3, 4], 7],
            ['-', [7, 4], 3],
            ['*', [3, 4], 12],
            ['/', [12, 4], 3],
            ['%', [53, 8], 5],
            ['**', [4, 5], 1024]
        ];
    }

    /**
     * @dataProvider arithmeticProvider
     *
     * @covers \Ipl\operator_addition
     * @covers \Ipl\operator_subtraction
     * @covers \Ipl\operator_multiplication
     * @covers \Ipl\operator_division
     * @covers \Ipl\operator_modulo
     * @covers \Ipl\operator_exponentiation
     */
    function testArithmetic($operator, $args, $expected)
    {
        $fn = function_operator($operator);

        $this->assertTrue(is_callable($fn), 'is_callable');

        $this->assertEquals($expected, $fn(...$args), "'$operator' operator");
    }

    public function comparisonProvider()
    {
        return [
            ['==',  true, true, false, false, false],
            ['===', true, false, false, false, false],
            ['!=',  false, false, true, true, true],
            ['!==', false, true, true, true, true],
            ['<',   false, false, false, true, false],
            ['>',   false, false, true, false, true],
            ['<=',  true, true, false, true, false],
            ['>=',  true, true, true, false, true],
            ['<=>', 0, 0, 1, -1, 1]
        ];
    }

    /**
     * @dataProvider comparisonProvider
     *
     * @covers \Ipl\operator_equal
     * @covers \Ipl\operator_identical
     * @covers \Ipl\operator_not_equal
     * @covers \Ipl\operator_not_identical
     * @covers \Ipl\operator_less_than
     * @covers \Ipl\operator_greater_than
     * @covers \Ipl\operator_less_than_or_equal_to
     * @covers \Ipl\operator_greater_than_or_equal_to
     * @covers \Ipl\operator_spaceship
     */
    public function testComparison($operator, $a, $b, $c, $d, $e)
    {
        $fn = function_operator($operator);

        $this->assertTrue(is_callable($fn), 'is_callable');

        $this->assertEquals($a, $fn(42, 42), "'$operator' operator");
        $this->assertEquals($b, $fn(42, '42'), "'$operator' operator");
        $this->assertEquals($c, $fn(42, 'foo'), "'$operator' operator");
        $this->assertEquals($d, $fn(42, 100), "'$operator' operator");
        $this->assertEquals($e, $fn(42, -5), "'$operator' operator");
    }

    public function conditionalProvider()
    {
        return [
            ['?:', [true, 10, 42], 10],
            ['?:', [false, 10, 42], 42],
            ['?:', [10, 42, null], 42],
            ['?:', [10, 42], 10],
            ['?:', [0, 42], 42],
            ['??', [0, 42], 0],
            ['??', [null, 42], 42]
        ];
    }

    /**
     * @dataProvider conditionalProvider
     *
     * @covers \Ipl\operator_ternary
     * @covers \Ipl\operator_null_coalescing
     */
    public function testConditional($operator, $args, $expected)
    {
        $fn = function_operator($operator);

        $this->assertTrue(is_callable($fn), 'is_callable');

        $this->assertEquals($expected, $fn(...$args), "'$operator' operator");
    }

    /**
     * @covers \Ipl\operator_concatenation
     */
    public function testConcatenation()
    {
        $fn = function_operator('.');

        $this->assertTrue(is_callable($fn), 'is_callable');

        $this->assertEquals('foobar', $fn('foo', 'bar'));
    }

    public function logicalProvider()
    {
        return [
            ['&&',  false, false, false, true],
            ['and', false, false, false, true],
            ['||',  false, true, true, true],
            ['or',  false, true, true, true],
            ['xor', false, true, true, false]
        ];
    }

    /**
     * @dataProvider logicalProvider
     *
     * @covers \Ipl\operator_and
     * @covers \Ipl\operator_or
     * @covers \Ipl\operator_xor
     */
    public function testLogical($operator, $a, $b, $c, $d)
    {
        $fn = function_operator($operator);

        $this->assertTrue(is_callable($fn), 'is_callable');

        $this->assertEquals($a, $fn(false, false), "'$operator' operator");
        $this->assertEquals($b, $fn(false, true), "'$operator' operator");
        $this->assertEquals($c, $fn(true, false), "'$operator' operator");
        $this->assertEquals($d, $fn(true, true), "'$operator' operator");
    }

    public function notProvider()
    {
        return [
            ['!'],
            ['not']
        ];
    }

    /**
     * @dataProvider notProvider
     *
     * @covers \Ipl\operator_not
     */
    public function testNot($operator)
    {
        $fn = function_operator($operator);

        $this->assertTrue(is_callable($fn), 'is_callable');

        $this->assertTrue($fn(false));
        $this->assertFalse($fn(true));
    }


    public function bitwiseProvider()
    {
        return [
            ['&', 0b10100000, 0b00001010],
            ['|', 0b11111010, 0b10101111],
            ['^', 0b01011010, 0b10100101]
        ];
    }

    /**
     * @dataProvider bitwiseProvider
     *
     * @covers \Ipl\operator_bitwise_and
     * @covers \Ipl\operator_bitwise_or
     * @covers \Ipl\operator_bitwise_xor
     */
    public function testBitwise($operator, $a, $b)
    {
        $fn = function_operator($operator);

        $this->assertTrue(is_callable($fn), 'is_callable');

        $this->assertEquals($a, $fn(0b10101010, 0b11110000), "'$operator' operator");
        $this->assertEquals($b, $fn(0b10101010, 0b00001111), "'$operator' operator");
    }

    /**
     * @covers \Ipl\operator_bitwise_not
     */
    public function testBitwiseNot()
    {
        $fn = function_operator('~');

        $this->assertTrue(is_callable($fn), 'is_callable');

        $this->assertEquals(-1, $fn(0));
        $this->assertEquals(-11, $fn(10));
        $this->assertEquals(-1001, $fn(1000));
    }

    public function shiftOperator()
    {
        return [
            ['<<', 0b10100000],
            ['>>', 0b00001010]
        ];
    }

    /**
     * @dataProvider shiftOperator
     *
     * @covers \Ipl\operator_shift_left
     * @covers \Ipl\operator_shift_right
     */
    public function testShift($operator, $a)
    {
        $fn = function_operator($operator);

        $this->assertTrue(is_callable($fn), 'is_callable');

        $this->assertEquals($a, $fn(0b00101000, 2), "'$operator' operator");
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Failed to create callable from operator: unknown or unsupported operator '='
     */
    function testAssignment()
    {
        function_operator('=');
    }
}
