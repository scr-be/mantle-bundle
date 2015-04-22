<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Exception;

/**
 * Class SubscriberEventORMException.
 */
class SubscriberEventORMException extends ORMException
{
    /**
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_ORM_SUBSCRIBER_EVENT;
    }

    /**
     * @return int
     */
    public function getDefaultCode()
    {
        return self::CODE_ORM_SUBSCRIBER_EVENT;
    }
}

/* EOF */
