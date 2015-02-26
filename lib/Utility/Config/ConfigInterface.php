<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Config;

/**
 * Class ConfigInterface
 *
 * @package Scribe\Utility\Config
 */
interface ConfigInterface
{
    /**
     * Getter for config value
     *
     * @param  string $key   config key
     * @throws mixed
     */
    public function get($key);

    /**
     * Setter for config value
     *
     * @param  string $key   config key
     * @param  mixed  $value config value
     * @return bool
     */
    public function set($key, $value);
}
