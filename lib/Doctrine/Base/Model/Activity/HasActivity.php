<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Model\Activity;

use Scribe\Doctrine\Base\Model\HasCode;
use Scribe\Doctrine\Base\Model\HasProperties;
use Scribe\Doctrine\Base\Model\Type\HasType;
use Scribe\Doctrine\Base\Model\User\HasUser;

/**
 * Class HasActivity.
 */
trait HasActivity
{
    use HasCode,
        HasType,
        HasUser,
        HasProperties;
}

/* EOF */
