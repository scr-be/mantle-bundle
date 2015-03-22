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
 * Class HasRoleRestrictionsAsArrayOwningSide
 *
 * @package Scribe\EntityTrait
 */
trait HasRoleRestrictionsAsArrayOwningSide
{
    /**
     * import reading methods for roleRestrictions property
     */
    use HasRoleRestrictionsAsArrayInverseSide;

    /**
     * Init this trait
     */
    protected function initRoleRestrictionsAsArray()
    {
        $this->roleRestrictions = [];
    }

    /**
     * Setter for revisions property
     *
     * @param array|null $roles
     * @return $this
     */
    public function setRoleRestrictions(array $roles = [])
    {
        $this->roleRestrictions = $roles;

        return $this;
    }

    /**
     * Destroyer for roleRestrictions property
     *
     * @return $this
     */
    public function clearRoleRestrictions()
    {
        $this->roleRestrictions = [];

        return $this;
    }

    /**
     * Add role to roleRestrictions array
     *
     * @param string $role   a role instance to add to the roleRestrictions array
     * @param bool   $unique requires the passed role instance not already exist within
     *                       the roleRestrictions array
     * @return $this
     */
    public function addRoleRestrictions($role, $unique = true)
    {
        if ($this->hasRoleRestriction($role) === false || $unique === false) {
            $this->setRoleRestrictions(
                array_merge(
                    (array)$this->getRoleRestrictions(),
                    (array)$role
                )
            );
        }

        return $this;
    }

    /**
     * Collections remover for roleRestrictions property
     *
     * @param  string $role
     * @return $this
     */
    public function removeRoleRestriction($role)
    {
        if ($this->hasRoleRestriction($role) === true && (false !== ($key = array_search($role, $this->roleRestrictions)))) {
            unset($this->roleRestrictions[$key]);

            $this->setRoleRestrictions(
                array_values($this->roleRestrictions)
            );
        }

        return $this;
    }
}

/* EOF */
