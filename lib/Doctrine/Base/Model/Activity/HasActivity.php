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

use Scribe\Doctrine\Base\Model\Description\HasDescription;
use Scribe\Doctrine\Base\Model\Type\HasType;

/**
 * Class HasActivity.
 */
trait HasActivity
{
    use HasType,
        HasDescription;
}

/* EOF */
