<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Behavior\Subscriber\Timestampable;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;
use Scribe\Doctrine\Behavior\Subscriber\AbstractSubscriber;

/**
 * Class TimestampableSubscriber.
 */
class TimestampableSubscriber extends AbstractSubscriber
{
    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        $reflectionClass = $classMetadata->getReflectionClass();

        if (true !== $this->isSupported($reflectionClass, true)) {
            return;
        }

        foreach ($this->getSubscriberFields() as $field) {
            if ($classMetadata->hasField($field) && 'datetime' === $classMetadata->getTypeOfField($field)) {
                continue;
            }

            $classMetadata->mapField([
                'fieldName' => $field,
                'type' => 'datetime',
                'nullable' => true,
            ]);
        }

        foreach ($this->getSubscriberTriggers() as $trigger) {
            if ($this->classReflectionAnalyser->hasMethod($trigger, $reflectionClass)) {
                $classMetadata->addLifecycleCallback($trigger, Events::prePersist);
                $classMetadata->addLifecycleCallback($trigger, Events::preUpdate);
            }
        }
    }
}

/* EOF */
