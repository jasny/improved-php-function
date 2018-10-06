<?php

declare(strict_types=1);

namespace Ipl;

/**
 * Get the name of a callable.
 *
 * @param callable $callable
 * @return string
 */
function function_get_name(callable $callable): string
{
    switch (true) {
        case is_string($callable):
            return $callable;
        case is_array($callable):
            $class = (is_object($callable[0]) ? _function_get_class_name($callable[0]) : $callable[0]);
            return $class . '::' . $callable[1];

        case $callable instanceof \Closure:
            return '{closure}';
        case is_object($callable):
            return _function_get_class_name($callable);

        default:
            return '{' . gettype($callable) . '}'; // @codeCoverageIgnore
    }
}

/**
 * Get class name of an object
 * @internal
 *
 * @param object $object
 * @return string
 */
function _function_get_class_name($object): string
{
    $class = get_class($object);

    if (strpos($class, "\0") !== false) {
        [$name] = explode("\0", $class, 2);
        $class = '{' . $name . '}';
    }

    return $class;
}
