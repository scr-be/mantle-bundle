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

/**
 * Class Core
 *
 * @package Scribe\Utility
 */
class Core
{
    /**
     * @param mixed $value
     * @param string $function
     * @return mixed
     * @throws \BadFunctionCallException
     */
    public static function callFunctionOnValue($value, $function)
    {
        if (false === function_exists($function)) {
            throw new BadFunctionCallException('Cannot call function '.$function.' on value '.$value);
        }

        return $function($value);
    }
}
