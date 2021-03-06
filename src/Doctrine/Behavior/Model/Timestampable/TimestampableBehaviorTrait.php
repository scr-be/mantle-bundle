<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Behavior\Model\Timestampable;

/**
 * Class TimestampableBehaviorTrait.
 */
trait TimestampableBehaviorTrait
{
    /**
     * Datetime of creation.
     *
     * @var \Datetime
     */
    protected $created_on;

    /**
     * Datetime of last update.
     *
     * @var \Datetime
     */
    protected $updated_on;

    /**
     * Get the created on timestamp.
     *
     * @return \Datetime
     */
    public function getCreatedOn()
    {
        return $this->created_on;
    }

    /**
     * Set the created on timestamp.
     *
     * @param \Datetime $when
     *
     * @return $this
     */
    public function setCreatedOn(\Datetime $when)
    {
        $this->created_on = $when;

        return $this;
    }

    /**
     * Get the offset of the created on time from the provided one.
     *
     * @param \Datetime $from
     *
     * @return bool|\DateInterval
     */
    public function getCreatedOnOffset(\Datetime $from)
    {
        return $this->created_on->diff($from);
    }

    /**
     * Get the updated on timestamp.
     *
     * @return \Datetime
     */
    public function getUpdatedOn()
    {
        return $this->updated_on;
    }

    /**
     * Set the updated on timestamp.
     *
     * @param \Datetime $when
     *
     * @return $this
     */
    public function setUpdatedOn(\Datetime $when)
    {
        $this->updated_on = $when;

        return $this;
    }

    /**
     * Get the offset of the updated on time from the provided one.
     *
     * @param \Datetime $from
     *
     * @return bool|\DateInterval
     */
    public function getUpdatedOnOffset(\Datetime $from)
    {
        return $this->updated_on->diff($from);
    }

    /**
     * Trigger setting/updating both the created on and updated on values..
     *
     * @return $this
     */
    public function triggerUpdateTimestampEvent()
    {
        if (false === ($this->created_on instanceof \Datetime)) {
            $this->setCreatedOn(new \Datetime());
        }

        $this->setUpdatedOn(new \Datetime());

        return $this;
    }
}

/* EOF */
