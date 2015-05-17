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

use Scribe\MantleBundle\Component\Security\Core\UserInterface;

/**
 * Class HasUser.
 */
trait HasUser
{
    /**
     * The entity user property.
     *
     * @var UserInterface
     */
    protected $user;

    /**
     * Init user.
     */
    public function initializeUser()
    {
        $this->user = null;
    }

    /**
     * Setter for user property.
     *
     * @param UserInterface|null $user a user entity object instance
     *
     * @return $this
     */
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Getter for user property.
     *
     * @return UserInterface|null
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
        return (bool) ($this->user instanceof UserInterface);
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
