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
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Symfony\Component\Security\Core\Role\RoleInterface as SymfonyRoleInterface;

/**
 * Class RoleInterface.
 */
interface RoleInterface extends SymfonyRoleInterface
{
    public function setDescription($description);
    public function getDescription();
    public function setName($name);
    public function getName();
    public function getParents();
    public function setParents(ArrayCollection $parents);
    public function hasParents();
    public function clearParents();
    public function hasParent(AbstractEntity $parent);
    public function addParent(AbstractEntity $parent);
    public function removeParent(AbstractEntity $parent);
    public function getChildren();
    public function hasChildren();
    public function hasChild(AbstractEntity $child);
    public function getUsers();
    public function hasUsers();
    public function hasUser(UserInterface $user);
    public function getOrgs();
    public function hasOrgs();
    public function hasOrg(OrganizationInterface $org);
}

/* EOF */
