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
 * Interface ORMExceptionInterface.
 */
interface ORMExceptionInterface
{
    /**
     * Generic exception message. Should be avoided.
     *
     * @var string
     */
    const MSG_GENERIC = 'An undefined exception was thrown.';

    /**
     * Generic exception code for...absolutely generic, unspecified exceptions.
     *
     * @var int
     */
    const CODE_GENERIC = -1;

    /**
     * Generic exception code for exceptions thrown from within Mantle library.
     *
     * @var int
     */
    const CODE_GENERIC_FROM_MANTLE_LIB = 1000;

    /**
     * Generic exception code for exceptions thrown from within Mantle bundle.
     *
     * @var int
     */
    const CODE_GENERIC_FROM_MANTLE_BDL = 2000;

    /**
     * Constructor initializes exception arguments.
     *
     * @param string|null     $message     An error message string (optionally fed to sprintf if optional args are given)
     * @param int             $code        The error code (which should be from ORMExceptionInterface). If null, the value
     *                                     of ORMExceptionInterface::CODE_GENERIC will be used.
     * @param \Exception|null $previous    The previous exception (when re-thrown within another exception), if applicable.
     * @param array|null      $attributes  An optional array of attributes to pass. Will be provided in the debug output.
     * @param ...mixed        $sprintfArgs If additional arguments are provided, the string will be parsed using sprintf
     *                                     with the additional parameters provided as arguments to the function.
     */
    public function __construct($message = null, $code = null, \Exception $previous = null, array $attributes = null, ...$sprintfArgs);

    /**
     * Output string representation of exception with general, entity, and trace included.
     *
     * @return string
     */
    public function __toString();

    /**
     * Returns the attributes array.
     *
     * @return array
     */
    public function getAttributes();

    /**
     * Returns the exception information (with all debug information) as an array.
     *
     * @return array
     */
    public function getDebugOutput();
}

/* EOF */
