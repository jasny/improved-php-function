<?php

declare(strict_types=1);

namespace Improved;

/**
 * Get the name of a callable.
 *
 * @param callable $callable
 * @return string
 */
function function_get_name(callable $callable): string
{
    $getClassName = static function ($object): string {
        $class = get_class($object);

        if (strpos($class, "\0") !== false) {
            [$name] = explode("\0", $class, 2);
            $class = '{' . $name . '}';
        }

        return $class;
    };

    switch (true) {
        case is_string($callable):
            return $callable;
        case is_array($callable):
            $class = (is_object($callable[0]) ? $getClassName($callable[0]) : $callable[0]);
            return $class . '::' . $callable[1];
        case $callable instanceof \Closure:
            return '{closure}';
        case is_object($callable):
            /** @var object $callable */
            return $getClassName($callable);
        default:
            return '{' . gettype($callable) . '}'; // @codeCoverageIgnore
    }
}
