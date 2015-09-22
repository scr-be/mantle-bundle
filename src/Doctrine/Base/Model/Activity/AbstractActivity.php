<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Activity;

use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Description\HasDescription;
use Scribe\MantleBundle\Doctrine\Base\Model\Type\HasType;
use Scribe\MantleBundle\Doctrine\Behavior\Model\Timestampable\TimestampableBehaviorTrait;

/**
 * Class AbstractActivity.
 */
abstract class AbstractActivity extends AbstractEntity implements ActivityInterface
{
    use HasType;
    use HasDescription;
    use TimestampableBehaviorTrait;
}

/* EOF */
