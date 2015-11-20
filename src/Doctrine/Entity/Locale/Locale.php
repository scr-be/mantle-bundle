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

use Scribe\Doctrine\ORM\Mapping\IdEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;
use Scribe\MantleBundle\Doctrine\Base\Model\HasCountry;
use Scribe\MantleBundle\Doctrine\Base\Model\HasLanguage;

/**
 * Class Locale
 */
class Locale extends IdEntity
{
    use HasName;
    use HasLanguage;
    use HasCountry;
}

/* EOF */
