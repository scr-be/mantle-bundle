<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model;

use Scribe\MantleBundle\Doctrine\Base\Model\Locale\HasCountry as HasLocaleCountry;

/**
 * Class HasCountry.
 *
 * @deprecated Use Scribe\MantleBundle\Doctrine\Base\Model\Locale\HasCountry
 */
trait HasCountry
{
    use HasLocaleCountry;
}

/* EOF */
