<?php
/*
 * This file is part of the Scribe Foundation Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\StaticClass;

use Scribe\Exception\RuntimeException;

/**
 * StaticClassTrait
 * Trait that disallows class instantiation by throwing an exception within the constructor
 *
 * @package Scribe\Utility\StaticClass
 */
trait StaticClassTrait
{
    /**
     * Disallow class instantiation by issueing an exception for classes with only static methods
     *
     * @param mixed $values,... Any values that may be passed are ignored.
     */
    final public function __construct(...$values)
    {
        throw new RuntimeException(
            sprintf('Cannot instantiate static class %s.', get_class($this))
        );
    }
}
