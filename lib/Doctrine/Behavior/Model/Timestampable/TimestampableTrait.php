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
 * Class TimestampableTrait.
 */
trait TimestampableTrait
{
    /**
     * Datetime of creation.
     *
     * @var \Datetime
     */
    protected $created_at;

    /**
     * Datetime of last update.
     *
     * @var \Datetime
     */
    protected $updated_at;

    /**
     * Get the created at timestamp (optionally formatted).
     *
     * @param null|string $format
     *
     * @return \Datetime|string
     */
    public function getCreatedAt($format = null)
    {
        if (null !== $format && $this->created_at instanceof \Datetime) {
            return $this->created_at->format($format);
        }

        return $this->created_at;
    }

    /**
     * Set the created=at timestamp.
     *
     * @param \Datetime $when
     *
     * @return $this
     */
    public function setCreatedAt(\Datetime $when)
    {
        $this->created_at = $when;

        return $this;
    }

    /**
     * Get the updated-at timestamp (optionally formatted).
     *
     * @param null|string $format
     *
     * @return \Datetime|string
     */
    public function getUpdatedAt($format = null)
    {
        if (null !== $format && $this->updated_at instanceof \Datetime) {
            return $this->updated_at->format($format);
        }

        return $this->updated_at;
    }

    /**
     * Set the updated-at timestamp.
     *
     * @param \Datetime $when
     *
     * @return $this
     */
    public function setUpdatedAt(\Datetime $when)
    {
        $this->updated_at = $when;

        return $this;
    }

    /**
     * Update created-at timestamp.
     *
     * @return $this
     */
    public function updateCreatedAt()
    {
        if (false === ($this->created_at instanceof \Datetime)) {
            $this->created_at = new \Datetime();
        }

        return $this;
    }

    /**
     * Update updated-at timestamp.
     *
     * @return $this
     */
    public function updateUpdatedAt()
    {
        $this->updated_at = new \Datetime();

        return $this;
    }

    /**
     * Update created/updated-at timestamps.
     *
     * @return $this
     */
    public function updateTimestamps()
    {
        $this
            ->updateCreatedAt()
            ->updateUpdatedAt()
        ;

        return $this;
    }
}

/* EOF */
