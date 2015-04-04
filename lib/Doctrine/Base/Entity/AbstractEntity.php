<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Entity;

use Scribe\Doctrine\Base\Entity\Castable\EntityCastableInterface;
use Scribe\Doctrine\Base\Entity\Castable\EntityCastableTrait;
use Scribe\Doctrine\Base\Entity\Debuggable\EntityDebuggableInterface;
use Scribe\Doctrine\Base\Entity\Debuggable\EntityDebuggableTrait;
use Scribe\Doctrine\Base\Entity\Equatable\EntityEquatableInterface;
use Scribe\Doctrine\Base\Entity\Equatable\EntityEquatableTrait;
use Scribe\Doctrine\Base\Entity\Initializable\EntityInitializableInterface;
use Scribe\Doctrine\Base\Entity\Initializable\EntityInitializableTrait;
use Scribe\Doctrine\Base\Entity\Lifecycleable\EntityLifecycleableInterface;
use Scribe\Doctrine\Base\Entity\Lifecycleable\EntityLifecycleableTrait;
use Scribe\Doctrine\Base\Entity\Serializable\EntitySerializableInterface;
use Scribe\Doctrine\Base\Entity\Serializable\EntitySerializableTrait;
use Scribe\Doctrine\Base\Model\HasId;
use Scribe\Doctrine\Exception\ORMException;

/**
 * Class Entity.
 */
abstract class AbstractEntity implements
    EntityCastableInterface, EntityDebuggableInterface, EntityEquatableInterface, EntitySerializableInterface,
    EntityLifecycleableInterface, EntityInitializableInterface
{
    use HasId,
        EntityCastableTrait,
        EntityDebuggableTrait,
        EntityEquatableTrait,
        EntitySerializableTrait,
        EntityLifecycleableTrait,
        EntityInitializableTrait;

    /**
     * Calls the initializer methods. Be sure to call parent constructors in your entity inheritance.
     */
    public function __construct()
    {
        $this->callInitializationMethods();
    }

    /**
     * Will trigger (throw) an ORM error from within an entity. Intended to ensure all exceptions throw
     * by an entity will inherit from our base ORMException class.
     *
     * @param ORMException $e
     *
     * @throws ORMException
     */
    final protected function triggerError(ORMException $e)
    {
        throw $e;
    }
}

/* EOF */
