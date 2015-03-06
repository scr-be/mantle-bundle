<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity\Exception;

use Scribe\MantleBundle\Entity\Template\Entity;

/**
 * Class OrmExceptionInterface
 *
 * @package Scribe\MantleBundle\Entity\Exception
 */
interface OrmExceptionInterface
{
    /**
     * Returns entity object
     *
     * @return Entity
     */
    public function getEntity();

    /**
     * Returns entity debug output array
     *
     * @return array
     */
    public function getEntityDebugArray();
}

/* EOF */
