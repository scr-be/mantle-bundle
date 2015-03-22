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

use Scribe\Utility\StaticClass\StaticClassTrait;

/**
 * Class Extension
 *
 * @package Scribe\Utility
 */
class Extension
{
    /**
     * Trait to disallow class instantiation
     */
    use StaticClassTrait;

    /**
     * Check if an extension is loaded or not.
     * @param  string $extension
     * @return bool
     */
    static public function isEnabled($extension)
    {
        return (bool) (true === extension_loaded((string) $extension));
    }

    /**
     * Check if igbinary is enabled
     * @return bool
     */
    static public function hasIgbinary()
    {
        return self::isEnabled('igbinary');
    }

    /**
     * Check if json is enabled
     * @return bool
     */
    static public function hasJson()
    {
        return self::isEnabled('json');
    }
}

/* EOF */
