<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection\Exception;

use Scribe\Exception\Exception;

/**
 * Class ContainerException.
 */
class ContainerException extends Exception
{
    /**
     * @var string
     */
    const MSG_CONTAINER_GENERAL = 'An unknown container-related error occurred.';

    /**
     * @var string
     */
    const MSG_CONTAINER_INVALID_PARAMETER = 'The requested container parameter "%s" could not be found.';

    /**
     * @var string
     */
    const MSG_CONTAINER_INVALID_SERVICE = 'The requested container service "%s" could not be found.';

    /**
     * Get the default exception message.
     *
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_CONTAINER_GENERAL;
    }
}

/* EOF */
