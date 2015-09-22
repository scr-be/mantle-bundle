<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Address;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HasAddressCollection.
 */
trait HasAddressCollection
{
    /**
     * @var ArrayCollection
     */
    protected $addresses;

    /**
     * Initialize trait.
     */
    public function initializeAddressCollection()
    {
        $this->addresses = new ArrayCollection();
    }

    /**
     * @param ArrayCollection $addresses
     *
     * @return $this
     */
    public function setAddressCollection(ArrayCollection $addresses = null)
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getAddressCollection()
    {
        return $this->addresses;
    }

    /**
     * @return bool
     */
    public function hasAddressCollection()
    {
        return (bool) (false === $this->addresses->isEmpty());
    }

    /**
     * @return $this
     */
    public function clearAddressCollection()
    {
        $this->addresses = new ArrayCollection();

        return $this;
    }

    /**
     * @param ArrayCollection|null $addresses
     *
     * @return $this
     *
     * @deprecated {@see setAddressCollection()}
     */
    public function setAddresses(ArrayCollection $addresses = null)
    {
        return $this->setAddressCollection($addresses);
    }

    /**
     * @return ArrayCollection|null
     *
     * @deprecated {@see getAddressCollection()}
     */
    public function getAddresses()
    {
        return $this->getAddressCollection();
    }

    /**
     * @return bool
     *
     * @deprecated {@see hasAddressCollection()}
     */
    public function hasAddresses()
    {
        return $this->hasAddressCollection();
    }

    /**
     * @return $this
     *
     * @deprecated {@see clearAddressCollection()}
     */
    public function clearAddresses()
    {
        return $this->clearAddressCollection();
    }

    /**
     * @param AddressInterface $address
     *
     * @return bool
     */
    public function hasAddress(AddressInterface $address)
    {
        return (bool) (true === $this->addresses->contains($address));
    }

    /**
     * @param AddressInterface $address
     *
     * @return $this
     */
    public function addAddress(AddressInterface $address)
    {
        if (false === $this->hasAddress($address)) {
            $this->addresses->add($address);
        }

        return $this;
    }

    /**
     * @param AddressInterface $address
     *
     * @return $this
     */
    public function removeAddress(AddressInterface $address)
    {
        if (true === $this->hasAddress($address)) {
            $this->addresses->removeElement($address);
        }

        return $this;
    }
}

/* EOF */
