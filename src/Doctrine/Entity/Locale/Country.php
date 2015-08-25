<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Locale;

use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasCode;
use Scribe\Doctrine\Base\Model\Name\HasName;

/**
 * Class Country;
 */
class Country extends AbstractEntity
{
    use HasName;
    use HasCode;
}

/* EOF */
