<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\InstantMessenger;

use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\Name\HasName;
use Scribe\Doctrine\Base\Model\Type\HasType;

/**
 * Class AbstractInstantMessenger.
 */
abstract class AbstractInstantMessenger extends AbstractEntity implements InstantMessengerInterface
{
    use HasName,
        HasType,
        HasInstantMessenger;
}

/* EOF */
