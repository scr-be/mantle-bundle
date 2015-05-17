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
use Scribe\Doctrine\Base\Model\HasPerson;
use Scribe\Doctrine\Base\Model\HasSlug;
use Scribe\Doctrine\Behavior\Model\Timestampable\TimestampableBehaviorTrait;
use Scribe\MantleBundle\Component\Security\Core\UserInterface;
use Scribe\MantleBundle\Doctrine\Base\Model\HasOrg;
use Scribe\MantleBundle\Doctrine\Base\Model\HasRolesOwningSide;

/**
 * Class User.
 */
class User extends AbstractEntity implements UserInterface
{
    use HasSlug,
        HasPerson,
        HasDescription,
        HasOrg,
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
    protected $accountExpiration;

    /**
     * @var bool
     */
    protected $accountLocked;

    /**
     * @var \Datetime|null
     */
    protected $passwordExpiration;

    /**
     * Support for casting from object type to string type.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getFullName();
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
        return (bool) ($this->accountExpiration instanceof \Datetime && (new \Datetime)->format('u') - $this->accountExpiration->format('u') > 0);
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
     * @return bool
     */
    public function isAccountLocked()
    {
        return (bool) $this->accountLocked;
    }

    /**
     * @return bool
     */
    public function isAccountNonLocked()
    {
        return (bool) (!$this->isAccountLocked());
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return (bool) $this->isAccountNonLocked();
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
        return (bool) ($this->passwordExpiration instanceof \Datetime && (new \Datetime)->format('u') - $this->passwordExpiration->format('u') > 0);
    }

    /**
     * @return bool
     */
    public function isCredentialsNonExpired()
    {
        return (!$this->isCredentialsExpired());
    }

    /**
     * @return $this
     */
    public function eraseCredentials() {}
}

/* EOF */
