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

/**
 * Class HasReverseReverseRoleRestrictionsAsArrayInverseSide
 *
 * @package Scribe\EntityTrait
 */
trait HasReverseRoleRestrictionsAsArrayInverseSide
{
    /**
     * Role restrictions property
     *
     * @type string[]
     */
    protected $reverseRoleRestrictions;

    /**
     * Getter for reverseRoleRestrictions property
     *
     * @return string[]
     */
    public function getReverseRoleRestrictions()
    {
        return $this->reverseRoleRestrictions;
    }

    /**
     * Checker for reverseRoleRestrictions property
     *
     * @return bool
     */
    public function hasReverseRoleRestrictions()
    {
        return (bool) (null !== $this->reverseRoleRestrictions && (count($this->reverseRoleRestrictions) > 0));
    }

    /**
     * Checker for specific role within reverseRoleRestrictions property
     *
     * @param  string $role
     * @return bool
     */
    public function hasReverseRoleRestriction($role)
    {
        return (bool) (false === array_search($role, $this->reverseRoleRestrictions) ? false : true);
    }
}

/* EOF */
