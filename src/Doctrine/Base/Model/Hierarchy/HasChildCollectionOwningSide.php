<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Hierarchy;


use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\ORM\Mapping\Entity;

/**
 * Class HasChildCollectionOwningSide.
 */
trait HasChildCollectionOwningSide
{
    /*
     * Import inverse-side trait (read functions)
     */
    use HasChildCollectionInverseSide;

    /**
     * Setter for childCollection property.
     *
     * @param ArrayCollection $childCollection collection of childCollection objects
     *
     * @return $this
     */
    public function setChildCollection(ArrayCollection $childCollection = null)
    {
        $this->childCollection = $childCollection;

        return $this;
    }

    /**
     * Empty childCollection collection.
     *
     * @return $this
     */
    public function clearChildCollection()
    {
        $this
            ->getChildCollection()
            ->clear()
        ;

        return $this;
    }

    /**
     * Element adder for childCollection collection.
     *
     * @param Entity $child  an entity instance to add to the collection
     * @param bool           $unique requires the passed object instance does not already exist within
     *                               the collection
     *
     * @return $this
     */
    public function addChild(Entity $child, $unique = true)
    {
        if ($this->hasChild($child) === false || $unique === false) {
            $this
                ->getChildCollection()
                ->add($child)
            ;
        }
    }

    /**
     * Element remover for childCollection collection.
     *
     * @param Entity $child an entity instance to remove from the collection
     *
     * @return $this
     */
    public function removeChild(Entity $child)
    {
        if ($this->hasChild($child) === true) {
            $this
                ->getChildCollection()
                ->removeElement($child)
            ;
        }

        return $this;
    }
}

/* EOF */
