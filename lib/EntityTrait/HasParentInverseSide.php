<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\EntityTrait;

use Scribe\Entity\AbstractEntity;

/**
 * Class HasParentInverseSide
 *
 * @package Scribe\EntityTrait
 */
trait HasParentInverseSide
{
    /**
     * Parent entity
     *
     * @type AbstractEntity
     */
    protected $parent;

    /**
     * Getter for parent
     *
     * @return AbstractEntity
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Checker for parent
     *
     * @return bool
     */
    public function hasParent()
    {
        return (bool) ($this->getParent() !== null);
    }
}

/* EOF */
