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
use Scribe\Doctrine\Exception\OrmException;

/**
 * Class Entity.
 *
 * @package Scribe\Entity
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
     * Trigger an ORM entity error by passing a valid ORMException
     *
     * @param ORMException $e
     *
     * @throws OrmException
     */
    final protected function triggerError(ORMException $e)
    {
        throw $e;
    }
}

/* EOF */
