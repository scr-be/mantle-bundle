<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Behavior\Model\Timestampable;

/**
 * Class TimestampableTrait
 *
 * @package Scribe\Doctrine\Behavior\Model\Timestampable
 */
trait TimestampableTrait
{
    /**
     * Datetime of creation
     *
     * @var \Datetime
     */
    protected $created_on;

    /**
     * Datetime of last update
     *
     * @var \Datetime
     */
    protected $updated_on;

    /**
     * Get the created at timestamp (optionally formatted)
     *
     * @param null|string $format
     *
     * @return \Datetime|string
     */
    public function getCreatedOn($format = null)
    {
        if (null !== $format && $this->created_on instanceof \Datetime) {
            return $this->created_on->format($format);
        }

        return $this->created_on;
    }

    /**
     * Set the created=at timestamp
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
     * Get the updated-at timestamp (optionally formatted)
     *
     * @param null|string $format
     *
     * @return \Datetime|string
     */
    public function getUpdatedOn($format = null)
    {
        if (null !== $format && $this->updated_on instanceof \Datetime) {
            return $this->updated_on->format($format);
        }

        return $this->updated_on;
    }

    /**
     * Set the updated-at timestamp
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
     * Update created-at timestamp
     *
     * @return $this
     */
    public function updateCreatedOn()
    {
        if (false === ($this->created_on instanceof \Datetime)) {
            $this->created_on = new \Datetime;
        }

        return $this;
    }

    /**
     * Update updated-at timestamp
     *
     * @return $this
     */
    public function updateUpdatedOn()
    {
        $this->updated_on = new \Datetime;

        return $this;
    }

    /**
     * Update created/updated-at timestamps
     *
     * @return $this
     */
    public function updateTimestamps()
    {
        $this
            ->updateCreatedOn()
            ->updateUpdatedOn()
        ;

        return $this;
    }
}

/* EOF */
