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
     * @param  string $methodName Static method name called
     * @param  mixed  $arguments  Static method arguments passed
     *
     * @return string|array
     */
    public static function __callStatic($methodName, $arguments);

    /**
     * @return void
     *
     * @throws Scribe\Exception\BadFunctionCallException
     */
    public static function __invalidCallStatic();

    /**
     * @param  array  $toImplode An array to implode into a string
     * @param  string $separator A string used to separate the imploded array values
     *
     * @return string
     */
    static public function im(array $toImplode, $separator = self::SEPARATOR_DEFAULT);

    /**
     * @param  mixed  $toExplode A value to explode into an array (will be cast to string prior explosion)
     * @param  string $separator The string used to separate the provided value into an array
     *
     * @return array
     */
    static public function ex($toExplode, $separator = self::SEPARATOR_DEFAULT);
}
