<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity\Interfaces;

use Scribe\MantleBundle\Entity\Base\Entity;

/**
 * Interface EntityEquatableInterface
 * Used to test if two objects are equal in orm and entity contexts.
 *
 * @package Scribe\MantleBundle\Entity\Interfaces
 */
interface EntityEquatableInterface
{
    /**
     * Simple check to see if the passed Entity is of the same type as the
     * current object using {@see get_class()} or a similar method.
     *
     * @param  Entity $entity the entity object to check against
     * @return bool
     */
    public function isEqualTo(Entity $entity);

    /**
     * Check to see if the passed Entity object has the same orm-specified
     * {@see $this->id} value as the current object. This should not allow a
     * comparison of two null id values to return true.
     *
     * @param  Entity $entity the entity object to check against
     * @return bool
     */
    public function isEqualToId(Entity $entity);

    /**
     * Check to see if the passed Entity object has the same property values
     * as the current object. This includes id, as well as all other class
     * properties.
     *
     * @param  Entity $entity the entity object to check against
     * @return bool
     */
    public function isEqualToProperties(Entity $entity);
}
