<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Model\Phone;

use Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity;
use Scribe\MantleBundle\Doctrine\Base\Model\Name\HasName;
use Scribe\MantleBundle\Doctrine\Base\Model\Type\HasType;

/**
 * Class AbstractPhone.
 */
abstract class AbstractPhone extends AbstractEntity implements PhoneInterface
{
    use HasName;
    use HasType;
    use HasPhone;
}

/* EOF */
