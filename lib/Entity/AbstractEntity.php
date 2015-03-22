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

use Scribe\EntityTrait\HasId;

/**
 * Class Entity
 *
 * @package Scribe\Entity
 */
abstract class AbstractEntity implements
    EntityInterface, EntityCastableInterface, EntityDebuggableInterface, EntityEquatableInterface,
    EntitySerializableInterface
{
    use HasId,
        EntityCastableTrait,
        EntityDebuggableTrait,
        EntityEquatableTrait,
        EntitySerializableTrait;

    /**
     * set the default value for entity id
     */
    public function __construct()
    {
        $this->initId();
    }
}

/* EOF */
