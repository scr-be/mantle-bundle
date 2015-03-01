<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Exceptions;

/**
 * Class TemplatingGeneratorException
 *
 * @package Scribe\MantleBundle\Templating\Generator\Exceptions
 */
class TemplatingGeneratorException extends \Scribe\Exception\RuntimeException
{
    /**
     * Exception code for an unknown/undefined state
     *
     * @type int
     */
    const CODE_UNKNOWN = -1;

    /**
     * Exception code for generic invalid arguments exception
     *
     * @type int
     */
    const CODE_INVALID_ARGS = 50;

    /**
     * Exception code for an invalid style being passed by user
     *
     * @type int
     */
    const CODE_INVALID_STYLE = 51;

    /**
     * Exception code for generic missing arguments
     *
     * @type int
     */
    const CODE_MISSING_ARGS = 100;

    /**
     * Exception code for a missing entity
     *
     * @type int
     */
    const CODE_MISSING_ENTITY = 101;

    /**
     * Assign our own default code value to setup the object instance
     *
     * @param string     $message
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($message, $code = self::CODE_UNKNOWN, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

/* EOF */