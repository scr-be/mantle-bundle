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

use Scribe\SecurityBundle\Entity\User;

/**
 * Class HasUser.
 */
trait HasUser
{
    /**
     * The entity user property.
     *
     * @var User
     */
    protected $user;

    /**
     * Init user
     */
    public function __initUser()
    {
        $this->user = null;
    }

    /**
     * Setter for user property.
     *
     * @param User|null $user a user entity object instance
     *
     * @return $this
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Getter for user property.
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Checker for user property.
     *
     * @return bool
     */
    public function hasUser()
    {
        return (bool) $this->user instanceof User;
    }

    /**
     * Nullify the user property.
     *
     * @return $this
     */
    public function clearUser()
    {
        $this->user = null;

        return $this;
    }
}

/* EOF */
