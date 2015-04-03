<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Entity\Equatable;

use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Interface EntityEquatableInterface
 * Used to test if two objects are equal in orm and entity contexts.
 */
interface EntityEquatableInterface
{
    /**
     * Simple check to see if the passed Entity is of the same type as the
     * current object using {@see get_class()} or a similar method.
     *
     * @param AbstractEntity $entity the entity object to check against
     * @param bool           $strict should the entity id be compared or not
     *
     * @return bool
     */
    public function isEqualTo(AbstractEntity $entity, $strict = true);

    /**
     * Check to see if the passed Entity object has the same orm-specified
     * {@see $this->id} value as the current object. This should not allow a
     * comparison of two null id values to return true.
     *
     * @param AbstractEntity $entity the entity object to check against
     *
     * @return bool
     */
    public function isEqualToId(AbstractEntity $entity);

    /**
     * Check to see if the passed Entity object has the same property values
     * as the current object. This includes id, as well as all other class
     * properties.
     *
     * @param AbstractEntity $entity the entity object to check against
     *
     * @return bool
     */
    public function isEqualToProperties(AbstractEntity $entity);
}

/* EOF */
