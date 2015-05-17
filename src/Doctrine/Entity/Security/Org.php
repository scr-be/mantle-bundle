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

use Doctrine\Common\Collections\ArrayCollection;
use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasCode;
use Scribe\Doctrine\Base\Model\HasDescription;
use Scribe\Doctrine\Base\Model\HasName;
use Scribe\Doctrine\Behavior\Model\Timestampable\TimestampableBehaviorTrait;
use Scribe\MantleBundle\Component\Security\Core\OrgInterface;
use Scribe\MantleBundle\Component\Security\Core\UserInterface;
use Scribe\MantleBundle\Doctrine\Base\Model\HasRolesOwningSide;
use Scribe\MantleBundle\Doctrine\Base\Model\HasUsersInverseSide;

/**
 * Class Org.
 */
class Org extends AbstractEntity implements OrgInterface
{
    use HasCode,
        HasName,
        HasDescription,
        HasUsersInverseSide,
        HasRolesOwningSide,
        TimestampableBehaviorTrait;

    /**
     * @var ArrayCollection
     */
    protected $managers;

    /**
     * Support for casting from object type to string type.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getName();
    }

    /**
     * Initialize manager as empty ArrayCollection.
     */
    public function initializeManagers()
    {
        $this->managers = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getManagers()
    {
        return $this->managers;
    }

    /**
     * @param ArrayCollection $managers
     *
     * @return $this
     */
    public function setManagers(ArrayCollection $managers)
    {
        $this->managers = $managers;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasManagers()
    {
        return (bool) (!$this->managers->isEmpty());
    }

    /**
     * @return $this
     */
    public function clearManagers()
    {
        $this->managers = new ArrayCollection();

        return $this;
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    public function hasManager(UserInterface $user)
    {
        return (bool) ($this->managers->contains($user));
    }

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function addManager(UserInterface $user)
    {
        if (false === $this->hasManager($user)) {
            $this->managers->add($user);
        }

        return $this;
    }

    /**
     * @param UserInterface $user
     *
     * @return $this
     */
    public function removeManager(UserInterface $user)
    {
        if (true === $this->hasManager($user)) {
            $this->managers->removeElement($user);
        }

        return $this;
    }
}

/* EOF */
