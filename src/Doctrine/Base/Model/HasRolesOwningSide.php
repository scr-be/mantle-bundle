<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\MantleBundle\Component\Security\Core\RoleInterface;

/**
 * Class HasRolesOwningSide.
 */
trait HasRolesOwningSide
{
    use HasRolesInverseSide;

    /**
     * Set role collection.
     *
     * @param ArrayCollection $roles
     *
     * @return $this
     */
    public function setRoles(ArrayCollection $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param RoleInterface $role
     *
     * @return $this
     */
    public function addRole(RoleInterface $role)
    {
        if (false === $this->hasRole($role)) {
            $this->roles->add($role);
        }

        return $this;
    }

    /**
     * @param RoleInterface $role
     *
     * @return $this
     */
    public function removeRole(RoleInterface $role)
    {
        if (true === $this->hasRole($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearRoles()
    {
        $this->roles = new ArrayCollection();

        return $this;
    }
}

/* EOF */
