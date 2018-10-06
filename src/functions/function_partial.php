<?php

declare(strict_types=1);

namespace Improved;

/**
 * Create a partial function, where some the arguments have been specified.
 *
 * @param callable|string $callable
 * @param mixed           ...$args
 * @return callable
 */
function function_partial($callable, ...$args): callable
{
    if (is_string($callable) && strlen($callable) <= 3 && array_key_exists($callable, _OPERATOR_REF_TABLE)) {
        $callable = _OPERATOR_REF_TABLE[$callable];
    }

    if (!is_callable($callable)) {
        $msg = "Argument 1 passed to %s() must be callable, %s given";
        throw new \TypeError(sprintf($msg, __FUNCTION__, gettype($callable)));
    }

    $index = array_keys($args, FUNCTION_ARGUMENT_PLACEHOLDER, true);

    return function (...$fnArgs) use ($callable, $args, $index) {
        if (count($fnArgs) < count($index)) {
            $msg = "Too few arguments to function %s(), %d passed while %d expected";
            $name = function_get_name($callable);
            throw new \ArgumentCountError(sprintf($msg, $name, count($fnArgs), count($index)));
        }

        foreach ($index as $i => $argPos) {
            $args[$argPos] = $fnArgs[$i];
        }

        return $callable(...$args);
    };
}
