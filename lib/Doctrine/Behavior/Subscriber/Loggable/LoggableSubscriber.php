<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Behavior\Subscriber\Loggable;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Scribe\Doctrine\Behavior\Subscriber\AbstractSubscriber;

/**
 * Class LoggableSubscriber.
 */
class LoggableSubscriber extends AbstractSubscriber
{
    /**
     * @var callable
     */
    protected $loggerCallable;

    /**
     * @param callable $loggerCallable
     *
     * @return $this
     */
    public function setLoggerCallable(callable $loggerCallable)
    {
        $this->loggerCallable = $loggerCallable;

        return $this;
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $this->logChangeSet($eventArgs, __FUNCTION__);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        $this->logChangeSet($eventArgs, __FUNCTION__);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function preDelete(LifecycleEventArgs $eventArgs)
    {
        $this->logChangeSet($eventArgs, __FUNCTION__);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     * @param string             $for
     */
    protected function logChangeSet(LifecycleEventArgs $eventArgs, $for)
    {
        list(, $entity, $reflectionClass, $uow, $classMetadata) =
            $this->getHelperObjectsForLifecycleEvent($eventArgs);

        if (true !== $this->isSupported($reflectionClass)) {
            return;
        }

        foreach ($this->getSubscriberTriggers($for) as $trigger) {
            if (true !== $this->classReflectionAnalyser->hasMethod($trigger, $reflectionClass)) {
                continue;
            }

            $uow->computeChangeSet($classMetadata, $entity);
            $changeSet = $uow->getEntityChangeSet($entity);

            $message = $entity->$trigger($changeSet);
            $loggerCallable = $this->loggerCallable;
            $loggerCallable($message);
        }
    }
}

/* EOF */
