<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Doctrine\Fixtures;

use Scribe\Doctrine\ORM\Mapping\IdEntity;

/**
 * Node.
 */
class BaseEntity extends IdEntity
{
    public function __toString()
    {
        return (string) __CLASS__;
    }
}

/* EOF */
