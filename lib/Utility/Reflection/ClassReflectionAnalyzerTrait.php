<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Reflection;

use Scribe\Exception\InvalidArgumentException;

/**
 * Class ClassReflectionAnalyzerTrait.
 */
trait ClassReflectionAnalyzerTrait
{
    /**
     * An instance of a reflection object, can be used instead of passing it manually to the
     * has[Trait|Method|Property] methods.
     *
     * @var \ReflectionClass|null
     */
    private $reflectionClass = null;

    /**
     * Set the current reflection class to operate on (can be overridden by directly passing
     * a reflection class to any of the has[Trait|Method|Property] methods.
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return $this
     */
    public function setReflectionClass(\ReflectionClass $reflectionClass = null)
    {
        $this->reflectionClass = $reflectionClass;

        return $this;
    }

    /**
     * Create and set the reflection class via a class name.
     *
     * @param string $class
     *
     * @return $this
     */
    public function setReflectionClassFromClassName($class)
    {
        $this->reflectionClass = new \ReflectionClass($class);

        return $this;
    }

    /**
     * Create and set the reflection class via a class instance.
     *
     * @param object $class
     *
     * @return $this
     */
    public function setReflectionClassFromClassInstance($class)
    {
        $this->reflectionClass = new \ReflectionClass($class);

        return $this;
    }

    /**
     * Unsets the current reflection class associated with object.
     *
     * @return $this
     */
    public function unsetReflectionClass()
    {
        $this->reflectionClass = null;

        return $this;
    }

    /**
     * Return true if the given object has the provided trait.
     *
     * @param string           $traitName
     * @param \ReflectionClass $class
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasTrait($traitName, \ReflectionClass $class = null, $recursiveSearch = true)
    {
        $class = $this->determineWorkUnitReflectionClass($class);

        if (true === in_array($traitName, $class->getTraitNames())) {
            return true;
        }

        $parentClass = $class->getParentClass();

        if ((false === $recursiveSearch) || (false === ($parentClass instanceof \ReflectionClass))) {
            return false;
        }

        return (bool) $this->hasTrait($traitName, $parentClass, $recursiveSearch);
    }

    /**
     * Returns true if the given object has the given method.
     *
     * @param string           $methodName
     * @param \ReflectionClass $class
     *
     * @return bool
     */
    public function hasMethod($methodName, \ReflectionClass $class = null)
    {
        if (null === ($class = $this->determineWorkUnitReflectionClass($class))) {
            return false;
        }

        if (true === $class->hasMethod($methodName)) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if the given object has the given property.
     *
     * @param string           $propertyName
     * @param \ReflectionClass $class
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasProperty($propertyName, \ReflectionClass $class = null, $recursiveSearch = true)
    {
        if (null === ($class = $this->determineWorkUnitReflectionClass($class))) {
            return false;
        }

        if (true === $class->hasProperty($propertyName)) {
            return true;
        }

        $parentClass = $class->getParentClass();

        if ((false === $recursiveSearch) || (false === ($parentClass instanceof \ReflectionClass))) {
            return false;
        }

        return (bool) $this->hasProperty($propertyName, $parentClass, $recursiveSearch);
    }

    /**
     * Returns either the explicitly provided reflection instance, the class-set reflection instance, or null.
     *
     * @param \ReflectionClass|null $reflectionClass
     *
     * @return \ReflectionClass|null
     */
    private function determineWorkUnitReflectionClass(\ReflectionClass $reflectionClass = null)
    {
        if ($reflectionClass instanceof \ReflectionClass) {
            return $reflectionClass;
        }

        if ($this->reflectionClass instanceof \ReflectionClass) {
            return $this->reflectionClass;
        }

        throw new InvalidArgumentException(
            'No valid object reflection class instance provided explicitly via method call or injected into object instance.'
        );
    }
}

/* EOF */
