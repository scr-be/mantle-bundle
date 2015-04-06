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

/**
 * Interface ClassReflectionAnalyserInterface.
 */
interface ClassReflectionAnalyserInterface
{
    /**
     * Set the current reflection class to operate on (can be overridden by directly passing
     * a reflection class to any of the has[Trait|Method|Property] methods. Passing no value
     * effectivly unsets the internally held class instance.
     *
     * @param \ReflectionClass $reflectionClass
     *
     * @return $this
     */
    public function setReflectionClass(\ReflectionClass $reflectionClass = null);

    /**
     * Create and set the reflection class via a class name.
     *
     * @param string $class
     *
     * @return $this
     */
    public function setReflectionClassFromClassName($class);

    /**
     * Create and set the reflection class via a class instance.
     *
     * @param object $class
     *
     * @return $this
     */
    public function setReflectionClassFromClassInstance($class);

    /**
     * Unsets the current reflection class associated with object.
     *
     * @return $this
     */
    public function unsetReflectionClass();

    /**
     * Return true if the given object has the provided trait.
     *
     * @param string           $traitName
     * @param \ReflectionClass $class
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasTrait($traitName, \ReflectionClass $class = null, $recursiveSearch = true);

    /**
     * Returns true if the given object has the given method.
     *
     * @param string           $methodName
     * @param \ReflectionClass $class
     *
     * @return bool
     */
    public function hasMethod($methodName, \ReflectionClass $class = null);

    /**
     * Returns true if the given object has the given property.
     *
     * @param string           $propertyName
     * @param \ReflectionClass $class
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasProperty($propertyName, \ReflectionClass $class = null, $recursiveSearch = true);
}

/* EOF */
