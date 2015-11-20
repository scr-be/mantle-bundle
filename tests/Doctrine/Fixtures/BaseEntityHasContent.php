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
use Scribe\MantleBundle\Doctrine\Base\Model\HasContent;

/**
 * BaseEntityHasContent.
 */
class BaseEntityHasContent extends IdEntity
{
    use HasContent;
}

/* EOF */
