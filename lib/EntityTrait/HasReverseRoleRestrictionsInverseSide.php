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
use Scribe\SecurityBundle\Entity\Role;

/**
 * Class HasRoleRestrictionsInverseSide
 *
 * @package Scribe\EntityTrait
 */
trait HasReverseRoleRestrictionsInverseSide
{
    /**
     * Role restrictions property
     *
     * @type ArrayCollection
     */
    protected $reverseRoleRestrictions;

    /**
     * Set reverseRoleRestrictions
     *
     * @param array $reverseRoleRestrictions
     * @return $this
     */
    public function setReverseRoleRestrictions(array $reverseRoleRestrictions = array())
    {
        $this->reverseRoleRestrictions = $reverseRoleRestrictions;

        return $this;
    }

    /**
     * Get reverseRoleRestrictions
     *
     * @return ArrayCollection
     */
    public function getReverseRoleRestrictions()
    {
        return $this->reverseRoleRestrictions;
    }

    /**
     * Checker for roleRestrictions property
     *
     * @return bool
     */
    public function hasReverseRoleRestrictions()
    {
        return (bool) ($this->reverseRoleRestrictions->count() > 0);
    }

    /**
     * Checker for specific role within roleRestrictions property
     *
     * @param Role $reverseRoleRestriction a Role entity instance to check against the restricted collection of roles
     * @return bool
     */
    public function hasReverseRoleRestriction(Role $reverseRoleRestriction)
    {
        return $this
            ->getReverseRoleRestrictions()
            ->contains($reverseRoleRestriction)
            ;
    }
}

/* EOF */
