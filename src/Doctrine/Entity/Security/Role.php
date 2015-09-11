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
use Scribe\Doctrine\Base\Model\Description\HasDescription;
use Scribe\Doctrine\Base\Model\Name\HasName;
use Scribe\Doctrine\Base\Model\HasChildrenInverseSide;
use Scribe\MantleBundle\Component\Security\Core\RoleInterface;
use Scribe\MantleBundle\Doctrine\Base\Model\HasParentsOwningSide;
use Scribe\MantleBundle\Doctrine\Base\Model\HasOrgsInverseSide;
use Scribe\MantleBundle\Doctrine\Base\Model\HasUsersInverseSide;

/**
 * Class Role.
 */
class Role extends AbstractEntity implements RoleInterface
{
    use HasName;
    use HasDescription;
    use HasParentsOwningSide;
    use HasChildrenInverseSide;
    use HasUsersInverseSide;
    use HasOrgsInverseSide;

    /**
     * @return string
     */
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

    /**
     * @return string
     */
    public function getNameHuman()
    {
        return (string) str_replace('ROLE_', '', $this->getRole());
    }
}

/* EOF */
