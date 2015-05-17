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
 * Class HasChildrenInverseSide.
 */
trait HasChildrenInverseSide
{
    /**
     * @var ArrayCollection
     */
    protected $children;

    /**
     * Initialize as empty {@see ArrayCollection}.
     */
    public function initializeChildren()
    {
        $this->children = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return bool
     */
    public function hasChildren()
    {
        return (bool) ($this->children->count() > 0 ?: false);
    }

    /**
     * @return $this
     */
    public function hasChild(AbstractEntity $entity)
    {
        return (bool) ($this->children->contains($entity) === true ?: false);
    }
}

/* EOF */
