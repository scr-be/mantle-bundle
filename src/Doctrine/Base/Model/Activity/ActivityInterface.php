<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Activity;

use Scribe\MantleBundle\Doctrine\Base\Model\Type\TypeInterface;
use Scribe\MantleBundle\Doctrine\Behavior\Model\Timestampable\TimestampableBehaviorInterface;

/**
 * Class ActivityInterface.
 */
interface ActivityInterface extends TypeInterface, TimestampableBehaviorInterface
{
}

/* EOF */
