<?php

declare(strict_types=1);

namespace Improved;

/**
 * Get a function for an operator.
 * @deprecated
 *
 * @param string $operator
 * @return callable
 */
function function_operator(string $operator): callable
{
    if (!array_key_exists($operator, _OPERATOR_REF_TABLE)) {
        $msg = "Failed to create callable from operator: unknown or unsupported operator '%s'";
        throw new \InvalidArgumentException(sprintf($msg, $operator));
    }

    /** @var callable $fn */
    $fn = _OPERATOR_REF_TABLE[$operator];

    return $fn;
}

/**
 * @internal
 */
const _OPERATOR_REF_TABLE = [
    '+'   => 'Improved\\operator_addition',
    '-'   => 'Improved\\operator_subtraction',
    '*'   => 'Improved\\operator_multiplication',
    '/'   => 'Improved\\operator_division',
    '%'   => 'Improved\\operator_modulo',
    '**'  => 'Improved\\operator_exponentiation',
    '=='  => 'Improved\\operator_equal',
    '===' => 'Improved\\operator_identical',
    '!='  => 'Improved\\operator_not_equal',
    '!==' => 'Improved\\operator_not_identical',
    '<'   => 'Improved\\operator_less_than',
    '>'   => 'Improved\\operator_greater_than',
    '<='  => 'Improved\\operator_less_than_or_equal_to',
    '>='  => 'Improved\\operator_greater_than_or_equal_to',
    '<=>' => 'Improved\\operator_spaceship',
    '?:'  => 'Improved\\operator_ternary',
    '??'  => 'Improved\\operator_null_coalescing',
    '.'   => 'Improved\\operator_concatenation',
    '&&'  => 'Improved\\operator_and',
    'and' => 'Improved\\operator_and',
    '||'  => 'Improved\\operator_or',
    'or'  => 'Improved\\operator_or',
    'xor' => 'Improved\\operator_xor',
    '!'   => 'Improved\\operator_not',
    'not' => 'Improved\\operator_not',
    '&'   => 'Improved\\operator_bitwise_and',
    '|'   => 'Improved\\operator_bitwise_or',
    '^'   => 'Improved\\operator_bitwise_xor',
    '~'   => 'Improved\\operator_bitwise_not',
    '<<'  => 'Improved\\operator_shift_left',
    '>>'  => 'Improved\\operator_shift_right'
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
 * @param bool $a
 * @param bool $b
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
 * @param bool $a
 * @param bool $b
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
 * @param bool $a
 * @param bool $b
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
