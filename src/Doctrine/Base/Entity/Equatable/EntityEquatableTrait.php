<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Entity\Equatable;

use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Wonka\Utility\Reflection\ClassReflectionAnalyser;

/**
 * Interface EntityEquatableInterface
 * Used to test if two objects are equal in orm and entity contexts.
 */
trait EntityEquatableTrait
{
    abstract public function getId();

    /**
     * Perform check to determining if the passed entity instance is equal
     * to self object instance.
     *
     * @param AbstractEntity $entity entity to test against
     *
     * @return bool
     */
    public function isEqualTo(AbstractEntity $entity)
    {
        return (bool) ($this === $entity);
    }

    /**
     * Check to see if the passed Entity object has the same orm-specified
     * {@see $this->id} value as the current object. This should not allow a
     * comparison of two null id values to return true.
     *
     * @param AbstractEntity $entity the entity object to check against
     *
     * @return bool
     */
    public function isEqualToId(AbstractEntity $entity)
    {
        $reflectionAnalyzer = new ClassReflectionAnalyser();
        $reflectionAnalyzer->setReflectionClassFromClassInstance($entity);

        $reflectionProperty = $reflectionAnalyzer->setPropertyPublic('id');
        $entityId = $reflectionProperty->getValue($entity);

        return (bool) ($this->getId() === $entityId ?: false);
    }

    /**
     * Check to see if the passed Entity object has the same property values
     * as the current object. This includes id, as well as all other class
     * properties.
     *
     * @param AbstractEntity $entity the entity object to check against
     *
     * @return bool
     */
    public function isEqualToProperties(AbstractEntity $entity)
    {
        $reflectionAnalyzer = new ClassReflectionAnalyser();

        $reflectionAnalyzer->setReflectionClassFromClassInstance($entity);
        $entityProperties = $reflectionAnalyzer->getProperties(false);

        $reflectionAnalyzer->setReflectionClassFromClassInstance($this);
        $thisProperties = $reflectionAnalyzer->getProperties(false);

        if (get_iterable_count($entityProperties) !== get_iterable_count($thisProperties)) {
            return false;
        }

        foreach ($entityProperties as $i => $entityProp) {
            $thisProp = $thisProperties[$i];

            $thisProp->setAccessible(true);
            $entityProp->setAccessible(true);

            if ($thisProp->getValue($this) !== $entityProp->getValue($entity)) {
                return false;
            }
        }

        return true;
    }
}

/* EOF */
