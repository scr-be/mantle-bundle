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
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Trait EntityLifecycleEventsTrait
 *
 * Supports standard life-cycle doctrine events
 */
trait EntityLifecycleEventsTrait
{
    /**
     * Event occurs pre-removal of entity
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPreRemoveCaller(LifecycleEventArgs $eventArgs = null)
    {
        $this->__callOrmLifecycleMethods(EntityLifecycleEventsInterface::ORM_LIFECYCLE_PRE_REMOVE, $eventArgs);
    }

    /**
     * Event occurs post-removal of entity
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPostRemoveCaller(LifecycleEventArgs $eventArgs = null)
    {
        $this->__callOrmLifecycleMethods(EntityLifecycleEventsInterface::ORM_LIFECYCLE_POST_REMOVE, $eventArgs);
    }

    /**
     * Event occurs pre-persist (only initial insert) of entity
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPrePersistCaller(LifecycleEventArgs $eventArgs = null)
    {
        $this->__callOrmLifecycleMethods(EntityLifecycleEventsInterface::ORM_LIFECYCLE_PRE_PERSIST, $eventArgs);
    }

    /**
     * Event occurs post-persist (only initial insert) of entity
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPostPersistCaller(LifecycleEventArgs $eventArgs = null)
    {
        $this->__callOrmLifecycleMethods(EntityLifecycleEventsInterface::ORM_LIFECYCLE_POST_PERSIST, $eventArgs);
    }

    /**
     * Event occurs pre-update of entity
     *
     * @param null|PreUpdateEventArgs $eventArgs
     */
    public function __ormPreUpdateCaller(PreUpdateEventArgs $eventArgs = null)
    {
        $this->__callOrmLifecycleMethods(EntityLifecycleEventsInterface::ORM_LIFECYCLE_PRE_UPDATE, $eventArgs);
    }

    /**
     * Event occurs post-update of entity
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPostUpdateCaller(LifecycleEventArgs $eventArgs = null)
    {
        $this->__callOrmLifecycleMethods(EntityLifecycleEventsInterface::ORM_LIFECYCLE_POST_UPDATE, $eventArgs);
    }

    /**
     * Event occurs after the entity has been loaded into the EntityManager
     * from the DB or after a refresh operation.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function __ormPostLoadCaller(LifecycleEventArgs $eventArgs = null)
    {
        $this->__callOrmLifecycleMethods(EntityLifecycleEventsInterface::ORM_LIFECYCLE_POST_LOAD, $eventArgs);
    }

    /**
     * Call all lifecycle methods beginning with the pre-defined type
     *
     * @param string         $lifecycleType
     * @param EventArgs|null $eventArgs
     */
    final public function __callOrmLifecycleMethods($lifecycleType, EventArgs $eventArgs = null)
    {
        $lifecycleMethodSearch = '__orm'.$lifecycleType;

        $lifecycleMethods = array_filter(
            get_class_methods($this),
            function($method) use ($lifecycleMethodSearch) {
                if ($lifecycleMethodSearch === $lifecycleMethodSearch.'Caller') {
                    return false;
                }

                return (bool) (substr($method, 0, strlen($lifecycleMethodSearch)) === $lifecycleMethodSearch  
                                    && substr($method, -6, 6) !== 'Caller');
            }
        );

        foreach ($lifecycleMethods as $method) {
            $this->$method($eventArgs);
        }
    }
}

/* EOF */
