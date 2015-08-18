<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\Hierarchy;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class HasParentCollectionInverseSide.
 */
trait HasParentCollectionInverseSide
{
    /**
     * ParentCollection collections.
     *
     * @var ArrayCollection
     */
    protected $parentCollection;

    /**
     * Init trait.
     */
    public function initializeParentCollection()
    {
        $this->parentCollection = new ArrayCollection();
    }

    /**
     * Getter for parentCollection.
     *
     * @return ArrayCollection
     */
    public function getParentCollection()
    {
        return $this->parentCollection;
    }

    /**
     * Checker for parentCollection.
     *
     * @return bool
     */
    public function hasParentCollection()
    {
        return (bool) $this->getParentCollection()->count() > 0;
    }

    /**
     * Checker for specific child within parentCollection.
     *
     * @param AbstractEntity $child entity object to search of in collection of parentCollection
     *
     * @return bool
     */
    public function hasparent(AbstractEntity $child)
    {
        return $this
            ->getParentCollection()
            ->contains($child)
            ;
    }
}

/* EOF */
