<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class HasChildrenInverseSide.
 */
trait HasChildrenInverseSide
{
    /**
     * Children collections.
     *
     * @var ArrayCollection
     */
    protected $children;

    /**
     * Init trait.
     */
    public function initializeChildren()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * Getter for children.
     *
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Checker for children.
     *
     * @return bool
     */
    public function hasChildren()
    {
        return (bool) ($this->getChildren()->isEmpty() === false);
    }

    /**
     * Checker for specific child within children.
     *
     * @param AbstractEntity $child entity object to search of in collection of children
     *
     * @return bool
     */
    public function hasChild(AbstractEntity $child)
    {
        return $this
            ->getChildren()
            ->contains($child)
        ;
    }
}

/* EOF */
