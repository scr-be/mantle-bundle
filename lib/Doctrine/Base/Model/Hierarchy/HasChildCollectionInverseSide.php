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
 * Class HasChildCollectionInverseSide.
 */
trait HasChildCollectionInverseSide
{
    /**
     * ChildCollection collections.
     *
     * @var ArrayCollection
     */
    protected $childCollection;

    /**
     * Init trait.
     */
    public function initializeChildCollection()
    {
        $this->childCollection = new ArrayCollection();
    }

    /**
     * Getter for childCollection.
     *
     * @return ArrayCollection
     */
    public function getChildCollection()
    {
        return $this->childCollection;
    }

    /**
     * Checker for childCollection.
     *
     * @return bool
     */
    public function hasChildCollection()
    {
        return (bool) ($this->getChildCollection()->isEmpty() === false);
    }

    /**
     * Checker for specific child within childCollection.
     *
     * @param AbstractEntity $child entity object to search of in collection of childCollection
     *
     * @return bool
     */
    public function hasChild(AbstractEntity $child)
    {
        return $this
            ->getChildCollection()
            ->contains($child)
        ;
    }
}

/* EOF */
