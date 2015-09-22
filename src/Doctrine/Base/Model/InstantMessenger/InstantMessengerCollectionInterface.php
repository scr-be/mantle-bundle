<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\InstantMessenger;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class InstantMessengerCollectionInterface.
 */
interface InstantMessengerCollectionInterface
{
    /**
     * @param ArrayCollection $instantMessenger
     *
     * @return $this
     */
    public function setInstantMessengerCollection(ArrayCollection $instantMessenger = null);

    /**
     * @return ArrayCollection|null
     */
    public function getInstantMessengerCollection();

    /**
     * @return bool
     */
    public function hasInstantMessengerCollection();

    /**
     * @return $this
     */
    public function clearInstantMessengerCollection();

    /**
     * @param ArrayCollection|null $instantMessenger
     *
     * @return $this
     *
     * @deprecated {@see setInstantMessengerCollection()}
     */
    public function setInstantMessengers(ArrayCollection $instantMessenger = null);

    /**
     * @return ArrayCollection|null
     *
     * @deprecated {@see getInstantMessengerCollection()}
     */
    public function getInstantMessengers();

    /**
     * @return bool
     *
     * @deprecated {@see hasInstantMessengerCollection()}
     */
    public function hasInstantMessengers();

    /**
     * @return $this
     *
     * @deprecated {@see clearInstantMessengerCollection()}
     */
    public function clearInstantMessengers();

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return bool
     */
    public function hasInstantMessenger(InstantMessengerInterface $instantMessenger);

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return $this
     */
    public function addInstantMessenger(InstantMessengerInterface $instantMessenger);

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return $this
     */
    public function removeInstantMessenger(InstantMessengerInterface $instantMessenger);

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return bool
     *
     * @deprecated {@see hasInstantMessenger()}
     */
    public function hasIM(InstantMessengerInterface $instantMessenger);

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return $this
     *
     * @deprecated {@see addInstantMessenger()}
     */
    public function addIM(InstantMessengerInterface $instantMessenger);

    /**
     * @param InstantMessengerInterface $instantMessenger
     *
     * @return $this
     *
     * @deprecated {@see removeInstantMessenger()}
     */
    public function removeIM(InstantMessengerInterface $instantMessenger);
}

/* EOF */
