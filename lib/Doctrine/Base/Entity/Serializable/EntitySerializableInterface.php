<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Entity\Serializable;

/**
 * Interface EntitySerializableInterface.
 *
 * Allows an entity to be serialized.
 */
interface EntitySerializableInterface extends \Serializable
{
    /*
     * PHP's build-in \Serializable interface already defines the only
     * interface we need.
     */
}

/* EOF */
