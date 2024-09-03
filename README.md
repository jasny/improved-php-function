![improved PHP library](https://user-images.githubusercontent.com/100821/46372249-e5eb7500-c68a-11e8-801a-2ee57da3e5e3.png)

# function handling

![PHP](https://github.com/jasny/improved-php-function/workflows/PHP/badge.svg)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jasny/improved-php-function/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/improved-php-library/function/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/jasny/improved-php-function/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/improved-php-library/function/?branch=master)
[![Packagist Stable Version](https://img.shields.io/packagist/v/improved/function.svg)](https://packagist.org/packages/improved/function)
[![Packagist License](https://img.shields.io/packagist/l/improved/function.svg)](https://packagist.org/packages/improved/function)

Library for function handling and functional programming.

## Installation

    composer require improved/function

## Functions

* [`function_pipe(callable ...$callables)`](#function_pipe)
* [`function_all(callable ...$callables)`](#function_all)
* [`function_trampoline(callable $callable)`](#function_tail_recursion)

### function_pipe

    callable function_pipe(callable ...$functions)

Combine all functions, piping the output from one function to the input of the other.

Each callable should only require one argument, use short closures `fn()` if needed.

```php
use Improved as i;

$slugify = i\function_pipe(
    fn($str) => i\string_case_convert($str, i\STRING_LOWERCASE),
    'Improved/string_remove_accents',
    'trim',
    fn($str) => preg_replace('/\W+/', '-', $str)
);

$slugify("Bonjour du monde / Français "); // "bonjour-du-monde-francais" 
```

### function_all

    callable function_all(callable ...$functions)

Call all functions sequentially. The arguments are passed to each function. The first argument is typically an
accumulator.

Functions are expected to not return anything (void). If anything is returned, it's ignored.

```php
use Improved as i;

$make = i\function_all(
    static function(ArrayObject $acc, array $opts): void {
        if (in_array('skip-prepare', $opts, true)) return;
        $acc[] = 'prepare';
    },
    new Compiler(), // Invokable object
    static function(ArrayObject $acc, array $opts): void {
        $acc[] = 'finish';
    }
);

$acc = new ArrayObject();
$opts = [/* ... */];

$make($acc, $opts);
```

### function_trampoline

    callable function_trampoline(callable $callable)

Return a new function that decorates given function with tail recursion optimization.

In traditional recursion, the typical model is that you perform your recursive calls first, and then you take the return
value of the recursive call and calculate the result. In this manner, you don't get the result of your calculation until
you have returned from every recursive call.

The problem with traditional recursion is that it builds up a call stack, limiting the amount of recusion you should
allow.

> Warning: Uncaught Error: Maximum function nesting level of '256' reached, aborting!

In [tail recursion](https://en.wikipedia.org/wiki/Tail_call), you perform your calculations first, and then you execute
the recursive call, passing the results of your current step to the next recursive step. This results in the last
statement being in the form of `return recursive_function(params, accumulator)`.

The result is calculated via the accumulator, so the return value of any given recursive step is the same as the return
value of the next recursive call.

```php
$sum_of_range = i\function_trampoline(function ($from, $to, $acc = 0) use (&$sum_of_range) {
    if ($from > $to) {
        return $acc;
    }
    
    return $sum_of_range($from + 1, $to, $acc + $from);
});

$sum_of_range(1, 10000); // 50005000;
```

Tail recursion optimization can automatically detect such a pattern and apply this as a consecutive call rather than
nesting. Unfortunately this isn't implemented by PHP, so using a trampoline function is required.

**Use `function_trampoline` in case of deep recursion (10+ levels).**
