<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\Controller\Exception;

use Scribe\Wonka\Exception\LogicException;
use Scribe\WonkaBundle\Component\DependencyInjection\Exception\Model\ControllerExceptionInterface;

/**
 * Class InvalidArgumentControllerException.
 */
class InvalidArgumentControllerException extends LogicException implements ControllerExceptionInterface
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
