<?php

declare(strict_types=1);

namespace Improved;

/**
 * Combine all functions, piping the output from one function to the input of the other.
 *
 * @param callable ...$functions
 * @return callable
 */
function function_pipe(callable ...$functions): callable
{
    return function ($value) use ($functions) {
        foreach ($functions as $function) {
            $value = $function($value);
        }

        return $value;
    };
}
