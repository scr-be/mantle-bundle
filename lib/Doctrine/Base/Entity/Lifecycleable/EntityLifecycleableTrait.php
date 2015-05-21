<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Entity\Lifecycleable;

use Doctrine\Common\EventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Trait EntityLifecycleableTrait.
 *
 * Supports standard life-cycle doctrine events
 */
trait EntityLifecycleableTrait
{
    /**
     * Event occurs pre-removal of entity.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPreRemove(LifecycleEventArgs $eventArgs = null)
    {
        $this->callOrmLifecycleEvent(EntityLifecycleableInterface::ORM_LC_PRE_REMOVE, $eventArgs);
    }

    /**
     * Event occurs post-removal of entity.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPostRemove(LifecycleEventArgs $eventArgs = null)
    {
        $this->callOrmLifecycleEvent(EntityLifecycleableInterface::ORM_LC_POST_REMOVE, $eventArgs);
    }

    /**
     * Event occurs pre-persist (only initial insert) of entity.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPrePersist(LifecycleEventArgs $eventArgs = null)
    {
        $this->callOrmLifecycleEvent(EntityLifecycleableInterface::ORM_LC_PRE_PERSIST, $eventArgs);
    }

    /**
     * Event occurs post-persist (only initial insert) of entity.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPostPersist(LifecycleEventArgs $eventArgs = null)
    {
        $this->callOrmLifecycleEvent(EntityLifecycleableInterface::ORM_LC_POST_PERSIST, $eventArgs);
    }

    /**
     * Event occurs pre-update of entity.
     *
     * @param null|PreUpdateEventArgs $eventArgs
     */
    public function callOrmPreUpdate(PreUpdateEventArgs $eventArgs = null)
    {
        $this->callOrmLifecycleEvent(EntityLifecycleableInterface::ORM_LC_PRE_UPDATE, $eventArgs);
    }

    /**
     * Event occurs post-update of entity.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPostUpdate(LifecycleEventArgs $eventArgs = null)
    {
        $this->callOrmLifecycleEvent(EntityLifecycleableInterface::ORM_LC_POST_UPDATE, $eventArgs);
    }

    /**
     * Event occurs after the entity has been loaded into the EntityManager
     * from the DB or after a refresh operation.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPostLoad(LifecycleEventArgs $eventArgs = null)
    {
        $this->callOrmLifecycleEvent(EntityLifecycleableInterface::ORM_LC_POST_LOAD, $eventArgs);
    }

    /**
     * Call all lifecycle methods beginning with the pre-defined type.
     *
     * @param string         $lifecycleType
     * @param EventArgs|null $eventArgs
     */
    final public function callOrmLifecycleEvent($lifecycleType, EventArgs $eventArgs = null)
    {
        $lifecycleMethodSearch = EntityLifecycleableInterface::ORM_LC_METHOD_PREFIX.$lifecycleType;
        $lifecycleMethodSearchLen = strlen($lifecycleMethodSearch);

        $lifecycleMethods = array_filter(
            get_class_methods($this),
            function ($method) use ($lifecycleMethodSearch, $lifecycleMethodSearchLen) {
                return (bool) (substr($method, 0, $lifecycleMethodSearchLen) === $lifecycleMethodSearch);
            }
        );

        foreach ($lifecycleMethods as $method) {
            $this->$method($eventArgs);
        }
    }
}

/* EOF */
