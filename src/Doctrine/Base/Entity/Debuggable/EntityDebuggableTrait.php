<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Entity\Debuggable;

use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;

/**
 * Trait EntityDebuggable
 * Provides basic functionality to utilize {@see var_dump()} on an entity that
 * would otherwise recurse into Symfony's DI component and become useless.
 */
trait EntityDebuggableTrait
{
    /**
     * Support standardized and extended output when object instance is passed
     * to {@see var_dump()}, including class name, parent name (if applicable),
     * and a list of properties and methods.
     *
     * @return array
     */
    public function __debugInfo()
    {
        $self = __CLASS__;
        $parent = get_parent_class($this);
        $properties = get_object_vars($this);
        $methods = get_class_methods($self);

        return [
            'self' => $self,
            'parent' => $parent,
            'properties' => $properties,
            'methods' => $methods,
        ];
    }

    /**
     * Provides output of {@see __debugInfo()} as string instead of array.
     *
     * @return string
     */
    public function __debugInfoToString()
    {
        $debug = $this->__debugInfo();

        array_walk($debug['properties'], function (&$property, $index) {
            $stringProperty = $index.':'.gettype($property).':';
            if (is_array($property)) {
                $stringProperty .= '['.implode('|', $property).']';
            } elseif ($property instanceof AbstractEntity) {
                $stringProperty .= '('.$property->__debugInfoToString().')';
            } else {
                $stringProperty .= (string) $property;
            }
            $property = $stringProperty;
        });

        $string = '{self} '.$debug['self'].'; '.
                  '{parent} '.$debug['parent'].'; '.
                  '{properties} '.implode(',', $debug['properties']).'; '.
                  '{methods}'.implode(',', $debug['methods']).';';

        return $string;
    }
}

/* EOF */
