<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Entity\Lifecycle;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

/**
 * EntityDatetimeCreatedLifecycleEvent
 *
 * Supports created datetime field as lifecycle event
 */
trait EntityLifecycleEventCreated
{
    /**
     * Handle adding created datetime when entity is persisted
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function __ormPrePersistSetCreatedOn(LifecycleEventArgs $eventArgs = null)
    {
        $createdProperty = EntityLifecycleEventCreatedInterface::ORM_LIFECYCLE_PROPERTY_CREATED;

        if (true === property_exists($this, $createdProperty)) {
            $this->$createdProperty = new \Datetime;
        }
    }
}

/* EOF */
