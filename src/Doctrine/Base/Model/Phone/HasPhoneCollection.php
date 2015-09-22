<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Phone;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HasPhoneCollection.
 */
trait HasPhoneCollection
{
    /**
     * @var ArrayCollection
     */
    protected $phones;

    /**
     * Initialize trait.
     */
    public function initializePhoneCollection()
    {
        $this->phones = new ArrayCollection();
    }

    /**
     * @param ArrayCollection $phones
     *
     * @return $this
     */
    public function setPhoneCollection(ArrayCollection $phones = null)
    {
        $this->phones = $phones;

        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getPhoneCollection()
    {
        return $this->phones;
    }

    /**
     * @return bool
     */
    public function hasPhoneCollection()
    {
        return (bool) (false === $this->phones->isEmpty());
    }

    /**
     * @return $this
     */
    public function clearPhoneCollection()
    {
        $this->phones = new ArrayCollection();

        return $this;
    }

    /**
     * @param ArrayCollection|null $phones
     *
     * @return $this
     *
     * @deprecated {@see setPhoneCollection()}
     */
    public function setPhones(ArrayCollection $phones = null)
    {
        return $this->setPhoneCollection($phones);
    }

    /**
     * @return ArrayCollection|null
     *
     * @deprecated {@see getPhoneCollection()}
     */
    public function getPhones()
    {
        return $this->getPhoneCollection();
    }

    /**
     * @return bool
     *
     * @deprecated {@see hasPhoneCollection()}
     */
    public function hasPhones()
    {
        return $this->hasPhoneCollection();
    }

    /**
     * @return $this
     *
     * @deprecated {@see clearPhoneCollection()}
     */
    public function clearPhones()
    {
        return $this->clearPhoneCollection();
    }

    /**
     * @param PhoneInterface $phone
     *
     * @return bool
     */
    public function hasPhone(PhoneInterface $phone)
    {
        return (bool) (true === $this->phones->contains($phone));
    }

    /**
     * @param PhoneInterface $phone
     *
     * @return $this
     */
    public function addPhone(PhoneInterface $phone)
    {
        if (false === $this->hasPhone($phone)) {
            $this->phones->add($phone);
        }

        return $this;
    }

    /**
     * @param PhoneInterface $phone
     *
     * @return $this
     */
    public function removePhone(PhoneInterface $phone)
    {
        if (true === $this->hasPhone($phone)) {
            $this->phones->removeElement($phone);
        }

        return $this;
    }
}

/* EOF */
