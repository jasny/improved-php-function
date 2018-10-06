<?php

declare(strict_types=1);

namespace Ipl;

/**
 * Call a function, method, closure or any other callable.
 *
 * @param callable $callable
 * @param mixed ...$args
 * @return mixed
 */
function function_call(callable $callable, ...$args)
{
    return $callable(...$args);
}
