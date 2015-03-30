<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Reflection;

/**
 * Class ClassReflectable
 *
 * Provides basic class analysis using Reflection.
 */
trait ClassReflectableTrait
{
    /**
     * Return true if the given object has the provided trait
     *
     * @param \ReflectionClass $class
     * @param string           $traitName
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasTrait(\ReflectionClass $class, $traitName, $recursiveSearch = true)
    {
        if (true === in_array($traitName, $class->getTraitNames())) {
            return true;
        }

        $parentClass = $class->getParentClass();

        if ((false === $recursiveSearch) || (false === $parentClass) || (null === $parentClass)) {
            return false;
        }

        return (bool) $this->hasTrait($parentClass, $traitName, $recursiveSearch);
    }

    /**
     * Returns true if the given object has the given method
     *
     * @param \ReflectionClass $class
     * @param string           $methodName
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasMethod(\ReflectionClass $class, $methodName, $recursiveSearch = true)
    {
        if (true === $class->hasMethod($methodName)) {
            return true;
        }

        $parentClass = $class->getParentClass();

        if ((false === $recursiveSearch) || (false === $parentClass) || (null === $parentClass)) {
            return false;
        }

        return (bool) $this->hasMethod($parentClass, $methodName, $recursiveSearch);
    }

    /**
     * Returns true if the given object has the given property
     *
     * @param \ReflectionClass $class
     * @param string           $propertyName
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasProperty(\ReflectionClass $class, $propertyName, $recursiveSearch = true)
    {
        if (true === $class->hasProperty($propertyName)) {
            return true;
        }

        $parentClass = $class->getParentClass();

        if ((false === $recursiveSearch) || (false === $parentClass) || (null === $parentClass)) {
            return false;
        }

        return (bool) $this->hasProperty($parentClass, $propertyName, $recursiveSearch);
    }
}

/* EOF */
