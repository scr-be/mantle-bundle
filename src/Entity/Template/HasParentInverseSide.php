<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity\Template;

/**
 * Class HasParentInverseSide
 *
 * @package Scribe\MantleBundle\Entity\Template
 */
trait HasParentInverseSide
{
    /**
     * Children collections
     *
     * @type Entity
     */
    protected $parent;

    /**
     * Getter for parent
     *
     * @return Entity
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Checker for children
     *
     * @return bool
     */
    public function hasParent()
    {
        return (bool) ($this->getParent() !== null);
    }
}

/* EOF */
