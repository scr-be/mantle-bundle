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

/**
 * Trait EntityCastableTrait
 * Enable casting entity to string.
 */
interface EntityCastableInterface
{
    /**
     * Support for casting from object type to string type must be implemented
     * in all classes inheriting from this base-class.
     *
     * @return string
     */
    public function __toString();
}

/* EOF */
