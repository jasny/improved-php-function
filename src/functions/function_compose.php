<?php

declare(strict_types=1);

namespace Improved;

/**
 * Combine all functions, piping the output from one function to the input of the other.
 * @deprecated
 * @see function_pipe()
 *
 * @param callable ...$functions
 * @return callable
 */
function function_compose(callable ...$functions): callable
{
    return function_pipe(...$functions);
}
