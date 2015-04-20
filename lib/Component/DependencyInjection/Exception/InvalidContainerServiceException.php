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

/**
 * Class InvalidContainerServiceException.
 */
class InvalidContainerServiceException extends ContainerException
{
    /**
     * Get the default exception message.
     *
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_CONTAINER_INVALID_SERVICE;
    }
}

/* EOF */
