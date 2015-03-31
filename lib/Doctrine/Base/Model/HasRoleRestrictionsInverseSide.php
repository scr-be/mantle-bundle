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
use Scribe\SecurityBundle\Entity\Role;

/**
 * Class HasRoleRestrictionsInverseSide.
 */
trait HasRoleRestrictionsInverseSide
{
    /**
     * Role restrictions property.
     *
     * @var ArrayCollection
     */
    protected $roleRestrictions;

    /**
     * Getter for roleRestrictions property.
     *
     * @return ArrayCollection
     */
    public function getRoleRestrictions()
    {
        return $this->roleRestrictions;
    }

    /**
     * Checker for roleRestrictions property.
     *
     * @return bool
     */
    public function hasRoleRestrictions()
    {
        return (bool) $this->roleRestrictions->count() > 0;
    }

    /**
     * Checker for specific role within roleRestrictions property.
     *
     * @param Role $roleRestriction a Role entity instance to check against the restricted collection of roles
     *
     * @return bool
     */
    public function hasRoleRestriction(Role $roleRestriction)
    {
        return $this
            ->getRoleRestrictions()
            ->contains($roleRestriction)
        ;
    }
}

/* EOF */
