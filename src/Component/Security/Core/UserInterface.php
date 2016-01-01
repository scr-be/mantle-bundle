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
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Scribe\MantleBundle\Doctrine\Base\Model\Activity\ActivityCollectionInterface;
use Scribe\MantleBundle\Doctrine\Base\Model\Address\AddressCollectionInterface;
use Scribe\MantleBundle\Doctrine\Base\Model\Phone\PhoneCollectionInterface;

/**
 * Class UserInterface.
 */
interface UserInterface extends
    AddressCollectionInterface,
    PhoneCollectionInterface,
    ActivityCollectionInterface,
    AdvancedUserInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return string
     */
    public function getUsername();

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername($username);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password);

    /**
     * @return null|string
     */
    public function getSalt();

    /**
     * @param null|string $salt
     *
     * @return $this
     */
    public function setSalt($salt);

    /**
     * @return bool
     */
    public function isAccountExpired();

    /**
     * @return bool
     */
    public function isAccountNonExpired();

    /**
     * @return \Datetime|null
     */
    public function getAccountExpiration();

    /**
     * @param \Datetime|null $accountExpiration
     */
    public function setAccountExpiration(\Datetime $accountExpiration = null);

    /**
     * @return bool
     */
    public function hasAccountExpiration();

    /**
     * @return $this
     */
    public function clearAccountExpiration();

    /**
     * @return bool
     */
    public function isAccountLocked();

    /**
     * @return bool
     */
    public function isAccountNonLocked();

    /**
     * @return bool
     */
    public function isEnabled();

    /**
     * @param bool $accountLocked
     *
     * @return $this
     */
    public function setAccountLocked($accountLocked);

    /**
     * @return \Datetime|null
     */
    public function getPasswordExpiration();

    /**
     * @param \Datetime|null $passwordExpiration
     */
    public function setPasswordExpiration(\Datetime $passwordExpiration = null);

    /**
     * @return bool
     */
    public function hasPasswordExpiration();

    /**
     * @return bool
     */
    public function isCredentialsExpired();

    /**
     * @return bool
     */
    public function isCredentialsNonExpired();

    /**
     * @return $this
     */
    public function eraseCredentials();

    /**
     * @return \Doctrine\ORM\PersistentCollection
     */
    public function getManagerOfCollection();

    /**
     * @param ArrayCollection $organizations
     *
     * @return $this
     */
    public function setManagerOfCollection(ArrayCollection $organizations);

    /**
     * @param OrganizationInterface $org
     *
     * @return $this
     */
    public function isManagerOf(OrganizationInterface $org);

    /**
     * @param OrganizationInterface $org
     *
     * @return $this
     */
    public function addManagerOf(OrganizationInterface $org);

    /**
     * @param OrganizationInterface $org
     *
     * @return $this
     */
    public function removeManagerOf(OrganizationInterface $org);

    /**
     * Compiles full name string.
     *
     * @return string
     */
    public function getFullName();

    /**
     * Compiles short name string.
     *
     * @return string
     */
    public function getShortName();

    /**
     * Setter for honorific property.
     *
     * @param string|null $honorific the honorific string
     *
     * @return $this
     */
    public function setHonorific($honorific = null);

    /**
     * Getter for honorific property.
     *
     * @return string|null
     */
    public function getHonorific();

    /**
     * Checker for honorific property.
     *
     * @return bool
     */
    public function hasHonorific();

    /**
     * Nullify the honorific property.
     *
     * @return $this
     */
    public function clearHonorific();

    /**
     * Setter for firstName property.
     *
     * @param string|null $firstName the firstName string
     *
     * @return $this
     */
    public function setFirstName($firstName = null);

    /**
     * Getter for firstName property.
     *
     * @return string|null
     */
    public function getFirstName();

    /**
     * Checker for firstName property.
     *
     * @return bool
     */
    public function hasFirstName();

    /**
     * Nullify the firstName property.
     *
     * @return $this
     */
    public function clearFirstName();

    /**
     * Setter for middleName property.
     *
     * @param string|null $middleName the middleName string
     *
     * @return $this
     */
    public function setMiddleName($middleName = null);

    /**
     * Getter for middleName property.
     *
     * @return string|null
     */
    public function getMiddleName();

    /**
     * Checker for middleName property.
     *
     * @return bool
     */
    public function hasMiddleName();

    /**
     * Nullify the middleName property.
     *
     * @return $this
     */
    public function clearMiddleName();

    /**
     * Setter for surname property.
     *
     * @param string|null $surname the surname string
     *
     * @return $this
     */
    public function setSurname($surname = null);

    /**
     * Getter for surname property.
     *
     * @return string|null
     */
    public function getSurname();

    /**
     * Checker for surname property.
     *
     * @return bool
     */
    public function hasSurname();

    /**
     * Nullify the surname property.
     *
     * @return $this
     */
    public function clearSurname();

    /**
     * Setter for suffix property.
     *
     * @param string|null $suffix the suffix string
     *
     * @return $this
     */
    public function setSuffix($suffix = null);

    /**
     * Getter for suffix property.
     *
     * @return string|null
     */
    public function getSuffix();

    /**
     * Checker for suffix property.
     *
     * @return bool
     */
    public function hasSuffix();

    /**
     * Nullify the suffix property.
     *
     * @return $this
     */
    public function clearSuffix();

    /**
     * Setter for organization property.
     *
     * @param OrganizationInterface|null $org a organization entity object instance
     *
     * @return $this
     */
    public function setOrganization(OrganizationInterface $org = null);

    /**
     * Getter for organization property.
     *
     * @return OrganizationInterface|null
     */
    public function getOrganization();

    /**
     * Checker for organization property.
     *
     * @return bool
     */
    public function hasOrganization();

    /**
     * Nullify the organization property.
     *
     * @return $this
     */
    public function clearOrganization();
}

/* EOF */
