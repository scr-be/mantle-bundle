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

use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * EntityLifecycleEventUpdated
 *
 * Supports updated datetime field as lifecycle event
 */
trait EntityLifecycleEventUpdated
{
    /**
     * Handle adding created_on datetime when entity is persisted
     *
     * @param PreUpdateEventArgs $eventArgs
     */
    public function __ormPreUpdateSetUpdatedOn(PreUpdateEventArgs $eventArgs = null)
    {
        $updatedProperty = EntityLifecycleEventUpdatedInterface::ORM_LIFECYCLE_PROPERTY_UPDATED;

        if (null === $eventArgs ||
            true !== property_exists($this, $updatedProperty) ||
            true === $eventArgs->hasChangedField($updatedProperty)) {

            return;
        }

        $eventArgs->setNewValue($updatedProperty, new \Datetime);
    }
}

/* EOF */
