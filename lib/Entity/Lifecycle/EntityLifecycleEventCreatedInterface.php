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
 * EntityLifecycleEventCreatedInterface
 *
 * Supports created datetime field as lifecycle event
 */
interface EntityLifecycleEventCreatedInterface
{
    /**
     * @var string
     */
    const ORM_LIFECYCLE_PROPERTY_CREATED = 'created_on';

    /**
     * Handle adding created datetime when entity is persisted
     *
     * @param LifecycleEventArgs $eventArgs
     */
    public function __ormPrePersistCreated(LifecycleEventArgs $eventArgs = null);
}

/* EOF */
