<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Behavior\Subscriber\Hierarchical;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Scribe\Doctrine\Behavior\Subscriber\AbstractSubscriber;

/**
 * Class HierarchicalNodeSubscriber.
 */
class HierarchicalNodeSubscriber extends AbstractSubscriber
{
    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        list($classMetadata, $reflectionClass) = $this->getHelperObjectsForLoadClassMetadata($eventArgs);

        if (true !== $this->isSupported($reflectionClass, true)) {
            return;
        }

        foreach ($this->getSubscriberFields() as $field) {
            if ($classMetadata->hasField($field)) {
                continue;
            }

            $classMetadata->mapField([
                'fieldName' => $field,
                'type' => 'string',
                'length' => 510,
            ]);
        }
    }
}

/* EOF */
