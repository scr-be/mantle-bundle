<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Serializer;

use Scribe\Utility\StaticClass\StaticClassTrait;

/**
 * Class AbstractSerializer.
 */
abstract class AbstractSerializer implements SerializerInterface
{
    /*
     * Trait to disallow class instantiation
     */
    use StaticClassTrait;
}
