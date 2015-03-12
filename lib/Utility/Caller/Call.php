<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Caller;

use Scribe\Exception\InvalidArgumentException;
use Scribe\Utility\StaticClass\StaticClassTrait;
use Scribe\Exception\BadFunctionCallException;

/**
 * Class Call
 * Static function collection to call either global functions or object methods
 * indirectly with checks that the requested function/method exists.
 *
 * @package Scribe\Utility\Call
 */
class Call implements CallInterface
{
    /**
     * disallow instantiation
     */
    use StaticClassTrait;

    /**
     * Call a global function (if exists) with specified arguments
     *
     * @param  string   $function  A global function name
     * @param  ...mixed $arguments Arguments to pass to the global function
     * @return mixed
     */
    static public function func($function, ...$arguments)
    {
        return self::handle($function, null, null, ...$arguments);
    }

    /**
     * Call an object method (if exists) with specified arguments
     *
     * @param  string|object $object    An object instance or a class name
     * @param  string        $method    An accessible object method name
     * @param  ...mixed      $arguments Arguments to pass to the object method
     * @return mixed
     */
    static public function method($object, $method, ...$arguments)
    {
        return self::handle($method, $object, false, ...$arguments);
    }

    /**
     * Call an static object method (if exists) with specified arguments
     *
     * @param  string|object $object    An object instance or a class name
     * @param  string        $method    An accessible object method name
     * @param  ...mixed      $arguments Arguments to pass to the object method
     * @return mixed
     */
    static public function staticMethod($object, $method, ...$arguments)
    {
        return self::handle($method, $object, true, ...$arguments);
    }

    /**
     * Handle calling a function/method
     *
     * @param  string|object|null $object    An object instance or a class name
     * @param  string|null        $method    An available global function or object method name
     * @param  bool|null          $static    Whether this is a static function or not
     * @param  ...mixed           $arguments Arguments to pass to the object method
     * @return mixed
     */
    static public function handle($method = null, $object = null, $static = false, ...$arguments)
    {
        $call = self::validateCall($method, $object, $static);

        return call_user_func_array($call, $arguments);
    }

    /**
     * Performs validations on request prior to calling it
     *
     * @param  string|null        $method An available global function or object method name
     * @param  string|object|null $object An object class name
     * @param  bool|null          $static Whether this is a static call or not
     * @return array|string
     * @throws InvalidArgumentException
     */
    static protected function validateCall($method = null, $object = null, $static = null)
    {
        if (null === $method && null === $object && null === $static) {
            throw new InvalidArgumentException(
                sprintf('Invalid parameters provided for %s::%s.', get_called_class(),  __FUNCTION__)
            );
        }

        if (null !== $method && null === $object && null === $static) {

            return self::validateFunction($method);
        }

        return self::validateMethod($method, self::validateClass($object, $static), $static);
    }

    /**
     * Validates the requested global function name exists
     *
     * @param  string $function
     * @return string
     * @throws BadFunctionCallException
     */
    static protected function validateFunction($function)
    {
        if (false === function_exists($function)) {
            throw new BadFunctionCallException(
                sprintf('The requested function %s does not exist.', (string) $function)
            );
        }

        return (string) $function;
    }

    /**
     * Validate the requested object instance or class name exists.
     *
     * @param  string|object $object The object instance or class name
     * @param  bool          $static Whether this is a static call or not
     * @return string|object
     * @throws BadFunctionCallException
     */
    static protected function validateClass($object, $static)
    {
        $class = (string) (true === is_string($object) ? $object : get_class($object));

        if (false === class_exists($class)) {
            throw new BadFunctionCallException(
                sprintf('The requested class %s cannot be found.', $class)
            );
        }

        return (true === $static ? $class : $object);
    }

    /**
     * Validate the requested object instance or class name exists.
     *
     * @param  string        $method The method name
     * @param  string|object $object The object instance or class name
     * @param  bool          $static Whether this is a static call or not
     * @return string|array
     * @throws BadFunctionCallException
     */
    static protected function validateMethod($method, $object, $static)
    {
        $call = (true === $static ? $object . '::' . $method : [$object, $method]);

        if (false === method_exists($object, $method) || false === is_callable($call)) {
            throw new BadFunctionCallException(
                sprintf(
                    'The requested %s %s does not exist for class %s (or is not callable).',
                    (true === $static ? 'static function' : 'method'),
                    $method,
                    $object
                )
            );
        }

        return $call;
    }
}

/* EOF */