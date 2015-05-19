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
 * Class TimestampableBehaviorInterface.
 */
interface TimestampableBehaviorInterface
{
    /**
     * Get the created on timestamp.
     *
     * @return \Datetime
     */
    public function getCreatedOn();

    /**
     * Set the created on timestamp.
     *
     * @param \Datetime $when
     *
     * @return $this
     */
    public function setCreatedOn(\Datetime $when);

    /**
     * Get the offset of the created on time from the provided one.
     *
     * @param \Datetime $from
     *
     * @return bool|\DateInterval
     */
    public function getCreatedOnOffset(\Datetime $from);

    /**
     * Get the updated on timestamp.
     *
     * @return \Datetime
     */
    public function getUpdatedOn();

    /**
     * Set the updated on timestamp.
     *
     * @param \Datetime $when
     *
     * @return $this
     */
    public function setUpdatedOn(\Datetime $when);

    /**
     * Get the offset of the updated on time from the provided one.
     *
     * @param \Datetime $from
     *
     * @return bool|\DateInterval
     */
    public function getUpdatedOnOffset(\Datetime $from);
}

/* EOF */
