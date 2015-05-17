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
 * Class HasUsersOwningSide.
 */
trait HasUsersOwningSide
{
    use HasUsersInverseSide;

    /**
     * Set user collection.
     *
     * @param ArrayCollection $users
     *
     * @return $this
     */
    public function setUsers(ArrayCollection $users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function addUser(UserInterface $user)
    {
        if (false === $this->hasUser($user)) {
            $this->users->add($user);
        }

        return $this;
    }

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function removeUser(UserInterface $user)
    {
        if (true === $this->hasUser($user)) {
            $this->users->removeElement($user);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearUsers()
    {
        $this->users = new ArrayCollection();

        return $this;
    }
}

/* EOF */
