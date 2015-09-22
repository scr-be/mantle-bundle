<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\User;

use Scribe\MantleBundle\Component\Security\Core\UserInterface;

/**
 * Class HasUser.
 */
trait HasUser
{
    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * Init user property.
     */
    public function initializeUser()
    {
        $this->user = null;
    }

    /**
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
     * @return UserInterface|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function hasUser()
    {
        return (bool) ($this->user instanceof UserInterface);
    }

    /**
     * @return $this
     */
    public function clearUser()
    {
        $this->user = null;

        return $this;
    }
}

/* EOF */
