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
use Scribe\MantleBundle\Component\Security\Core\UserInterface;

/**
 * Class HasUsersInverseSide.
 */
trait HasUsersInverseSide
{
    /**
     * User collection property.
     *
     * @var ArrayCollection
     */
    protected $users;

    /**
     * Initialize users as {@see ArrayCollection}.
     */
    public function initializeUsers()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * Get user collection.
     *
     * @return ArrayCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Check for users.
     *
     * @return bool
     */
    public function hasUsers()
    {
        return (bool) ($this->users->count() > 0 ?: false);
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function hasUser(UserInterface $user)
    {
        return (true === $this->users->contains($user) ?: false);
    }
}

/* EOF */
