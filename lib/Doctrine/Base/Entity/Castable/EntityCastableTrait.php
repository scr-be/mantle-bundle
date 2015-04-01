<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Entity\Castable;

/**
 * Trait EntityCastableTrait
 * Enable casting entity to string.
 */
trait EntityCastableTrait
{
    /**
     * Support for casting from object type to string type must be implemented
     * in all classes inheriting from this base-class.
     *
     * @return string
     */
    abstract public function __toString();

    /**
     * Support for explicit casting from object type to array type
     *
     * @return array
     */
    public function __toArray()
    {
        return (array) get_object_vars($this);
    }
}

/* EOF */
