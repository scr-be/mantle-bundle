<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Entity;

use Scribe\MantleBundle\Doctrine\Base\Entity\Castable\EntityCastableInterface;
use Scribe\MantleBundle\Doctrine\Base\Entity\Castable\EntityCastableTrait;
use Scribe\MantleBundle\Doctrine\Base\Entity\Debuggable\EntityDebuggableInterface;
use Scribe\MantleBundle\Doctrine\Base\Entity\Debuggable\EntityDebuggableTrait;
use Scribe\MantleBundle\Doctrine\Base\Entity\Equatable\EntityEquatableInterface;
use Scribe\MantleBundle\Doctrine\Base\Entity\Equatable\EntityEquatableTrait;
use Scribe\MantleBundle\Doctrine\Base\Entity\Initializable\EntityInitializableInterface;
use Scribe\MantleBundle\Doctrine\Base\Entity\Initializable\EntityInitializableTrait;
use Scribe\MantleBundle\Doctrine\Base\Entity\Lifecycleable\EntityLifecycleableInterface;
use Scribe\MantleBundle\Doctrine\Base\Entity\Lifecycleable\EntityLifecycleableTrait;
use Scribe\MantleBundle\Doctrine\Base\Entity\Serializable\EntitySerializableInterface;
use Scribe\MantleBundle\Doctrine\Base\Entity\Serializable\EntitySerializableTrait;
use Scribe\MantleBundle\Doctrine\Base\Model\HasId;
use Scribe\MantleBundle\Doctrine\Exception\ORMException;

/**
 * Class Entity.
 */
abstract class AbstractEntity implements
    EntityCastableInterface, EntityDebuggableInterface, EntityEquatableInterface, EntitySerializableInterface,
    EntityLifecycleableInterface, EntityInitializableInterface
{
    use HasId;
    use EntityCastableTrait;
    use EntityDebuggableTrait;
    use EntityEquatableTrait;
    use EntityLifecycleableTrait;
    use EntitySerializableTrait;
    use EntityInitializableTrait;

    /**
     * Calls the initializer methods. Be sure to call parent constructors in your entity inheritance.
     */
    public function __construct()
    {
        $this->callInitializationMethods();
    }

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
