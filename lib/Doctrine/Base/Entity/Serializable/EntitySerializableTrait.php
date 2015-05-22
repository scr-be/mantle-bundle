<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Entity\Serializable;

use Scribe\Utility\Serializer\Serializer;

/**
 * Class EntitySerializable
 * Provides basic serializable functionality for any entity that extends from it.
 */
trait EntitySerializableTrait
{
    /**
     * @return int|null
     */
    abstract public function getId();

    /**
     * Clone is used internally by Doctrine prior to an entity obtaining an id;
     * therefore this method should be called within any __clone implementation
     * to determine if it is safe to implement custom logic.
     *
     * @return bool
     */
    final public function isCloneSafe()
    {
        if ($this->getId()) {
            return true;
        }

        return false;
    }

    /**
     * To serialize object, get its properties or, if it has none, provide an
     * empty array to pass to the serialize function, which then returns its
     * output.
     *
     * @return string
     */
    public function serialize()
    {
        return Serializer::sleep(get_object_vars($this));
    }

    /**
     * To unserialize object, take the passed serialized string and unserialize
     * it, after which each key=>value pair of the returned array is assigned
     * back as propertyName=>value within the class.
     *
     * @param string $serialized serialized object properties
     *
     * @return array
     */
    public function unserialize($serialized)
    {
        $properties = (array) Serializer::wake($serialized);

        foreach ($properties as $property => $value) {
            $this->$property = $value;
        }

        return $properties;
    }
}

/* EOF */
