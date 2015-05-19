<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\Address;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class AddressCollectionInterface.
 */
interface AddressCollectionInterface
{
    /**
     * @param ArrayCollection $addresses
     *
     * @return $this
     */
    public function setAddressCollection(ArrayCollection $addresses = null);

    /**
     * @return ArrayCollection|null
     */
    public function getAddressCollection();

    /**
     * @return bool
     */
    public function hasAddressCollection();

    /**
     * @return $this
     */
    public function clearAddressCollection();

    /**
     * @param ArrayCollection|null $addresses
     *
     * @return $this
     *
     * @deprecated {@see setAddressCollection()}
     */
    public function setAddresses(ArrayCollection $addresses = null);

    /**
     * @return ArrayCollection|null
     *
     * @deprecated {@see getAddressCollection()}
     */
    public function getAddresses();

    /**
     * @return bool
     *
     * @deprecated {@see hasAddressCollection()}
     */
    public function hasAddresses();

    /**
     * @return $this
     *
     * @deprecated {@see clearAddressCollection()}
     */
    public function clearAddresses();

    /**
     * @param AddressInterface $address
     *
     * @return bool
     */
    public function hasAddress(AddressInterface $address);

    /**
     * @param AddressInterface $address
     *
     * @return $this
     */
    public function addAddress(AddressInterface $address);

    /**
     * @param AddressInterface $address
     *
     * @return $this
     */
    public function removeAddress(AddressInterface $address);
}

/* EOF */
