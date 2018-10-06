![improved PHP library](https://user-images.githubusercontent.com/100821/46372249-e5eb7500-c68a-11e8-801a-2ee57da3e5e3.png)

# Improved Function Handling

[![Build Status](https://travis-ci.org/improved-php-library/function.svg?branch=master)](https://travis-ci.org/improved-php-library/function)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/improved-php-library/function/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/improved-php-library/function/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/improved-php-library/function/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/improved-php-library/function/?branch=master)
[![Packagist Stable Version](https://img.shields.io/packagist/v/improved/function.svg)](https://packagist.org/packages/improved/function)
[![Packagist License](https://img.shields.io/packagist/l/improved/function.svg)](https://packagist.org/packages/improved/function)

Library for function handling and functional programming.

This library provides a set of consistent functions for PHP. You should always use these functions rather than the ones
provided by PHP natively.

## Installation

    composer require improved/function

## Functions

* [`function_call(callable $callable, mixed ...$args)`](#function_call)
* [`function_call_named(callable $callable, array $args)`](#function_call_named)
* [`function_operator(string $operator)`](#function_operator)
* [`function_partial(callable|string $callable, mixed ...$args)`](#function_partial)
* [`function_compose(callable ...$callables)`](#function_compose)
* [`function_tail_recursion(callable $callable)`](#function_tail_recursion)

## Constants

* `FUNCTION_ARGUMENT_PLACEHOLDER` - Resource that represents a placeholder for a partial function

## Reference

### function_call

    mixed function_call(callable $callable, mixed ...$args)
    
Call a function, method, closure or any other callable.

If the callable is a variable you can typically call it directly and don't need to use this function. This method is
useful when the callable is a property.

```php
use Improved as i;

class Foo
{
    public $fn = i\string_length;
    
    public function wrong($val)
    {
        return $this->fn($val); 
    }
    
    public function right($val)
    {
        return i\function_call($this->fn, $val); 
    }
}

$foo = new Foo();
$foo->wrong("hello"); // Error: Call to undefined method Foo::fn()
$foo->right("hello"); // 5
```

### function_call_named

    mixed function_call_named(callable $callable, array $namedArgs)
    
Do a function call with named parameters.

```php
function greet(string $greeting, string $planet, string $exclation = '') {
    return $greeting . ' ' . $planet . $exlamation;
};

function_call_named('greet', ['planet' => 'world', 'exclamation' => '!', 'greeting' => 'hello']);
```

If one or more required arguments aren't supplied, an `ArgumentCountError` is thrown.

```php
function_call_named('greet', ['planet' => 'world']);
// ArgumentCountError: To few arguments to function {closure}(): missing greeting
```


### function_operator

    callable function_operator(string $operator)

Get a function for an operator.

This is a short and more readable way to create simple callbacks for operators.

The following operators are supported:

| Operator types                                               |                                                |
| ------------------------------------------------------------ | ---------------------------------------------- |
| [Arithmetic Operators](https://php.net/operators.arithmetic) | `+`, `-`, `*`, `/`, `%`, `**`                  |
| [Bitwise Operators](https://php.net/operators.bitwise)       | `&`, `∣`, `^`, `~`, `<<`, `>>`                 |
| [Comparison Operators](https://php.net/operators.comparison) | `==`, `===`, `!=`, `!==`, `<`, `>`, `<=`, `>=` |
| [Conditional Operators][1]                                   | `?:`, `??`                                |
| [Logical Operators](https://php.net/operators.logical)       | `and`/`&&`, `or`/`∣∣`, `xor`, `!`/`not`        |
| [String Operator](https://php.net/operators.string)          | `.`                                            |

The function for following operators take one argument: `~`, `!`/`not`. The others take two arguments. 

```php
$product = i\iterable_reduce($list, function($a, $b) {
    return $a * $b;
}, 1);
```

Can be rewritten as 

```php
$product = i\iterable_reduce($list, i\function_operator('*'), 1);
``` 

[1]: http://php.net/manual/en/language.operators.comparison.php#language.operators.comparison.ternary

### function_partial

    callable function_partial(callable|string $callable, mixed ...$args)

Create a partial function, where some the arguments have been specified.

The returned closure requires an argument for each placeholder, which is defined as constant
`Improved\FUNCTION_ARGUMENT_PLACEHOLDER`. Typically create an alias `___` for it with the `use const` syntax.

```php
use Improved as i;

$fn = function($word) {
    return i\string_ends_with($word, 'th');
};
```

Can be rewritten as

```php
use Improved as i;
use const Improved\FUNCTION_ARGUMENT_PLACEHOLDER as ___;

$fn = i\function_partial(i\string_ends_with, ___, 'th');
``` 

The callable may also be an operator. The following are equivalent:

```php
use Improved as i;
use const Improved\FUNCTION_ARGUMENT_PLACEHOLDER as ___;

$tenthOf = function_partial(function_operator('/'), ___, 10));
$tenthOf = function_partial('/', ___, 10);
```

No reflection is performed on the callable. Only the placeholders will be present as arguments. Additional arguments are
not passed. If no placeholders are passed the result will just be a closure of the callable.

_It's not possible to create a closure with optional arguments or to change the argument order. If your callback
doesn't adhere to these conditions, create a closure via `function() { }` instead._

### function_compose

    callable function_compose(callable ...$callables)

Combine all functions, piping the output from one function to the input of the other.

Each callable should only require one argument, use `function_partial()` if needed.

```php
$slugify = i\function_compose(
    i\function_partial(i\string_case_convert, ___, i\STRING_LOWERCASE),
    i\string_remove_accents,
    i\string_trim,
    i\function_partial('preg_replace', '\W+', '-', ___)
);

$slugify("Bonjour du monde / Français "); // "bonjour-du-mondo-francais" 
```

### function_tail_recursion

    callable function_tail_recursion(callable $callable)

Return an new function that decorates given function with tail recursion optimization.

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
$sum_of_range = i\function_tail_recursion(function ($from, $to, $acc = 0) use (&$sum_of_range) {
    if ($from > $to) {
        return $acc;
    }
    
    return $sum_of_range($from + 1, $to, $acc + $from);
});

$sum_of_range(1, 10000); // 50005000;
```

Tail recursion optimization can automatically detect such a pattern and apply this as a consecutive call rather than
nesting. Unfortunately this isn't implemented by PHP, so wrapping it in `function_tail_recursion()` is required.

**Use `function_tail_recursion` in case of deep recursion (10+ levels).**

## Notes to reader

Instead of `function_exists` use `is_callable()`.

The functions to get arguments (`func_get_args`, etc) or to pass args as array are not included. The `...$args` syntax
is preferred.

```php
// Don't do this
function ($bar) {
    $rest = array_slice(func_get_args(), 1);
    // ...
}

// Do this instead
function ($bar, ...$rest) {
    // ...
}
```

```php
// Don't do this
call_user_func_array('some_function', $myArgs);

// Do this instead
some_function(...$myArgs);
```
