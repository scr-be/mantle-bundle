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

use Scribe\Exception\Exception;

/**
 * Class ControllerException.
 */
class ControllerException extends Exception
{
    /**
     * @var string
     */
    const MSG_CONTROLLER_GENERAL = 'An unknown controller-related error occurred.';

    /**
     * @var string
     */
    const MSG_CONTROLLER_RUNTIME = 'A controller runtime error occurred: "%s".';

    /**
     * @var string
     */
    const MSG_CONTROLLER_INVALID_MAGIC_CALL = 'While attempting to invoke __call in "%s" the requested method "%s" could not be found.';

    /**
     * @var string
     */
    const MSG_CONTROLLER_INVALID_ARGUMENT = 'An invalid argument type or count was provided in "%s" to "%s": %s.';

    /**
     * Get the default exception message.
     *
     * @return string
     */
    public function getDefaultMessage()
    {
        return self::MSG_CONTROLLER_GENERAL;
    }
}

/* EOF */
