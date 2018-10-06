<?php

declare(strict_types=1);

namespace Ipl;

/**
 * Combine all functions, piping the output from one function to the input of the other.
 *
 * @param callable ...$callables
 * @return callable
 */
function function_compose(callable ...$callables): callable
{
    return function ($value) use ($callables) {
        foreach ($callables as $callable) {
            $value = $callable($value);
        }

        return $value;
    };
}
