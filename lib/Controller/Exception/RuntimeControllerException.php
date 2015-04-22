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

use Scribe\Exception\RuntimeException;
use Scribe\Component\DependencyInjection\Exception\Model\ControllerExceptionInterface;

/**
 * Class RuntimeControllerException.
 */
class RuntimeControllerException extends RuntimeException implements ControllerExceptionInterface
{
    /**
     * Get the default exception message.
     *
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_CONTROLLER_RUNTIME;
    }
}

/* EOF */
