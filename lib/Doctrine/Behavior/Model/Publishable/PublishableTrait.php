<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Behavior\Model\Publishable;

/**
 * Class PublishableTrait
 *
 * @package Scribe\Doctrine\Behavior\Model\Publishable
 */
trait PublishableTrait
{
    /**
     * @var \Datetime|null
     */
    protected $publishedAt;

    /**
     * Gets the published datetime
     *
     * @return \Datetime|null
     */
    public function getPublishedAt()
    {
        return $this->publishedAt;
    }

    /**
     * Set the published datetime
     *
     * @param \Datetime $when
     *
     * @return $this
     */
    public function setPublishedAt(\Datetime $when = null)
    {
        $this->publishedAt = $when;

        return $this;
    }

    /**
     * Check if it is already published
     *
     * @return bool
     */
    public function isPublished()
    {
        if (null === $this->publishedAt) {
            return false;
        }

        return (bool) ($this->publishedAt <= (new \Datetime));
    }

    /**
     * Determine if it will be published by the provided date, or
     * at all.
     *
     * @param \Datetime $when
     *
     * @return bool
     */
    public function willBePublishedAt(\Datetime $when = null)
    {
        if ($this->publishedAt === null) {

            return false;
        } elseif ($when === null) {

            return true;
        }

        return (bool) ($this->publishedAt <= $when);
    }

    /**
     * Publish an entity
     *
     * @return $this
     */
    public function publish()
    {
        $this->publishedAt = new \Datetime;

        return $this;
    }

    /**
     * Revert a published entity
     *
     * @return $this
     */
    public function retract()
    {
        $this->publishedAt = null;

        return $this;
    }
}

/* EOF */
