<?php

declare(strict_types=1);

namespace Ipl;

/**
 * Get a function for an operator.
 *
 * @param string $operator
 * @return callable
 */
function function_operator(string $operator): callable
{
    if (!array_key_exists($operator, _operator_ref_table)) {
        $msg = "Failed to create callable from operator: unknown or unsupported operator '%s'";
        throw new \InvalidArgumentException(sprintf($msg, $operator));
    }

    return _operator_ref_table[$operator];
}

/**
 * @internal 
 */
const _operator_ref_table = [
    '+'   => 'Ipl\\operator_addition',
    '-'   => 'Ipl\\operator_subtraction',
    '*'   => 'Ipl\\operator_multiplication',
    '/'   => 'Ipl\\operator_division',
    '%'   => 'Ipl\\operator_modulo',
    '**'  => 'Ipl\\operator_exponentiation',
    '=='  => 'Ipl\\operator_equal',
    '===' => 'Ipl\\operator_identical',
    '!='  => 'Ipl\\operator_not_equal',
    '!==' => 'Ipl\\operator_not_identical',
    '<'   => 'Ipl\\operator_less_than',
    '>'   => 'Ipl\\operator_greater_than',
    '<='  => 'Ipl\\operator_less_than_or_equal_to',
    '>='  => 'Ipl\\operator_greater_than_or_equal_to',
    '<=>' => 'Ipl\\operator_spaceship',
    '?:'  => 'Ipl\\operator_ternary',
    '??'  => 'Ipl\\operator_null_coalescing',
    '.'   => 'Ipl\\operator_concatenation',
    '&&'  => 'Ipl\\operator_and',
    'and' => 'Ipl\\operator_and',
    '||'  => 'Ipl\\operator_or',
    'or'  => 'Ipl\\operator_or',
    'xor' => 'Ipl\\operator_xor',
    '!'   => 'Ipl\\operator_not',
    'not' => 'Ipl\\operator_not',
    '&'   => 'Ipl\\operator_bitwise_and',
    '|'   => 'Ipl\\operator_bitwise_or',
    '^'   => 'Ipl\\operator_bitwise_xor',
    '~'   => 'Ipl\\operator_bitwise_not',
    '<<'  => 'Ipl\\operator_shift_left',
    '>>'  => 'Ipl\\operator_shift_right'
];

/**
 * Addition; `+` operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_addition($a, $b)
{
    return $a + $b;
}

/**
 * Subtraction; `-` operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_subtraction($a, $b)
{
    return $a - $b;
}

/**
 * Multiplication; `*` operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_multiplication($a, $b)
{
    return $a * $b;
}

/**
 * Division; `/` operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_division($a, $b)
{
    return $a / $b;
}

/**
 * Modulo; `%` operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_modulo($a, $b)
{
    return $a % $b;
}

/**
 * Exponentiation; `**` operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_exponentiation($a, $b)
{
    return $a ** $b;
}


/**
 * Equal; '==' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_equal($a, $b)
{
    return $a == $b;
}

/**
 * Identical; '===' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_identical($a, $b)
{
    return $a === $b;
}

/**
 * Not equal; '!=' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_not_equal($a, $b)
{
    return $a != $b;
}

/**
 * Not identical; '!==' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_not_identical($a, $b)
{
    return $a !== $b;
}

/**
 * Less than; '<' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_less_than($a, $b)
{
    return $a < $b;
}

/**
 * Greater than; '>' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_greater_than($a, $b)
{
    return $a > $b;
}

/**
 * Less than or equal to; '<=' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_less_than_or_equal_to($a, $b)
{
    return $a <= $b;
}

/**
 * Greater than or equal to; '>=' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_greater_than_or_equal_to($a, $b)
{
    return $a >= $b;
}

/**
 * Greater than or equal to; '<=>' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return mixed
 */
function operator_spaceship($a, $b)
{
    return $a <=> $b;
}


/**
 * Ternary; '?:' operator ($if ? $then : $else) or ($select ?: $else)
 * @internal
 *
 * @param bool  $if
 * @param mixed $then
 * @param mixed $else
 * @return mixed
 */
function operator_ternary($if, $then, $else = null)
{
    return func_num_args() == 2
        ? ($if ?: $then)
        : ($if ? $then : $else);
}

/**
 * Null coalescing; '??' operator ($select ?: $else)
 * @internal
 *
 * @param mixed $select
 * @param mixed $else
 * @return mixed
 */
function operator_null_coalescing($select, $else)
{
    return $select ?? $else;
}

/**
 * Concatenation; '.' operator
 * @internal
 *
 * @param string $a
 * @param string $b
 * @return string
 */
function operator_concatenation($a, $b)
{
    return $a . $b;
}

/**
 * Logical and; '&&' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return bool
 */
function operator_and($a, $b)
{
    return $a && $b;
}

/**
 * Logical or; '||' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return bool
 */
function operator_or($a, $b)
{
    return $a || $b;
}

/**
 * Logical xor; 'xor' operator
 * @internal
 *
 * @param mixed $a
 * @param mixed $b
 * @return bool
 */
function operator_xor($a, $b)
{
    return $a xor $b;
}

/**
 * Logical not (alias)
 * @internal
 *
 * @param bool $a
 * @return bool
 */
function operator_not($a)
{
    return !$a;
}


/**
 * Bitwise and; '&' operator
 * @internal
 *
 * @param int $a
 * @param int $b
 * @return int
 */
function operator_bitwise_and($a, $b)
{
    return $a & $b;
}

/**
 * Bitwise or; '|' operator
 * @internal
 *
 * @param int $a
 * @param int $b
 * @return int
 */
function operator_bitwise_or($a, $b)
{
    return $a | $b;
}

/**
 * Bitwise xor; '^' operator
 * @internal
 *
 * @param int $a
 * @param int $b
 * @return int
 */
function operator_bitwise_xor($a, $b)
{
    return $a ^ $b;
}

/**
 * Bitwise not; '~' operator
 * @internal
 *
 * @param int $a
 * @return int
 */
function operator_bitwise_not($a)
{
    return ~$a;
}

/**
 * Bitwise shift left; '<<' operator
 * @internal
 *
 * @param int $a
 * @param int $b
 * @return int
 */
function operator_shift_left($a, $b)
{
    return $a << $b;
}

/**
 * Bitwise shift right; '>>' operator
 * @internal
 *
 * @param int $a
 * @param int $b
 * @return int
 */
function operator_shift_right($a, $b)
{
    return $a >> $b;
}
