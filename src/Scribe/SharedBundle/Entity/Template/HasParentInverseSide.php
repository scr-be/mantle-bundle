<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Template;

/**
 * Class HasParentInverseSide
 *
 * @package Scribe\SharedBundle\Entity\Template
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
