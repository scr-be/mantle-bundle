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

use Scribe\SecurityBundle\Entity\User;

/**
 * Class HasUser
 * @package Scribe\SharedBundle\Entity\Template
 */
trait HasUser
{
    /**
     * The entity user property
     * @type User
     */
    protected $user;

    /**
     * Setter for user property
     * @param User|null $user a user entity object instance
     * @return $this
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Getter for user property
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Checker for user property
     * @return bool
     */
    public function hasUser()
    {
        return (bool)$this->user instanceof User;
    }

    /**
     * Nullify the user property
     * @return $this
     */
    public function clearUser()
    {
        $this->user = null;

        return $this;
    }
}
