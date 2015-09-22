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
 * Class ActivityCollectionInterface.
 */
interface ActivityCollectionInterface
{
    /**
     * @param ArrayCollection $activities
     *
     * @return $this
     */
    public function setActivityCollection(ArrayCollection $activities = null);

    /**
     * @return ArrayCollection|null
     */
    public function getActivityCollection();

    /**
     * @return bool
     */
    public function hasActivityCollection();

    /**
     * @return $this
     */
    public function clearActivityCollection();

    /**
     * @param ArrayCollection|null $activities
     *
     * @return $this
     *
     * @deprecated {@see setActivityCollection()}
     */
    public function setActivities(ArrayCollection $activities = null);

    /**
     * @return ArrayCollection|null
     *
     * @deprecated {@see getActivityCollection()}
     */
    public function getActivities();

    /**
     * @return bool
     *
     * @deprecated {@see hasActivityCollection()}
     */
    public function hasActivities();

    /**
     * @return $this
     *
     * @deprecated {@see clearActivityCollection()}
     */
    public function clearActivities();

    /**
     * @param ActivityInterface $activity
     *
     * @return bool
     */
    public function hasActivity(ActivityInterface $activity);

    /**
     * @param ActivityInterface $activity
     *
     * @return $this
     */
    public function addActivity(ActivityInterface $activity);

    /**
     * @param ActivityInterface $activity
     *
     * @return $this
     */
    public function removeActivity(ActivityInterface $activity);
}

/* EOF */
