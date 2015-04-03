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
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Trait EntityLifecycleableInterface.
 *
 * Supports standard life-cycle doctrine events
 */
interface EntityLifecycleableInterface
{
    /**
     * @var string
     */
    const ORM_LC_METHOD_PREFIX = 'orm';

    /**
     * @var string
     */
    const ORM_LC_PRE_PERSIST = 'PrePersist';

    /**
     * @var string
     */
    const ORM_LC_POST_PERSIST = 'PostPersist';

    /**
     * @var string
     */
    const ORM_LC_PRE_REMOVE = 'PreRemove';

    /**
     * @var string
     */
    const ORM_LC_POST_REMOVE = 'PostRemove';

    /**
     * @var string
     */
    const ORM_LC_PRE_UPDATE = 'PreUpdate';

    /**
     * @var string
     */
    const ORM_LC_POST_UPDATE = 'PostUpdate';

    /**
     * @var string
     */
    const ORM_LC_POST_LOAD = 'PostLoad';

    /**
     * Event occurs pre-removal of entity.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPreRemove(LifecycleEventArgs $eventArgs = null);

    /**
     * Event occurs post-removal of entity.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPostRemove(LifecycleEventArgs $eventArgs = null);

    /**
     * Event occurs pre-persist (only initial insert) of entity.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPrePersist(LifecycleEventArgs $eventArgs = null);

    /**
     * Event occurs post-persist (only initial insert) of entity.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPostPersist(LifecycleEventArgs $eventArgs = null);

    /**
     * Event occurs pre-update of entity.
     *
     * @param null|PreUpdateEventArgs $eventArgs
     */
    public function callOrmPreUpdate(PreUpdateEventArgs $eventArgs = null);

    /**
     * Event occurs post-update of entity.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPostUpdate(LifecycleEventArgs $eventArgs = null);

    /**
     * Event occurs after the entity has been loaded into the EntityManager
     * from the DB or after a refresh operation.
     *
     * @param null|LifecycleEventArgs $eventArgs
     */
    public function callOrmPostLoad(LifecycleEventArgs $eventArgs = null);

    /**
     * Call all lifecycle methods beginning with the pre-defined type.
     *
     * @param string         $lifecycleType
     * @param EventArgs|null $eventArgs
     */
    public function callOrmLifecycleEvent($lifecycleType, EventArgs $eventArgs = null);
}

/* EOF */
