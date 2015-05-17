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
 * Class HasParentsOwningSide.
 */
trait HasParentsOwningSide
{
    use HasParentsInverseSide;

    /**
     * @param ArrayCollection $parents
     *
     * @return $this
     */
    public function setParents(ArrayCollection $parents)
    {
        $this->parents = $parents;

        return $this;
    }

    /**
     * @param AbstractEntity $parent
     *
     * @return $this
     */
    public function addParent(AbstractEntity $parent)
    {
        if (false === $this->hasParent($parent)) {
            $this->parents->add($parent);
        }

        return $this;
    }

    /**
     * @param AbstractEntity $parent
     *
     * @return $this
     */
    public function removeParent(AbstractEntity $parent)
    {
        if (true === $this->hasParent($parent)) {
            $this->parents->removeElement($parent);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearParents()
    {
        $this->parents = new ArrayCollection();

        return $this;
    }
}

/* EOF */
