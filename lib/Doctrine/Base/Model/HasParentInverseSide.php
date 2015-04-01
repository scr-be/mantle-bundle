<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model;

use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class HasParentInverseSide.
 */
trait HasParentInverseSide
{
    /**
     * Parent entity.
     *
     * @var AbstractEntity
     */
    protected $parent;

    /**
     * Getter for parent.
     *
     * @return AbstractEntity
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
