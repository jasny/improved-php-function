<?php

declare(strict_types=1);

namespace Improved\Tests;

/**
 * Provider different types of callables
 */
trait CallableProviderTrait
{
    static public function toUpper($string)
    {
        return strtoupper($string);
    }

    /**
     * @return callable[]
     */
    public function callableProvider()
    {
        $closure = function($string) {
            return strtoupper($string);
        };

        $object = new class() {
            function toUpper($string) {
                return strtoupper($string);
            }
        };

        $invokable = new class() {
            function __invoke($string) {
                return strtoupper($string);
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
