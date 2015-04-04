<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HasRoleRestrictionsInverseSide.
 */
trait HasRoleReverseRestrictionsOwningSide
{
    use HasRoleReverseRestrictionsInverseSide;

    /**
     * Init trait.
     */
    public function initializeRoleReverseRestrictions()
    {
        $this->roleReverseRestrictions = new ArrayCollection();
    }

    /**
     * Set roleReverseRestrictions.
     *
     * @param ArrayCollection $roleReverseRestrictions
     *
     * @return $this
     */
    public function setRoleReverseRestrictions(ArrayCollection $roleReverseRestrictions = null)
    {
        $this->roleReverseRestrictions = $roleReverseRestrictions;

        return $this;
    }
}

/* EOF */
