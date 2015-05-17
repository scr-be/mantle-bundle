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
use Scribe\MantleBundle\Component\Security\Core\RoleInterface;

/**
 * Class HasRoleReverseRestrictionsInverseSide.
 */
trait HasRoleReverseRestrictionsInverseSide
{
    /**
     * Role restrictions property.
     *
     * @var ArrayCollection
     */
    protected $roleReverseRestrictions;

    /**
     * Init trait.
     */
    public function initializeRoleReverseRestrictions()
    {
        $this->roleReverseRestrictions = new ArrayCollection();
    }

    /**
     * Get roleReverseRestrictions.
     *
     * @return ArrayCollection
     */
    public function getRoleReverseRestrictions()
    {
        return $this->roleReverseRestrictions;
    }

    /**
     * Checker for roleRestrictions property.
     *
     * @return bool
     */
    public function hasRoleReverseRestrictions()
    {
        return (bool) ($this->roleReverseRestrictions->count() > 0);
    }

    /**
     * Checker for specific role within roleRestrictions property.
     *
     * @param RoleInterface $roleReverseRestriction a Role entity instance to check against the restricted collection of roles
     *
     * @return bool
     */
    public function hasRoleReverseRestriction(RoleInterface $roleReverseRestriction)
    {
        return $this
            ->getRoleReverseRestrictions()
            ->contains($roleReverseRestriction)
        ;
    }
}

/* EOF */
