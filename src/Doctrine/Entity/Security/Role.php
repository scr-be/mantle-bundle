<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Security;

use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasDescription;
use Scribe\Doctrine\Base\Model\HasName;
use Scribe\MantleBundle\Component\Security\Core\RoleInterface;
use Scribe\MantleBundle\Doctrine\Base\Model\HasChildrenInverseSide;
use Scribe\MantleBundle\Doctrine\Base\Model\HasOrgsInverseSide;
use Scribe\MantleBundle\Doctrine\Base\Model\HasParentsOwningSide;
use Scribe\MantleBundle\Doctrine\Base\Model\HasUsersInverseSide;

/**
 * Class Role.
 */
class Role extends AbstractEntity implements RoleInterface
{
    use HasName,
        HasDescription,
        HasParentsOwningSide,
        HasChildrenInverseSide,
        HasUsersInverseSide,
        HasOrgsInverseSide;

    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return (string) $this->__toString();
    }
}

/* EOF */
