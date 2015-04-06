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

use Scribe\Doctrine\Exception\EntityDataStateORMException;
use Scribe\Doctrine\Exception\ORMExceptionInterface;

/**
 * Trait EntityCastableTrait
 * Enable casting entity to string.
 */
trait EntityCastableTrait
{
    /**
     * Support for explicit/implicit casting from object to string. This function should be explicitly implemented
     * in each entity, though a default implementation has been provided.
     *
     * @throws EntityDataStateORMException If current entity does not have a valid id value.
     *
     * @return string
     */
    public function __toString()
    {
        if (false === method_exists($this, 'id') || false !== empty($this->getId()) || null === $this->getId()) {
            throw new EntityDataStateORMException(
                'Cast to string using default implementation failed as current entity does not have an "id" property.',
                ORMExceptionInterface::CODE_GENERIC_FROM_MANTLE_LIB
            );
        }

        return (string) (get_class($this).':'.$this->getId());
    }

    /**
     * Support for explicit casting from object to array.
     *
     * @return array
     */
    public function __toArray()
    {
        return (array) array_merge(
            ['properties' => get_class_vars($this)],
            ['methods'    => get_class_methods($this)]
        );
    }
}

/* EOF */
