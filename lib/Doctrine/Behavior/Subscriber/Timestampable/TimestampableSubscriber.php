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
        if (null === ($classMetadata = $eventArgs->getClassMetadata())) {
            return;
        }

        $reflectionClass = $classMetadata->getReflectionClass();

        if (true !== ($reflectionClass instanceof \ReflectionClass)) {
            return;
        }

        if (true !== $this->isSupported($reflectionClass)) {
            return;
        }

        if ($this->classReflectionAnalyser->hasMethod('triggerUpdateTimestampEvent', $reflectionClass)) {
            $classMetadata->addLifecycleCallback('triggerUpdateTimestampEvent', Events::prePersist);
            $classMetadata->addLifecycleCallback('triggerUpdateTimestampEvent', Events::preUpdate);

            foreach (['created_on', 'updated_on'] as $field) {
                if ($classMetadata->hasField($field)) {
                    continue;
                }

                $classMetadata->mapField([
                    'fieldName' => $field,
                    'type'      => 'datetime',
                    'nullable'  => true,
                ]);
            }
        }
    }
}

/* EOF */
