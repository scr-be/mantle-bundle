<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Entity\Serializable;

/**
 * Interface EntitySerializableInterface.
 *
 * Allows an entity to be serialized.
 */
interface EntitySerializableInterface extends \Serializable
{
    /**
     * Clone is used internally by Doctrine prior to an entity obtaining an id;
     * therefore this method should be called within any __clone implementation
     * to determine if it is safe to implement custom logic.
     *
     * @return bool
     */
    public function isCloneSafe();
}

/* EOF */
