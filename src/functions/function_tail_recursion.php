<?php

declare(strict_types=1);

namespace Ipl;

// Taken from https://github.com/lstrojny/functional-php

/**
 * Decorates given function with tail recursion optimization.
 *
 * @param callable $callable
 * @return callable
 */
function function_tail_recursion(callable $callable): callable
{
    $underCall = false;
    $queue = [];

    return function (...$args) use (&$callable, &$underCall, &$queue) {
        $result = null;
        $queue[] = $args;

        if (!$underCall) {
            $underCall = true;

            while ($head = array_shift($queue)) {
                $result = $callable(...$head);
            }

            $underCall = false;
        }

        return $result;
    };
}
