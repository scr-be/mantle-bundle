<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Entity\Exception;

use Scribe\SharedBundle\Entity\Template\Entity;

/**
 * Class OrmExceptionInterface
 *
 * @package Scribe\SharedBundle\Entity\Exception
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
