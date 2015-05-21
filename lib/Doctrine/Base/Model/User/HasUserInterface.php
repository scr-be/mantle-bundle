<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\User;

use Scribe\MantleBundle\Component\Security\Core\UserInterface;

/**
 * Class HasUser.
 */
interface HasUserInterface
{
    /**
     * @param UserInterface|null $user a user entity object instance
     *
     * @return $this
     */
    public function setUser(UserInterface $user = null);

    /**
     * @return UserInterface|null
     */
    public function getUser();

    /**
     * @return bool
     */
    public function hasUser();

    /**
     * @return $this
     */
    public function clearUser();
}

/* EOF */
