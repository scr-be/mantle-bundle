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
     * @return null|int
     */
    abstract public function getId();

    /**
     * Support for explicit/implicit casting from object to string. This function should be explicitly implemented
     * in each entity, though a default implementation has been provided.
     *
     * @return string
     */
    public function __toString()
    {
        if (false === method_exists($this, 'getId') || false !== empty($this->getId()) || null === $this->getId()) {
            $id = 'unknown-id';
        } else {
            $id = $this->getId();
        }

        return (string) (get_class($this).':'.$id);
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
