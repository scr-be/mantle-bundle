<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class HasChildrenOwningSide.
 */
trait HasChildrenOwningSide
{
    use HasChildrenInverseSide;

    /**
     * @param ArrayCollection $children
     *
     * @return $this
     */
    public function setChildren(ArrayCollection $children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @param AbstractEntity $child
     *
     * @return $this
     */
    public function addChild(AbstractEntity $child)
    {
        if (false === $this->hasChild($child)) {
            $this->children->add($child);
        }

        return $this;
    }

    /**
     * @param AbstractEntity $child
     *
     * @return $this
     */
    public function removeChild(AbstractEntity $child)
    {
        if (true === $this->hasChild($child)) {
            $this->children->removeElement($child);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearChildren()
    {
        $this->children = new ArrayCollection();

        return $this;
    }
}

/* EOF */
