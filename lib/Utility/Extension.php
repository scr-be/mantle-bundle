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
 * Class Extension.
 */
class Extension
{
    /*
     * Trait to disallow class instantiation
     */
    use StaticClassTrait;

    /**
     * Check if an extension is loaded or not.
     *
     * @param string $extension
     *
     * @return bool
     */
    public static function isEnabled($extension)
    {
        if (empty((string) $extension)) {
            throw new RuntimeException(
                sprintf('Cannot check extension availability against empty string in %s.', __CLASS__)
            );
        }

        return (bool) (true === extension_loaded((string) $extension));
    }

    /**
     * Check if igbinary is enabled.
     *
     * @return bool
     */
    public static function hasIgbinary()
    {
        return self::isEnabled('igbinary');
    }

    /**
     * Check if json is enabled.
     *
     * @return bool
     */
    public static function hasJson()
    {
        return self::isEnabled('json');
    }
}

/* EOF */
