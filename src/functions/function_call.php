<?php

declare(strict_types=1);

namespace Improved;

/**
 * Call a function, method, closure or any other callable.
 * @deprecated
 *
 * @param callable $callable
 * @param mixed ...$args
 * @return mixed
 */
function function_call(callable $callable, ...$args)
{
    return $callable(...$args);
}
