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

use Scribe\SharedBundle\Entity\Interfaces\EntityInterface;
use Scribe\SharedBundle\Entity\Interfaces\EntityDebuggableInterface;
use Scribe\SharedBundle\Entity\Interfaces\EntityEquatableInterface;
use Scribe\SharedBundle\Entity\Template\HasId_AsInt;
use Serializable;

/**
 * Class Entity
 *
 * @package Scribe\SharedBundle\Entity\Base
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
