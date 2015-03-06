<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity\Template;

/**
 * Class HasParentInverseSide
 *
 * @package Scribe\MantleBundle\Entity\Template
 */
trait HasParentOwningSide
{
    /**
     * Import inverse-side trait (read functions)
     */
    use HasParentInverseSide;

    /**
     * Setter for parent
     *
     * @param Entity|null $parent a parent entity instance
     * @return $this
     */
    public function setParent(Entity $parent = null)
    {
        return $this->parent = $parent;

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
