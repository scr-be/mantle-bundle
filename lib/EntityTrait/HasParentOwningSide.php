<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\EntityTrait;

use Scribe\Entity\AbstractEntity;

/**
 * Class HasParentInverseSide
 *
 * @package Scribe\EntityTrait
 */
trait HasParentOwningSide
{
    /**
     * Import inverse-side trait (read functions)
     */
    use HasParentInverseSide;

    /**
     * init trait
     */
    protected function initParent()
    {
        $this->parent = null;
    }

    /**
     * Setter for parent
     *
     * @param AbstractEntity|null $parent a parent entity instance
     * @return $this
     */
    public function setParent(AbstractEntity $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Nullify parent property
     *
     * @return $this
     */
    public function unsetParent()
    {
        $this->setParent(null);

        return $this;
    }
}

/* EOF */
