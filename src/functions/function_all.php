<?php

declare(strict_types=1);

namespace Improved;

/**
 * Call all functions sequentially. The arguments are passed to each function.
 * Functions are expected to not return anything (void). If anything is returned, it's ignored.
 *
 * @param callable ...$functions
 * @return callable
 */
function function_all(callable ...$functions): callable
{
    return function (...$args) use ($functions): void {
        foreach ($functions as $function) {
            $function(...$args);
        }
    };
}
