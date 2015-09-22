<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Entity\Serializable;

use Doctrine\ORM\PersistentCollection;
use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;
use Scribe\MantleBundle\Component\Security\Core\UserInterface;
use Scribe\Wonka\Utility\Serializer\Serializer;
use Symfony\Component\Validator\Constraints\All;

/**
 * Class EntitySerializable
 *
 * Provides basic serializable functionality for any entity that extends from it.
 */
trait EntitySerializableTrait
{
    /**
     * Simple array of property names to include in serialization of entity.
     *
     * @var string[]
     */
    private $serializablePropertyCollection = ['id'];

    /**
     * Sets (overwriting) the array of property names to serialize.
     *
     * @param string $propertyNames
     *
     * @return $this
     */
    public function setSerializablePropertyCollection(...$propertyNames)
    {
        $this->serializablePropertyCollection = $propertyNames;

        return $this;
    }

    /**
     * Add a property you would like serialized to the collection.
     *
     * @param string $property
     *
     * @return $this
     */
    public function addSerializableProperty($property)
    {
        $this->serializablePropertyCollection[] = (string) $property;

        return $this;
    }

    /**
     * Basic support for serialization based on a user-assignable collection of property names.
     *
     * @return string
     */
    public function serialize()
    {
        $serializable = $this->serializablePropertyCollection;

        if ($this instanceof UserInterface && false === in_array('id', $serializable, true)) {
            $serializable[] = 'id';
        }

        $canonicalized = [];
        array_walk($serializable, function ($value) use (&$canonicalized) {
            if (true === property_exists($this, $value)) {
                $canonicalized[$value] = $this->$value;
            }
        });

        return Serializer::sleep($canonicalized);
    }

    /**
     * Basic implementation of un-serializing a collection of key -> value pairs back into the object.
     *
     * @param string $serialized Serialized property collection.
     *
     * @return array
     */
    public function unserialize($serialized)
    {
        $unSerializable = (array) Serializer::wake($serialized);

        foreach ($unSerializable as $property => $value) {
            $this->$property = $value;
        }

        return $unSerializable;
    }
}

/* EOF */
