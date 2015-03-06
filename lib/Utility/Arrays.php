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
 * Class Arrays
 *
 * @package Scribe\Utility
 */
class Arrays
{
    /**
     * Trait to disallow class instantiation
     */
    use StaticClassTrait;

    /**
     * Determines if the given array is a "hash" (associative) array or indexed
     * by integer array. This only works if the indexed array consists of
     * consecutive integers, otherwise it will mis-represent such an array as hash.
     *
     * @param  array $array An array to check against
     * @param  bool  $throw Should an exception be thrown or the inconsistency
     *                      ignored?
     * @return bool
     * @throws RuntimeException
     */
    static public function isHash(array $array, $throw = true)
    {
        if (true === (count($array) === 0) && true === $throw) {
            throw new RuntimeException(
                'There is no way to determine if en empty array is a hash or not.'
            );
        }

        $keys = array_keys($array);

        return (bool) (array_keys($keys) !== $keys);
    }
}

/* EOF */
