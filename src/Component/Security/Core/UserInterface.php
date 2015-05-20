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
use Scribe\Doctrine\Base\Model\Activity\ActivityCollectionInterface;
use Scribe\Doctrine\Base\Model\Address\AddressCollectionInterface;
use Scribe\Doctrine\Base\Model\InstantMessenger\InstantMessengerCollectionInterface;
use Scribe\Doctrine\Base\Model\Phone\PhoneCollectionInterface;

/**
 * Class UserInterface.
 */
interface UserInterface extends AddressCollectionInterface, PhoneCollectionInterface, InstantMessengerCollectionInterface,
                                ActivityCollectionInterface, AdvancedUserInterface
{
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
     * @return ArrayCollection
     */
    public function getManagerOfCollection();

    /**
     * @param ArrayCollection $orgs
     *
     * @return $this
     */
    public function setManagerOfCollection(ArrayCollection $orgs);

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
}


/* EOF */
