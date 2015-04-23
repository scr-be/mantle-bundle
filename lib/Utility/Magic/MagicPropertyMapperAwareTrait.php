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
     * Maps an array hash consisting of the property names for indexes and property values as the corresponding values
     * and directly maps them to the property.
     *
     * @param array $propertyHash
     */
    protected function mapHashToPropertiesByAssignment(array $propertyHash = [])
    {
        if (false === $this->isValidHashArrayMap($propertyHash)) {
            return;
        }

        foreach ($propertyHash as $property => $value) {
            $this->setPropertyByAssignment((string) $property, $value);
        }
    }

    /**
     * Sets a property by its name to the provided value. Ensures the property exists and is accessible.
     *
     * @param string $property
     * @param mixed  $value
     *
     * @throws LogicException
     */
    private function setPropertyByAssignment($property, $value)
    {
        if (false === property_exists($this, $property)) {
            throw new LogicException(
                'Could not set the property "%s" in class "%s" using direct assignment as it does not exist.',
                LogicException::CODE_INVALID_ARGS, null, null, $property, get_class($this)
            );
        }

        try {
            $this->$property = $value;
        } catch (\Exception $e) {
            throw new LogicException(
                'Could not set the property "%s" in class "%s" using direct assignment: %e.',
                LogicException::CODE_INVALID_ARGS, $e, null, $property, get_class($this), $e->getMessage()
            );
        }
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
     * employ the camel case naming conventions.
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
