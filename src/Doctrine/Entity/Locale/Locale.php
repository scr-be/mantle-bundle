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

use Scribe\Doctrine\ORM\Mapping\SlugEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Locale\HasCountry;
use Scribe\MantleBundle\Doctrine\Base\Model\HasLanguage;

/**
 * Class Locale
 */
class Locale extends SlugEntity
{
    use HasLanguage;
    use HasCountry;

    /**
     * @var string
     */
    const VERSION = '0.1.0';
}

/* EOF */
