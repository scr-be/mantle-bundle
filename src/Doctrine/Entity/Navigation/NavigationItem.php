<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Navigation;

use Scribe\Doctrine\Base\Entity\AbstractEntity;
use Scribe\Doctrine\Base\Model\HasDescription;
use Scribe\Doctrine\Base\Model\HasTitle;

/**
 * Class NavigationItem.
 */
class NavigationItem extends AbstractEntity
{
    use HasTitle,
        HasDescription;

    /**
     * Support casting to string
     *
     * @return string
     */
    public function __toString()
    {
        return (string) (__CLASS__.':'.$this->getId());
    }
}

/* EOF */
