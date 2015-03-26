<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Entity;

/**
 * Interface EntityInterface.
 */
interface EntityInterface
{
    /**
     * Should have a constructor to setup entity properties.
     */
    public function __construct();

    /**
     * Call all initializer methods
     */
    public function __callInitMethods();

    /**
     * Get entity id.
     *
     * @return int|null
     */
    public function getId();
}

/* EOF */
