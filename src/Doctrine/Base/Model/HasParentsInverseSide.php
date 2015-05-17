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
 * Class HasParentsInverseSide.
 */
trait HasParentsInverseSide
{
    /**
     * @var ArrayCollection
     */
    protected $parents;

    /**
     * Initialize as empty {@see ArrayCollection}.
     */
    public function initializeParents()
    {
        $this->parents = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getParents()
    {
        return $this->parents;
    }

    /**
     * @return bool
     */
    public function hasParents()
    {
        return (bool) ($this->parents->count() > 0 ?: false);
    }

    /**
     * @return $this
     */
    public function hasParent(AbstractEntity $entity)
    {
        return (bool) ($this->parents->contains($entity) === true ?: false);
    }
}

/* EOF */
