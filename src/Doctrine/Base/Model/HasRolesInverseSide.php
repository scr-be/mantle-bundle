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
 * Class HasRolesInverseSide.
 */
trait HasRolesInverseSide
{
    /**
     * Role collection property.
     *
     * @var ArrayCollection
     */
    protected $roles;

    /**
     * Initialize roles as {@see ArrayCollection}.
     */
    public function initializeRoles()
    {
        $this->roles = new ArrayCollection();
    }

    /**
     * Get role collection.
     *
     * @return array
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * Check for roles.
     *
     * @return bool
     */
    public function hasRoles()
    {
        return (bool) ($this->roles->count() > 0 ?: false);
    }

    /**
     * @param RoleInterface $role
     *
     * @return bool
     */
    public function hasRole(RoleInterface $role)
    {
        return (true === $this->roles->contains($role) ?: false);
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
}

/* EOF */
