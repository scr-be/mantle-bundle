<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\Security\Core;

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\Base\Model\Activity\ActivityCollectionInterface;
use Scribe\Doctrine\Base\Model\Address\AddressCollectionInterface;
use Scribe\Doctrine\Base\Model\Description\DescriptionInterface;
use Scribe\Doctrine\Base\Model\Name\NameInterface;
use Scribe\Doctrine\Base\Model\Phone\PhoneCollectionInterface;
use Scribe\Doctrine\Behavior\Model\Timestampable\TimestampableBehaviorInterface;

/**
 * Class OrganizationInterface.
 */
interface OrganizationInterface extends AddressCollectionInterface, PhoneCollectionInterface, DescriptionInterface,
                                        NameInterface, ActivityCollectionInterface, TimestampableBehaviorInterface
{
    /**
     * Setter for code property.
     *
     * @param string|null $code the code string
     *
     * @return $this
     */
    public function setCode($code = null);

    /**
     * Getter for code property.
     *
     * @return string|null
     */
    public function getCode();

    /**
     * Checker for code property.
     *
     * @return bool
     */
    public function hasCode();

    /**
     * Nullify the code property.
     *
     * @return $this
     */
    public function clearCode();

    /**
     * Get role collection.
     *
     * @return array
     */
    public function getRoles();

    /**
     * Check for roles.
     *
     * @return bool
     */
    public function hasRoles();

    /**
     * @param RoleInterface $role
     *
     * @return bool
     */
    public function hasRole(RoleInterface $role);

    /**
     * Set role collection.
     *
     * @param ArrayCollection $roles
     *
     * @return $this
     */
    public function setRoles(ArrayCollection $roles);

    /**
     * @param RoleInterface $role
     *
     * @return $this
     */
    public function addRole(RoleInterface $role);

    /**
     * @param RoleInterface $role
     *
     * @return $this
     */
    public function removeRole(RoleInterface $role);

    /**
     * @return $this
     */
    public function clearRoles();

    /**
     * Get user collection.
     *
     * @return ArrayCollection
     */
    public function getUsers();

    /**
     * Check for users.
     *
     * @return bool
     */
    public function hasUsers();

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function hasUser(UserInterface $user);

    /**
     * @return ArrayCollection
     */
    public function getManagers();

    /**
     * @param ArrayCollection $managers
     *
     * @return $this
     */
    public function setManagers(ArrayCollection $managers);

    /**
     * @return bool
     */
    public function hasManagers();

    /**
     * @return $this
     */
    public function clearManagers();

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function hasManager(UserInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function addManager(UserInterface $user);

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function removeManager(UserInterface $user);
}

/* EOF */
