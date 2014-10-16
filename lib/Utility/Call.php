<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Utility;

use Scribe\Utility\StaticClass\StaticClassTrait;
use Scribe\Exception\BadFunctionCallException;

/**
 * Call
 * Static function collection to call either global functions or object methods
 * indirectly with checks that the requested function/method exists.
 *
 * @package Scribe\Utility
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
     * @param  string    $function  A global function name
     * @param  mixed,... $arguments Arguments to pass to the global function
     *
     * @return mixed
     */
    static public function func($function, ...$arguments)
    {
        if (false === function_exists($function)) {
            self::invalidCall($function);
        }

        return self::handle($function, $arguments);
    }

    /**
     * Call an object method (if exists) with specified arguments
     *
     * @param  \Exception     $object    An object instance or a fully-qualified class name
     * @param  string    $method    An accessable object method name
     * @param  mixed,... $arguments Arguments to pass to the object method
     *
     * @return mixed
     */
    static public function method($object, $method, ...$arguments)
    {
        self::confirmObjectMethodExist($object, $method);

        return self::handle([$object, $method], $arguments);
    }

    /**
     * Call an static object method (if exists) with specified arguments
     *
     * @param  string     $object    An object instance or a class name
     * @param  string    $method    An accessable object method name
     * @param  mixed,... $arguments Arguments to pass to the object method
     *
     * @return mixed
     */
    static public function staticMethod($object, $method, ...$arguments)
    {
        self::confirmObjectMethodExist($object, $method);

        return self::handle($object . '::' . $method, $arguments);
    }

    /**
     * Checks if an object method exists
     *
     * @param  mixed  $object An object class name
     * @param  string $method An accessable object method name
     *
     * @return bool
     */
    static public function confirmObjectMethodExist($object, $method)
    {
        if (false === method_exists($object, $method)) {
            $className = is_object($object) ? get_class($object) : $object;
            self::invalidCall($method . '->' . $className);
        }

        return true;
    }

    /**
     * Handle calling a function/method
     *
     * @param  string|array $function  A function, static method, or class=>method array
     * @param  array        $arguments Arguments to pass to the global function
     *
     * @return mixed
     *
     * @throws Scribe\Exception\BadFunctionCallException
     */
    static public function handle($function, array $arguments = [])
    {
        return call_user_func_array($function, $arguments);
    }

    /**
     * Throws an exception on an invalid {@see __callStatic} call
     *
     * @param string $functionOrMethod
     * @return void
     *
     * @throws Scribe\Exception\BadFunctionCallException
     */
    public static function invalidCall($functionOrMethod)
    {
        throw new BadFunctionCallException(
            sprintf(
                'The requested function/method "%s" does not exist.',
                $functionOrMethod
            )
        );
    }
}
