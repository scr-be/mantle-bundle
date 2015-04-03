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
 * Class HasReverseReverseRoleRestrictionsAsArrayOwningSide.
 */
trait HasReverseRoleRestrictionsAsArrayOwningSide
{
    /*
     * import reading methods for reverseRoleRestrictions property
     */
    use HasReverseRoleRestrictionsAsArrayInverseSide;

    /**
     * Init trait.
     */
    public function initializeReverseRoleRestrictions()
    {
        $this->reverseRoleRestrictions = [];
    }

    /**
     * Setter for revisions property.
     *
     * @param array|null $roles
     *
     * @return $this
     */
    public function setReverseRoleRestrictions(array $roles = [])
    {
        $this->reverseRoleRestrictions = $roles;

        return $this;
    }

    /**
     * Destroyer for reverseRoleRestrictions property.
     *
     * @return $this
     */
    public function clearReverseRoleRestrictions()
    {
        $this->reverseRoleRestrictions = [];

        return $this;
    }

    /**
     * Add role to reverseRoleRestrictions array.
     *
     * @param string $role   a role instance to add to the reverseRoleRestrictions array
     * @param bool   $unique requires the passed role instance not already exist within
     *                       the reverseRoleRestrictions array
     *
     * @return $this
     */
    public function addReverseRoleRestrictions($role, $unique = true)
    {
        if ($this->hasReverseRoleRestriction($role) === false || $unique === false) {
            $this->setReverseRoleRestrictions(
                array_merge(
                    (array) $this->getReverseRoleRestrictions(),
                    (array) $role
                )
            );
        }

        return $this;
    }

    /**
     * Collections remover for reverseRoleRestrictions property.
     *
     * @param string $role
     *
     * @return $this
     */
    public function removeReverseRoleRestriction($role)
    {
        if (($this->hasReverseRoleRestriction($role) === true) &&
            (false !== ($key = array_search($role, $this->reverseRoleRestrictions)))) {
            unset($this->reverseRoleRestrictions[$key]);

            $this->setReverseRoleRestrictions(
                array_values($this->reverseRoleRestrictions)
            );
        }

        return $this;
    }
}

/* EOF */
