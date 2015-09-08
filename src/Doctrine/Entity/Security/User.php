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
use Scribe\Doctrine\Base\Model\Activity\HasActivityCollection;
use Scribe\Doctrine\Base\Model\Address\HasAddressCollection;
use Scribe\Doctrine\Base\Model\Description\HasDescription;
use Scribe\Doctrine\Base\Model\HasPerson;
use Scribe\Doctrine\Base\Model\HasProperties;
use Scribe\Doctrine\Base\Model\HasTitle;
use Scribe\Doctrine\Base\Model\Organization\HasOrganization;
use Scribe\Doctrine\Base\Model\Phone\HasPhoneCollection;
use Scribe\Doctrine\Behavior\Model\Timestampable\TimestampableBehaviorTrait;
use Scribe\MantleBundle\Component\Security\Core\OrganizationInterface;
use Scribe\MantleBundle\Component\Security\Core\UserInterface;
use Scribe\MantleBundle\Doctrine\Base\Model\HasRolesOwningSide;

/**
 * Class User.
 */
class User extends AbstractEntity implements UserInterface
{
    use HasPerson,
        HasDescription,
        HasOrganization,
        HasTitle,
        HasProperties,
        HasAddressCollection,
        HasPhoneCollection,
        HasActivityCollection,
        HasRolesOwningSide,
        TimestampableBehaviorTrait;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var null|string
     */
    protected $salt;

    /**
     * @var \Datetime|null
     */
    protected $accountInitialized;

    /**
     * @var \Datetime|null
     */
    protected $accountExpiration;

    /**
     * @var ArrayCollection
     */
    protected $accountActivity;

    /**
     * @var bool
     */
    protected $accountLocked;

    /**
     * @var \Datetime|null
     */
    protected $passwordExpiration;

    /**
     * @var ArrayCollection
     */
    protected $managerOf;

    /**
     * Support for casting from object type to string type.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getFullName();
    }

    public function initializeSerializable()
    {
        $this->setSerializablePropertyCollection(
            'id', 'username', 'email', 'password', 'accountLocked', 'accountExpiration', 'passwordExpiration'
        );
    }

    public function initializeUsername()
    {
        $this->username = null;
    }

    public function initializeEmail()
    {
        $this->email = null;
    }

    public function initializePassword()
    {
        $this->password = null;
    }

    public function initializeSalt()
    {
        $this->salt = null;
    }

    public function initializeAccountInitialized()
    {
        $this->accountInitialized = null;
    }

    public function initializeAccountExpiration()
    {
        $this->accountExpiration = null;
    }

    public function initializeAccountLocked()
    {
        $this->accountLocked = false;
    }

    public function initializePasswordExpiration()
    {
        $this->passwordExpiration = null;
    }

    /**
     * @return $this
     */
    public function initializeManagerOfCollection()
    {
        $this->managerOf = new ArrayCollection();

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param null|string $salt
     *
     * @return $this
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAccountExpired()
    {
        return (bool) ($this->accountExpiration instanceof \Datetime && (new \Datetime())->format('u') - $this->accountExpiration->format('u') > 0);
    }

    /**
     * @return bool
     */
    public function isAccountNonExpired()
    {
        return (bool) (!$this->isAccountExpired());
    }

    /**
     * @return \Datetime|null
     */
    public function getAccountExpiration()
    {
        return $this->accountExpiration;
    }

    /**
     * @param \Datetime|null $accountExpiration
     */
    public function setAccountExpiration(\Datetime $accountExpiration = null)
    {
        $this->accountExpiration = $accountExpiration;
    }

    /**
     * @return bool
     */
    public function hasAccountExpiration()
    {
        return (bool) ($this->accountExpiration instanceof \Datetime);
    }

    /**
     * @return $this
     */
    public function clearAccountExpiration()
    {
        $this->accountExpiration = null;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAccountLocked()
    {
        return (bool) (true === $this->accountLocked);
    }

    /**
     * @return bool
     */
    public function isAccountNonLocked()
    {
        return (bool) (false === $this->accountLocked);
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return (bool) (false === $this->accountLocked);
    }

    /**
     * @param bool $accountLocked
     *
     * @return $this
     */
    public function setAccountLocked($accountLocked)
    {
        $this->accountLocked = (bool) $accountLocked;

        return $this;
    }

    /**
     * @return \Datetime|null
     */
    public function getPasswordExpiration()
    {
        return $this->passwordExpiration;
    }

    /**
     * @param \Datetime|null $passwordExpiration
     */
    public function setPasswordExpiration(\Datetime $passwordExpiration = null)
    {
        $this->passwordExpiration = $passwordExpiration;
    }

    /**
     * @return bool
     */
    public function hasPasswordExpiration()
    {
        return (bool) ($this->passwordExpiration instanceof \Datetime);
    }

    /**
     * @return bool
     */
    public function isCredentialsExpired()
    {
        return (bool) ($this->passwordExpiration instanceof \Datetime && (new \Datetime())->format('u') - $this->passwordExpiration->format('u') > 0);
    }

    /**
     * @return bool
     */
    public function isCredentialsNonExpired()
    {
        return (bool) (false === $this->isCredentialsExpired());
    }

    /**
     * @return $this
     */
    public function eraseCredentials()
    {
    }

    /**
     * @return ArrayCollection
     */
    public function getManagerOfCollection()
    {
        return $this->managerOf;
    }

    /**
     * @param ArrayCollection $organizations
     *
     * @return $this
     */
    public function setManagerOfCollection(ArrayCollection $organizations = null)
    {
        if ($organizations === null) {
            $this->clearManagerOfCollection();
        } else {
            $this->managerOf = $organizations;
        }

        return $this;
    }

    /**
     * @param OrganizationInterface $org
     *
     * @return $this
     */
    public function isManagerOf(OrganizationInterface $org)
    {
        return (bool) (true === $this->managerOf->contains($org));
    }

    /**
     * @param OrganizationInterface $org
     *
     * @return $this
     */
    public function addManagerOf(OrganizationInterface $org)
    {
        if (!$this->isManagerOf($org)) {
            $this->managerOf->add($org);
        }

        return $this;
    }

    /**
     * @param OrganizationInterface $org
     *
     * @return $this
     */
    public function removeManagerOf(OrganizationInterface $org)
    {
        if ($this->isManagerOf($org)) {
            $this->managerOf->removeElement($org);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function clearManagerOfCollection()
    {
        return $this->initializeManagerOfCollection();
    }
}

/* EOF */
