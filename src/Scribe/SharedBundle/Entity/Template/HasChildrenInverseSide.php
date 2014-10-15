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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HasChildrenInverseSide
 *
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasChildrenInverseSide
{
    /**
     * Children collections
     *
     * @type ArrayCollection
     */
    protected $children;

    /**
     * Getter for children
     *
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Checker for children
     *
     * @return bool
     */
    public function hasChildren()
    {
        return (bool)$this->getChildren()->count() > 0;
    }

    /**
     * Checker for specific child within children
     *
     * @param Entity $child entity object to search of in collection of children
     * @return bool
     */
    public function hasChild(Entity $child)
    {
        return $this
            ->getChildren()
            ->contains($child)
        ;
    }
}
