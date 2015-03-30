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
 * Interface ClassReflectableInterface
 *
 * Provides basic class analysis using Reflection.
 */
interface ClassReflectableInterface
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
    public function hasTrait(\ReflectionClass $class, $traitName, $recursiveSearch = true);

    /**
     * Returns true if the given object has the given method
     *
     * @param \ReflectionClass $class
     * @param string           $methodName
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasMethod(\ReflectionClass $class, $methodName, $recursiveSearch = true);

    /**
     * Returns true if the given object has the given property
     *
     * @param \ReflectionClass $class
     * @param string           $propertyName
     * @param bool             $recursiveSearch
     *
     * @return bool
     */
    public function hasProperty(\ReflectionClass $class, $propertyName, $recursiveSearch = true);
}

/* EOF */
