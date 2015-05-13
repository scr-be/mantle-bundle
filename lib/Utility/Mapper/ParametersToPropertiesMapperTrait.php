<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Mapper;

use Scribe\Exception\LogicException;
use Scribe\Exception\RuntimeException;
use Scribe\Utility\Arrays;

/**
 * Trait MagicPropertyMapperAwareTrait
 *
 * Allows for quick mapping of any indexed or hashed array of values to properties within a class.
 */
trait ParametersToPropertiesMapperTrait
{
    /**
     * Ingests one or more associative arrays (passed as parameters to this method---unlimited in number as method
     * definition is variadic---and maps them to properties of an object utalizing this trait. The format of the
     * associative arrays must be ['propertyNameFoo' => 'propertyValueFoo', 'propertyNameBar' => 'propertyValueBar, ...]
     * where the index is a string whos name directly maps to a object property.
     *
     * Do note that any array keys that exist in multiple method parameter arrays will be overridden by the last
     * definition of that key value.
     *
     * @param array[] $parameters
     *
     * @return $this
     */
    protected function assignPropertyCollectionToSelf(array ...$parameters)
    {
        $assignmentCollection = (array) $this->normalizeCollectionParametersForSelf(
            $parameters,
            [$this, 'filterPropertyAssignmentsForSelf']
        );

        if (0 === count($assignmentCollection)) {
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
     * @internal
     *
     * @param array $assignmentCollection
     *
     * @return array
     */
    final private function filterPropertyAssignmentsForSelf(array $assignmentCollection, array $objectProperties = [])
    {
        if (false === Arrays::isHash($assignmentCollection)) {
            return [];
        }

        $objectProperties = get_object_vars($this);

        return (array) array_filter($assignmentCollection, function($property) use ($objectProperties) {
            return (bool) in_array($property, $objectProperties, false);
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
     * @internal
     *
     * @param array                  $parameters
     * @param \Closure|callable|null $assignmentCollectionFilter
     *
     * @return array
     */
    final private function normalizeCollectionParametersForSelf(array $parameters, callable $assignmentCollectionFilter = null)
    {
        $assignmentCollectionMerged = [];

        if (0 === count($parameters)) {
            return $assignmentCollectionMerged;
        }

        if (null === $assignmentCollectionFilter) {
            $assignmentCollectionFilter = function($collection) { return $collection; };
        }

        foreach ($parameters as $assignmentCollection) {
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
     * @internal
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
}

/* EOF */
