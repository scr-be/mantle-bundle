<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Entity;

use Scribe\Entity\Castable\EntityCastableInterface;
use Scribe\Entity\Castable\EntityCastableTrait;
use Scribe\Entity\Debuggable\EntityDebuggableInterface;
use Scribe\Entity\Debuggable\EntityDebuggableTrait;
use Scribe\Entity\Equatable\EntityEquatableInterface;
use Scribe\Entity\Equatable\EntityEquatableTrait;
use Scribe\Entity\Lifecycle\EntityLifecycleEventCreated;
use Scribe\Entity\Lifecycle\EntityLifecycleEventCreatedInterface;
use Scribe\Entity\Lifecycle\EntityLifecycleEventsInterface;
use Scribe\Entity\Lifecycle\EntityLifecycleEventsTrait;
use Scribe\Entity\Lifecycle\EntityLifecycleEventUpdated;
use Scribe\Entity\Lifecycle\EntityLifecycleEventUpdatedInterface;
use Scribe\Entity\Serializable\EntitySerializableInterface;
use Scribe\Entity\Serializable\EntitySerializableTrait;
use Scribe\EntityTrait\HasId;
use Scribe\MantleBundle\Entity\Exception\OrmException;

/**
 * Class Entity.
 */
abstract class AbstractEntity implements
    EntityInterface, EntityCastableInterface, EntityDebuggableInterface, EntityEquatableInterface,
    EntitySerializableInterface, EntityLifecycleEventsInterface, EntityLifecycleEventCreatedInterface,
    EntityLifecycleEventUpdatedInterface
{
    use HasId,
        EntityCastableTrait,
        EntityDebuggableTrait,
        EntityEquatableTrait,
        EntitySerializableTrait,
        EntityLifecycleEventsTrait,
        EntityLifecycleEventCreated,
        EntityLifecycleEventUpdated;

    /**
     * Construct the entity by calling all init methods. Be sure to call this in your
     * parent entity if you overwrite the constructor, otherwise your init methods
     * in your traits will not be called.
     */
    public function __construct()
    {
        $this->__callInitMethods();
    }

    /**
     * Call all initializer methods
     */
    final public function __callInitMethods()
    {
        $initMethods = array_filter(get_class_methods($this), function($method) {
            return (bool) (substr($method, 0, 6) === '__init');
        });

        foreach ($initMethods as $method) {
            $this->$method();
        }
    }

    /**
     * Throw an ORM exception if an error in processing occurs
     *
     * @param string $message
     * @param int    $code
     */
    final protected function __throwOrmException($message, $code = 0)
    {
        throw new OrmException($message, $code);
    }
}

/* EOF */
