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

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HasRoleRestrictionsInverseSide.
 */
trait HasReverseRoleRestrictionsOwningSide
{
    use HasReverseRoleRestrictionsInverseSide;

    /**
     * Init trait
     */
    public function __initReverseRoleRestrictions()
    {
        $this->reverseRoleRestrictions = new ArrayCollection;
    }

    /**
     * Set reverseRoleRestrictions.
     *
     * @param ArrayCollection $reverseRoleRestrictions
     *
     * @return $this
     */
    public function setReverseRoleRestrictions(ArrayCollection $reverseRoleRestrictions = null)
    {
        $this->reverseRoleRestrictions = $reverseRoleRestrictions;

        return $this;
    }
}

/* EOF */
