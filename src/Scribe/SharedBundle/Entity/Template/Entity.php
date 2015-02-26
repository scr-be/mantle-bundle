<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Template;

use Serializable;
use Scribe\SharedBundle\Entity\Interfaces\EntityInterface;

/**
 * Class Entity
 *
 * @package Scribe\SharedBundle\Entity\Template
 */
abstract class Entity implements EntityInterface, Serializable
{
    /**
     * entity id
     *
     * @var id
     */
    protected $id;

    /**
     * set the default value for entity id
     */
    public function __construct()
    {
        $this->id = null;
    }

    /**
     * Support for casting from object type to string type must be implemented
     * in all classes inheriting from this base-class
     * @return string
     */
    abstract public function __toString();

    /**
     * Support standardized and extended output when object instance is passed
     * to {@see var_dump()}, including class name, parent name (if applicable),
     * and a list of properties and methods
     *
     * @return array
     */
    public function __debugInfo()
    {
        $self       = __CLASS__;
        $parent     = get_parent_class($this);
        $properties = get_object_vars($this);
        $methods    = get_class_methods($self);

        if ($parent === false) {
            $parent = '';
        }
        if (!is_array($properties)) {
            $properties = [ ];
        }
        if (!is_array($methods)) {
            $method = [ ];
        }

        return [
            'self'       => $self,
            'parent'     => $parent,
            'properties' => $properties,
            'methods'    => $methods,
        ];
    }

    /**
     * return entity id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Perform check to determining if the passed entity instance is equal
     * to self object instance
     *
     * @param EntityInterface $entity entity to test against
     * @param bool            $strict should the entity id be compared or not
     * @return boolean
     */
    public function isEqualTo(EntityInterface $entity, $strict = true)
    {
        if ($strict === false) {
            return (bool)$this == $entity;
        }

        return (bool)$this === $entity;
    }

    /**
     * Implement serialize routine to support {@see Serializable} interface
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
     * Implement un-serialize routine to support {@see Serializable} interface
     *
     * @param string $serialized serialized object string
     */
    public function unserialize($serialized)
    {
        $properties = unserialize($serialized);

        foreach ($properties as $property => $value) {
            $this->$property = $value;
        }
    }
}
