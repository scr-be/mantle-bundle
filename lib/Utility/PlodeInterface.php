<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility;

use Scribe\Exception\BadFunctionCallException;
use Scribe\Utility\StaticClass\StaticClassTrait;

/**
 * Plode
 * Helper methods for common [ex/im]plode functionality.
 *
 * @package Scribe\Utility
 */
interface PlodeInterface
{
    /**
     * [Ex/Im]plode a [string/array] based on the separator specified in the
     * method name and the value passed as an argument
     *
     * @param  string $methodName Static method name called
     * @param  mixed  $arguments  Static method arguments passed
     * @return string|array
     */
    public static function __callStatic($methodName, $arguments);

    /**
     * Throws an exception on an invalid {@see __callStatic} call
     *
     * @param  string|null $message The message to be provided to the exception
     * @throws BadFunctionCallException
     */
    public static function __callStaticInvalid();

    /**
     * Implode array using default separator ({@see DEFAULT_SEPARATOR})
     *
     * @param  string[]  $toImplode An array to implode into a string
     * @param  string $separator A string used to separate the imploded array values
     *
     * @return string
     */
    static public function im(array $toImplode, $separator = self::SEPARATOR_DEFAULT);

    /**
     * Explode string using default separator ({@see DEFAULT_SEPARATOR})
     *
     * @param  string $toExplode A value to explode into an array
     * @param  string $separator The string used to separate the provided value
     *                           into an array
     *
     * @return array
     */
    static public function ex($toExplode, $separator = self::SEPARATOR_DEFAULT);
}

/* EOF */
