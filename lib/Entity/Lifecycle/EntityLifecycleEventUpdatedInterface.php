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

use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;

/**
 * EntityLifecycleEventUpdatedInterface
 *
 * Supports updated datetime field as lifecycle event
 */
interface EntityLifecycleEventUpdatedInterface
{
    /**
     * @var string
     */
    const ORM_LIFECYCLE_PROPERTY_UPDATED = 'updated_on';

    /**
     * Handle adding updated datetime when entity is persisted
     *
     * @param PreUpdateEventArgs $eventArgs
     */
    public function __ormPreUpdateSetUpdatedOn(PreUpdateEventArgs $eventArgs = null);
}

/* EOF */
