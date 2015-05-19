<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\InstantMessenger;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HasInstantMessengerCollection.
 */
trait HasInstantMessengerCollection
{
    /**
     * @var ArrayCollection
     */
    protected $instantMessenger;

    /**
     * Initialize trait.
     */
    public function initializeInstantMessengerCollection()
    {
        $this->instantMessenger = new ArrayCollection();
    }

    /**
     * @param ArrayCollection $instantMessenger
     *
     * @return $this
     */
    public function setInstantMessengerCollection(ArrayCollection $instantMessenger = null)
    {
        $this->instantMessenger = $instantMessenger;

        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getInstantMessengerCollection()
    {
        return $this->instantMessenger;
    }

    /**
     * @return bool
     */
    public function hasInstantMessengerCollection()
    {
        return (bool) (false === $this->instantMessenger->isEmpty());
    }

    /**
     * @return $this
     */
    public function clearInstantMessengerCollection()
    {
        $this->instantMessenger = new ArrayCollection();

        return $this;
    }

    /**
     * @param ArrayCollection|null $instantMessenger
     *
     * @return $this
     *
     * @deprecated {@see setInstantMessengerCollection()}
     */
    public function setInstantMessengers(ArrayCollection $instantMessenger = null)
    {
        return $this->setInstantMessengerCollection($instantMessenger);
    }

    /**
     * @return ArrayCollection|null
     *
     * @deprecated {@see getInstantMessengerCollection()}
     */
    public function getInstantMessengers()
    {
        return $this->getInstantMessengerCollection();
    }

    /**
     * @return bool
     *
     * @deprecated {@see hasInstantMessengerCollection()}
     */
    public function hasInstantMessengers()
    {
        return $this->hasInstantMessengerCollection();
    }

    /**
     * @return $this
     *
     * @deprecated {@see clearInstantMessengerCollection()}
     */
    public function clearInstantMessengers()
    {
        return $this->clearInstantMessengerCollection();
    }

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return bool
     */
    public function hasInstantMessenger(InstantMessengerInterface $instantMessenger)
    {
        return (bool) (true === $this->instantMessenger->contains($instantMessenger));
    }

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return $this
     */
    public function addInstantMessenger(InstantMessengerInterface $instantMessenger)
    {
        if (false === $this->hasInstantMessenger($instantMessenger)) {
            $this->instantMessenger->add($instantMessenger);
        }

        return $this;
    }

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return $this
     */
    public function removeInstantMessenger(InstantMessengerInterface $instantMessenger)
    {
        if (true === $this->hasInstantMessenger($instantMessenger)) {
            $this->instantMessenger->removeElement($instantMessenger);
        }

        return $this;
    }

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return bool
     *
     * @deprecated {@see hasInstantMessenger()}
     */
    public function hasIM(InstantMessengerInterface $instantMessenger)
    {
        return $this->hasInstantMessenger($instantMessenger);
    }

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return $this
     *
     * @deprecated {@see addInstantMessenger()}
     */
    public function addIM(InstantMessengerInterface $instantMessenger)
    {
        return $this->addInstantMessenger($instantMessenger);
    }

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return $this
     *
     * @deprecated {@see removeInstantMessenger()}
     */
    public function removeIM(InstantMessengerInterface $instantMessenger)
    {
        return $this->removeInstantMessenger($instantMessenger);
    }
}

/* EOF */
