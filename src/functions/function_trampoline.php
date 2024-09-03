<?php

declare(strict_types=1);

namespace Improved;

// Taken from https://github.com/lstrojny/functional-php

/**
 * Decorates given function with tail recursion optimization.
 */
function function_trampoline(callable $callable): callable
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
