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

/**
 * Class OrgInterface.
 */
interface OrgInterface
{
    public function setName($name);
    public function getName();
    public function setCode($code);
    public function getCode();
    public function getUsers();
    public function hasUsers();
    public function hasUser(UserInterface $user);
    public function getManagers();
    public function setManagers(ArrayCollection $users);
    public function hasManagers();
    public function clearManagers();
    public function hasManager(UserInterface $user);
    public function addManager(UserInterface $user);
    public function removeManager(UserInterface $user);
}


/* EOF */
