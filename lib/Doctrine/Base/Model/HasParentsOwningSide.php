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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class HasParentsInverseSide.
 */
trait HasParentsOwningSide
{
    /*
     * Import inverse-side trait (read functions)
     */
    use HasParentsInverseSide;

    /**
     * Setter for parents.
     *
     * @param ArrayCollection $parents a parents entity instance
     *
     * @return $this
     */
    public function setParents(ArrayCollection $parents)
    {
        $this->parents = $parents;

        return $this;
    }

    /**
     * Nullify parents property.
     *
     * @return $this
     */
    public function clearParents()
    {
        $this->setParents(null);

        return $this;
    }
}

/* EOF */
