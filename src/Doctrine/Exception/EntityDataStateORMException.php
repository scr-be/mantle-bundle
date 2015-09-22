<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Exception;

/**
 * Class EntityDataStateORMException.
 */
class EntityDataStateORMException extends ORMException
{
    /**
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_ORM_STATE_DATA_GENERIC;
    }

    /**
     * @return int
     */
    public function getDefaultCode()
    {
        return self::CODE_ORM_STATE_DATA_GENERIC;
    }
}

/* EOF */
