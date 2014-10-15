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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\SecurityBundle\Entity\Role;

/**
 * Class HasRoleRestrictionsInverseSide
 *
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasRoleRestrictionsInverseSide
{
    /**
     * Role restrictions property
     *
     * @type ArrayCollection
     */
    protected $roleRestrictions;

    /**
     * Getter for roleRestrictions property
     *
     * @return ArrayCollection
     */
    public function getRoleRestrictions()
    {
        return $this->roleRestrictions;
    }

    /**
     * Checker for roleRestrictions property
     *
     * @return bool
     */
    public function hasRoleRestrictions()
    {
        return (bool)$this->roleRestrictions->count() > 0;
    }

    /**
     * Checker for specific role within roleRestrictions property
     *
     * @param Role $roleRestriction a Role entity instance to check against the restricted collection of roles
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
