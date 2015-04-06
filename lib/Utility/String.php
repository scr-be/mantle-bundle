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

use Scribe\Exception\RuntimeException;
use Scribe\Utility\StaticClass\StaticClassTrait;

/**
 * Class String.
 */
class String extends \Scribe\Filter\String
{
    /*
     * Trait to disallow class instantiation
     */
    use StaticClassTrait;

    /**
     * Determine if string is longer than the requested length.
     *
     * @param string $string The string to check against
     * @param int    $length The minimum length of the string
     * @param bool   $throw  Whether to throw an exception or return a boolean
     *
     * @return bool
     *
     * @throws RuntimeException
     */
    public static function isLongerThan($string, $length, $throw = true)
    {
        if (true === (mb_strlen($string) < $length)) {
            if (true === $throw) {
                throw new RuntimeException(
                    sprintf('The string "%s" must be greater than %n characters.', (string) $string, (int) $length)
                );
            }

            return false;
        }

        return true;
    }
}

/* EOF */
