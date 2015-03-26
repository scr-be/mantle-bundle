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

use Doctrine\Common\EventArgs;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;

/**
 * Trait EntityLifecycleEventsTrait
 *
 * Supports standard life-cycle doctrine events
 */
interface EntityLifecycleEventsInterface
{
    /**
     * @var string
     */
    const ORM_LIFECYCLE_PRE_PERSIST = 'PrePersist';

    /**
     * @var string
     */
    const ORM_LIFECYCLE_POST_PERSIST = 'PostPersist';

    /**
     * @var string
     */
    const ORM_LIFECYCLE_PRE_REMOVE = 'PreRemove';

    /**
     * @var string
     */
    const ORM_LIFECYCLE_POST_REMOVE = 'PostRemove';

    /**
     * @var string
     */
    const ORM_LIFECYCLE_PRE_UPDATE = 'PreUpdate';

    /**
     * @var string
     */
    const ORM_LIFECYCLE_POST_UPDATE = 'PostUpdate';

    /**
     * @var string
     */
    const ORM_LIFECYCLE_POST_LOAD = 'PostLoad';

    /**
     * Event occurs pre-removal of entity
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPreRemoveCaller(LifecycleEventArgs $eventArgs = null);

    /**
     * Event occurs post-removal of entity
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPostRemoveCaller(LifecycleEventArgs $eventArgs = null);

    /**
     * Event occurs pre-persist (only initial insert) of entity
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPrePersistCaller(LifecycleEventArgs $eventArgs = null);

    /**
     * Event occurs post-persist (only initial insert) of entity
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPostPersistCaller(LifecycleEventArgs $eventArgs = null);

    /**
     * Event occurs pre-update of entity
     *
     * @param null|PreUpdateEventArgs $eventArgs
     */
    public function __ormPreUpdateCaller(PreUpdateEventArgs $eventArgs = null);

    /**
     * Event occurs post-update of entity
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPostUpdateCaller(LifecycleEventArgs $eventArgs = null);

    /**
     * Event occurs after the entity has been loaded into the EntityManager
     * from the DB or after a refresh operation.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPostLoadCaller(LifecycleEventArgs $eventArgs = null);

    /**
     * Call all lifecycle methods beginning with the pre-defined type
     *
     * @param string         $lifecycleType
     * @param EventArgs|null $eventArgs
     */
    public function __callOrmLifecycleMethods($lifecycleType, EventArgs $eventArgs = null);
}

/* EOF */
