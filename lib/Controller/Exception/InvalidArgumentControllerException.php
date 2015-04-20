<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Controller\Exception;

/**
 * Class InvalidArgumentControllerException.
 */
class InvalidArgumentControllerException extends ControllerException
{
    /**
     * Get the default exception message.
     *
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_CONTROLLER_INVALID_ARGUMENT;
    }
}

/* EOF */
