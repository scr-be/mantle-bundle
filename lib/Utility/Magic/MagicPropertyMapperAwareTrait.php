<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Magic;

use Scribe\Exception\LogicException;
use Scribe\Exception\RuntimeException;
use Scribe\Utility\Arrays;

/**
 * Trait MagicPropertyMapperAwareTrait
 *
 * Allows for quick mapping of any indexed or hashed array of values to properties within a class.
 */
trait MagicPropertyMapperAwareTrait
{
    /**
     * Sets the object instance's properties directly by interpreting an associative array as the key representing the
     * property name and the value representing the value that will be assigned. More specifically, this function must
     * be passed an array (or multiple arrays---as this is a variadic function) that follow the following prototype:
     * ['propertyFoo' => 'valueFoo', 'propertyBar' => 'valueBar', ...]. It is important to note that if an array index
     * is specified in multiple parameters passed to this method, the value of the last instance of the repeated
     * property name (array index) will be the one used to when setting the object property.
     *
     * @param array[] $parameters
     *
     * @return $this
     */
    protected function assignPropertyCollectionToSelf(array ...$parameters)
    {
        $assignmentCollection = $this->normalizeAssignmentCollectionParameters(
            $parameters,
            [$this, 'filterPropertyCollectionForSelf']
        );

        if (true === empty($assignmentCollection)) {
            return $this;
        }

        foreach ($assignmentCollection as $property => $value) {
            $this->assignPropertyToSelf($property, $value);
        }

        return $this;
    }

    /**
     * Filters the passed associative array (using the index as the property) so it only contains assignments to defined
     * properties within the current object context.
     *
     * @param array $assignmentCollection
     *
     * @return array
     */
    private function filterPropertyCollectionForSelf(array $assignmentCollection)
    {
        if (false === Arrays::isHash($assignmentCollection)) {
            return [];
        }

        $objectProperties = get_object_vars($this);

        return (array) array_filter($assignmentCollection, function($property) use ($objectProperties) {
            return (bool) in_array($property, $objectProperties);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Given a multi-dimensional array who's first-level is a simple index-based array with values consisting of
     * associative arrays intended to act as instructions for assigning properties or calling functions based on the
     * associative array index and values intended to act as the value for the assignment or parameter(s) to the function,
     * this method merges the first level down to a single associative array. Passing the optional callable allows for
     * action to be taken on the associative array prior to merger and should accept an array as its sole parameter and
     * return an array as a result of whatever actions it may perform.
     *
     * @param array         $parameters
     * @param callable|null $assignmentCollectionFilter
     *
     * @return array
     */
    final private function normalizeAssignmentCollectionParameters(array $parameters, callable $assignmentCollectionFilter = null)
    {
        $assignmentCollectionMerged = [];

        if (empty($parameters)) {
            return $assignmentCollectionMerged;
        }

        if (null === $assignmentCollectionFilter) {
            $assignmentCollectionFilter = function($collection) { return $collection; };
        }

        foreach ($parameters as $index => $assignmentCollection) {
            $assignmentCollectionMerged = array_merge(
                (array) $assignmentCollectionMerged,
                (array) $assignmentCollectionFilter($assignmentCollection)
            );
        }

        return (array) $assignmentCollectionMerged;
    }

    /**
     * Attempts to assign a variable property the passed value.
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return $this
     */
    final private function assignPropertyToSelf($property, $value)
    {
        try {
            $this->$property = $value;
        } catch (\Exception $e) {
            throw new RuntimeException(
                'Could not directly assign the property "%s" in class "%s" using method "%s"',
                RuntimeException::CODE_INVALID_ARGS, null, null, (string) $property, get_class($this), __FUNCTION__
            );
        }

        return $this;
    }



    /**
     * Maps an array hash consisting of the property names for indexes and property values as the corresponding values
     * and uses a setter method (of the form "setPropertyName" by default) to set their values.
     * To customize the setter method form reference {@see getSetterMethodNameForPropertyName}.
     *
     * @param array $propertyHash
     */
    protected function mapHashToPropertiesBySetter(array $propertyHash = [])
    {
        if (false === $this->isValidHashArrayMap($propertyHash)) {
            return;
        }

        foreach ($propertyHash as $property => $value) {
            $this->setPropertyBySetterMethod(
                $property,
                $value
            );
        }
    }

    /**
     * Sets a property by using its setter method to pass the provided value. Ensures the method exists, is accessible,
     * and catches and re-throws any exceptions caused by the call attempt.
     *
     * @param string $property
     * @param mixed  $value
     *
     * @throws LogicException
     */
    private function setPropertyBySetterMethod($property, $value)
    {
        $setterMethod = $this->getSetterMethodNameForPropertyName($property);

        if (false === method_exists($this, $setterMethod)) {
            throw new LogicException(
                'Could not set the property "%s" in class "%s" using the setter method "%s" as it does not exist.',
                LogicException::CODE_INVALID_ARGS, null, null, $property, get_class($this), $setterMethod
            );
        }

        try {
            $this->$setterMethod($value);
        } catch (\Exception $e) {
            throw new LogicException(
                'Could not set the property "%s" in class "%s" using the setter method "%s": %s.',
                LogicException::CODE_INVALID_ARGS, null, null, $property, get_class($this), $setterMethod, $e->getMessage()
            );
        }
    }

    /**
     * Get the setter method name for a property given its name. By default this simply prefixes the property with
     * the word 'set' and upper-cases the first letter of the property name. Assumes the property name and setter name
     * employ the camel case naming conventions. Overwrite using your own implementation if required.
     *
     * @param string $property
     *
     * @return string
     */
    protected function getSetterMethodNameForPropertyName($property)
    {
        return (string) 'set'.ucfirst((string) $property);
    }

    /**
     * Validates an array as being a hash and not an indexed array.
     *
     * @param array $collection
     *
     * @return bool
     */
    private function isValidHashArrayMap(array $collection)
    {
        try {
            if (true === empty($collection) || false === Arrays::isHash($collection)) {

                return false;
            }
        } catch (RuntimeException $e) {

            return false;
        }

        return true;
    }
}

/* EOF */
