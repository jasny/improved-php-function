<?php

declare(strict_types=1);

namespace Ipl;

/**
 * Do a function call with named parameters.
 *
 * @param callable $callable
 * @param array    $namedArgs
 * @return mixed
 */
function function_call_named(callable $callable, array $namedArgs)
{
    if (is_string($callable) && strpos($callable, '::') !== false) {
        $source = explode('::', $callable, 2);
    } elseif (is_object($callable) && !$callable instanceof \Closure) {
        $source = [$callable, '__invoke'];
    } else {
        $source = $callable;
    }

    if (is_string($source) || $source instanceof \Closure) {
        $refl = new \ReflectionFunction($source);
    } elseif (is_array($source)) {
        $refl = new \ReflectionMethod($source[0], $source[1]);
    } else {
        throw new \TypeError("Unknown callable type " . gettype($callable)); // @codeCoverageIgnore
    }

    $params = $refl->getParameters();

    $args = [];
    $missing = [];
    $max = 0;

    foreach ($params as $i => $param) {
        $key = $param->name;

        if (array_key_exists($key, $namedArgs)) {
            $args[] = $namedArgs[$key];
            $max = $i + 1;
        } elseif ($param->isOptional()) {
            $args[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
        } else {
            $missing[] = $key;
        }
    }

    if ($missing !== []) {
        $msg = "Too few arguments to function %s(), missing %s";
        throw new \ArgumentCountError(sprintf($msg, function_get_name($callable), join(', ', $missing)));
    }

    return $callable(...array_slice($args, 0, $max));
}
