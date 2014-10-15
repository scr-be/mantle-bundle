<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Template;

/**
 * Class HasParentInverseSide
 *
 * @package Scribe\SharedBundle\Entity\Template
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
