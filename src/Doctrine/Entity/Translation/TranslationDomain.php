<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Translation;

use Scribe\Doctrine\ORM\Mapping\SlugEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Description\HasDescription;

/**
 * Class TranslationDomain.
 */
class TranslationDomain extends SlugEntity
{
    use HasDescription;

    /**
     * @var string
     */
    const VERSION = '0.1.0';
}

/* EOF */
