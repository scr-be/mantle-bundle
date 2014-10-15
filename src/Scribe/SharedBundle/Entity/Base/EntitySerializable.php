<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Base;

/**
 * Class EntitySerializable
 * Provides basic serializable functionality for any entity that extends from it
 *
 * @package Scribe\SharedBundle\Entity\Base
 */
trait EntitySerializable
{
    /**
     * Clone is used internally by Doctrine, so by defining this as final no
     * entities that inherit from this class can define their own
     * interpretation.
     */
    final public function __clone() {}

    /**
     * To serialize object, get its properties or, if it has none, provide an
     * empty array to pass to the serialize function, which then returns its
     * output.
     *
     * @return string
     */
    public function serialize()
    {
        $properties = get_object_vars($this);

        if (!is_array($properties)) {
            $properties = [ ];
        }

        return serialize($properties);
    }

    /**
     * To unserialize object, take the passed serialized string and unserialize
     * it, after which each key=>value pair of the returned array is assigned
     * back as propertyName=>value within the class.
     *
     * @param  string $serialized serialized object properties
     * @return array
     */
    public function unserialize($serialized)
    {
        $properties = unserialize($serialized);

        foreach ($properties as $property => $value) {
            $this->$property = $value;
        }

        return $properties;
    }
}
