<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Activity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HasActivityCollection.
 */
trait HasActivityCollection
{
    /**
     * @var ArrayCollection
     */
    protected $activities;

    /**
     * Initialize trait.
     */
    public function initializeActivityCollection()
    {
        $this->activities = new ArrayCollection();
    }

    /**
     * @param ArrayCollection $activities
     *
     * @return $this
     */
    public function setActivityCollection(ArrayCollection $activities = null)
    {
        $this->activities = $activities;

        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getActivityCollection()
    {
        return $this->activities;
    }

    /**
     * @return bool
     */
    public function hasActivityCollection()
    {
        return (bool) (false === $this->activities->isEmpty());
    }

    /**
     * @return $this
     */
    public function clearActivityCollection()
    {
        $this->activities = new ArrayCollection();

        return $this;
    }

    /**
     * @param ArrayCollection|null $activities
     *
     * @return $this
     *
     * @deprecated {@see setActivityCollection()}
     */
    public function setActivities(ArrayCollection $activities = null)
    {
        return $this->setActivityCollection($activities);
    }

    /**
     * @return ArrayCollection|null
     *
     * @deprecated {@see getActivityCollection()}
     */
    public function getActivities()
    {
        return $this->getActivityCollection();
    }

    /**
     * @return bool
     *
     * @deprecated {@see hasActivityCollection()}
     */
    public function hasActivities()
    {
        return $this->hasActivityCollection();
    }

    /**
     * @return $this
     *
     * @deprecated {@see clearActivityCollection()}
     */
    public function clearActivities()
    {
        return $this->clearActivityCollection();
    }

    /**
     * @param ActivityInterface $address
     *
     * @return bool
     */
    public function hasActivity(ActivityInterface $address)
    {
        return (bool) (true === $this->activities->contains($address));
    }

    /**
     * @param ActivityInterface $address
     *
     * @return $this
     */
    public function addActivity(ActivityInterface $address)
    {
        if (false === $this->hasActivity($address)) {
            $this->activities->add($address);
        }

        return $this;
    }

    /**
     * @param ActivityInterface $address
     *
     * @return $this
     */
    public function removeActivity(ActivityInterface $address)
    {
        if (true === $this->hasActivity($address)) {
            $this->activities->removeElement($address);
        }

        return $this;
    }
}

/* EOF */
