<?php

declare(strict_types=1);

namespace Improved\Tests;

/**
 * Provider different types of callables
 */
trait CallableProviderTrait
{
    static public function toUpper($str)
    {
        return strtoupper($str);
    }

    /**
     * @return callable[]
     */
    public function callableProvider()
    {
        $closure = function($str) {
            return strtoupper($str);
        };

        $object = new class() {
            function toUpper($str) {
                return strtoupper($str);
            }
        };

        $invokable = new class() {
            function __invoke($str) {
                return strtoupper($str);
            }
        };

        return [
            ['strtoupper', 'strtoupper'],
            [$closure, '{closure}'],
            [[__CLASS__, 'toUpper'], get_called_class() . '::toUpper'],
            [__CLASS__ . '::toUpper', get_called_class() . '::toUpper'],
            [[$object, 'toUpper'], '{class@anonymous}::toUpper'],
            [$invokable, '{class@anonymous}']
        ];
    }
}
