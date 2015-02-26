<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Template;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HasChildrenOwningSide
 *
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasChildrenOwningSide
{
    /**
     * Import inverse-side trait (read functions)
     */
    use HasChildrenInverseSide;

    /**
     * Setter for children property
     *
     * @param ArrayCollection $children collection of children objects
     * @return $this
     */
    public function setChildren(ArrayCollection $children = null)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Empty children collection
     *
     * @return $this
     */
    public function emptyChildren()
    {
        $this
            ->getChildren()
            ->clear()
        ;

        return $this;
    }

    /**
     * Element adder for children collection
     *
     * @param Entity $child  an entity instance to add to the collection
     * @param bool   $unique requires the passed object instance does not already exist within
     *                       the collection
     * @return $this
     */
    public function addChild(Entity $child, $unique = true)
    {
        if ($this->hasChild($child) === false || $unique === false) {
            $this
                ->getChildren()
                ->add($child)
            ;
        }
    }

    /**
     * Element remover for children collection
     *
     * @param Entity $child an entity instance to remove from the collection
     * @return $this
     */
    public function removeChild(Entity $child)
    {
        if ($this->hasChild($child) === true) {
            $this
                ->getChildren()
                ->removeElement($child)
            ;
        }

        return $this;
    }
}
