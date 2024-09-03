<?php

declare(strict_types=1);

namespace Improved;

/**
 * Decorates given function with tail recursion optimization.
 *
 * @deprecated Use Improved\function_trampoline() instead
 * @codeCoverageIgnore
 */
function function_tail_recursion(callable $callable): callable
{
    return function_trampoline($callable);
}
