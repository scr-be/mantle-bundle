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

use Scribe\Doctrine\ORM\Mapping\Entity;

/**
 * Class HasParentInverseSide.
 */
trait HasParentInverseSide
{
    /**
     * Parent entity.
     *
     * @var Entity
     */
    protected $parent;

    /**
     * init trait.
     */
    public function initializeParent()
    {
        $this->parent = null;
    }

    /**
     * Getter for parent.
     *
     * @return Entity
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Checker for parent.
     *
     * @return bool
     */
    public function hasParent()
    {
        return (bool) ($this->getParent() !== null);
    }
}

/* EOF */
