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

/**
 * Class Math
 *
 * @package Scribe\Utility
 */
class Math
{
    /**
     * @param float $integer
     * @param float $base
     * @param float $newBase
     * @param bool $newBaseMax
     * @param int $precision
     * @return float
     */
    public static function convertToBase($integer, $base, $newBase, $newBaseMax = true, $precision = 2)
    {
        if (0 === (int)$base) {
            return $integer;
        }

        $integer = round(($integer * $newBase) / $base, $precision);

        if (true === $newBaseMax && $integer > $newBase) {
            return $newBase;
        }

        return $integer;
    }
}
