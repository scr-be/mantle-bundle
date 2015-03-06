<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity\Base;

use Scribe\MantleBundle\Entity\Interfaces\EntityInterface;
use Scribe\MantleBundle\Entity\Interfaces\EntityDebuggableInterface;
use Scribe\MantleBundle\Entity\Interfaces\EntityEquatableInterface;
use Scribe\MantleBundle\Entity\Template\HasId_AsInt;
use Serializable;

/**
 * Class Entity
 *
 * @package Scribe\MantleBundle\Entity\Base
 */
abstract class Entity implements
    EntityInterface, EntityDebuggableInterface,
    EntityEquatableInterface, Serializable
{
    use EntityDebuggable,
        EntityEquatable,
        EntitySerializable,
        HasId_AsInt;

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
}

/* EOF */
