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

/**
 * Class HasRoleRestrictionsAsArrayInverseSide.
 */
trait HasRoleRestrictionsAsArrayInverseSide
{
    /**
     * Role restrictions property.
     *
     * @var string[]
     */
    protected $roleRestrictions;

    /**
     * Getter for roleRestrictions property.
     *
     * @return string[]
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
        return (bool) (null !== $this->roleRestrictions && (count($this->roleRestrictions) > 0));
    }

    /**
     * Checker for specific role within roleRestrictions property.
     *
     * @param string $role
     *
     * @return bool
     */
    public function hasRoleRestriction($role)
    {
        return (bool) (false === array_search($role, $this->roleRestrictions) ? false : true);
    }
}

/* EOF */
