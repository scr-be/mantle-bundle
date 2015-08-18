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
 * Class HasParentCollectionOwningSide.
 */
trait HasParentCollectionOwningSide
{
    /*
     * Import inverse-side trait (read functions)
     */
    use HasParentCollectionInverseSide;

    /**
     * Setter for parentCollection property.
     *
     * @param ArrayCollection $parentCollection collection of parentCollection objects
     *
     * @return $this
     */
    public function setParentCollection(ArrayCollection $parentCollection = null)
    {
        $this->parentCollection = $parentCollection;

        return $this;
    }

    /**
     * Empty parentCollection collection.
     *
     * @return $this
     */
    public function clearParentCollection()
    {
        $this
            ->getParentCollection()
            ->clear()
        ;

        return $this;
    }

    /**
     * Element adder for parentCollection collection.
     *
     * @param AbstractEntity $parent an entity instance to add to the collection
     * @param bool           $unique requires the passed object instance does not already exist within
     *                               the collection
     *
     * @return $this
     */
    public function addParent(AbstractEntity $parent, $unique = true)
    {
        if ($this->hasParent($parent) === false || $unique === false) {
            $this
                ->getParentCollection()
                ->add($parent)
            ;
        }
    }

    /**
     * Element remover for parentCollection collection.
     *
     * @param AbstractEntity $parent an entity instance to remove from the collection
     *
     * @return $this
     */
    public function removeParent(AbstractEntity $parent)
    {
        if ($this->hasParent($parent) === true) {
            $this
                ->getParentCollection()
                ->removeElement($parent)
            ;
        }

        return $this;
    }
}

/* EOF */
