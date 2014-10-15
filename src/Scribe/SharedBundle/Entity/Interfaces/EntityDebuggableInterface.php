<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Interfaces;

/**
 * Interface EntityDebuggableInterface
 * Provides basic functionality to utalize {@see var_dump()} on an entity that
 * would otherwise recurse into Symfony's DI component and become useless.
 *
 * @package Scribe\SharedBundle\Entity\Interfaces
 */
interface EntityDebuggableInterface
{
    /**
     * Support standardized and extended output when object instance
     * is passed to {@see var_dump()}
     *
     * @return array
     */
    public function __debugInfo();

    /**
     * Call {@see __debugInfo()} and implode into a string prior to output
     *
     * @return string
     */
    public function __debugInfoToString();
}
