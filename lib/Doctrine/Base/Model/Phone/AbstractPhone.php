<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\Phone;

use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasName;
use Scribe\Doctrine\Base\Model\Type\HasType;

/**
 * Class AbstractPhone.
 */
abstract class AbstractPhone extends AbstractEntity
{
    use HasName,
        HasType,
        HasPhone;
}

/* EOF */
