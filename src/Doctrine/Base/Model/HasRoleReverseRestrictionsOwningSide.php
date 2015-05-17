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

use Scribe\MantleBundle\Component\Security\Core\RoleInterface;

/**
 * Class HasRoleReverseRestrictionsOwningSide.
 */
trait HasRoleReverseRestrictionsOwningSide
{
    use HasRoleReverseRestrictionsInverseSide;

    /**
     * Set roleReverseRestrictions.
     *
     * @param array $roleReverseRestrictions
     *
     * @return $this
     */
    public function setRoleReverseRestrictions(array $roleReverseRestrictions = [])
    {
        $this->roleReverseRestrictions = $roleReverseRestrictions;

        return $this;
    }

    /**
     * Destroyer for roleRestrictions property.
     *
     * @return $this
     */
    public function clearRoleReverseRestrictions()
    {
        $this
            ->getRoleReverseRestrictions()
            ->clear()
        ;

        return $this;
    }

    /**
     * Collections adder for roleRestrictions property.
     *
     * @param RoleInterface $roleRestriction a role instance to add to the roleRestrictions collection
     * @param bool          $unique          requires the passed role instance not already exist within
     *                                       the roleRestrictions collection
     *
     * @return $this
     */
    public function addRoleReverseRestrictions(RoleInterface $roleRestriction, $unique = true)
    {
        if ($this->hasRoleReverseRestriction($roleRestriction) === false || $unique === false) {
            $this
                ->getRoleReverseRestrictions()
                ->add($roleRestriction)
            ;
        }

        return $this;
    }

    /**
     * Collections remover for roleRestrictions property.
     *
     * @param RoleInterface $roleRestriction a role instance to remove from collection
     *
     * @return $this
     */
    public function removeRoleReverseRestriction(RoleInterface $roleRestriction)
    {
        if ($this->hasRoleReverseRestriction($roleRestriction) === true) {
            $this
                ->getRoleReverseRestrictions()
                ->removeElement($roleRestriction)
            ;
        }

        return $this;
    }
}

/* EOF */
