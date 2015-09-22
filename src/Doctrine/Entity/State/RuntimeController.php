<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\State;

use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Description\HasDescription;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;

/**
 * Class RuntimeController
 */
class RuntimeController extends AbstractEntity
{
    use HasName;
    use HasDescription;
}

/* EOF */
