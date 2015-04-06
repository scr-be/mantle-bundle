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
 * Class ORMException.
 */
class ORMException extends \Doctrine\ORM\ORMException implements ORMExceptionInterface
{
    /**
     * Optional array of additional attributes to pass to exception.
     *
     * @var array
     */
    protected $attributes;

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
    public function __construct($message = null, $code = null, \Exception $previous = null, array $attributes = null, ...$sprintfArgs)
    {
        $message    = (string) (null === $message ? ORMExceptionInterface::MSG_GENERIC : $message);
        $code       = (int) (null === $code ? ORMExceptionInterface::CODE_GENERIC : $code);
        $attributes = (array) (null === $attributes ? [] : $attributes);

        $this->attributes = $attributes;

        if (true === (count($sprintfArgs) > 0)) {
            $message = sprintf($message, ...$sprintfArgs);
        }

        parent::__construct($message, $code, $previous);
    }

    /**
     * Output string representation of exception with general, entity, and trace included.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) print_r($this->getDebugOutput(), true);
    }

    /**
     * Returns the attributes array.
     *
     * @return array
     */
    public function getAttributes()
    {
        return (array) $this->attributes;
    }

    /**
     * Returns the exception information (with all debug information) as an array.
     *
     * @return array
     */
    public function getDebugOutput()
    {
        return (array) [
            'Exception'   => get_class($this),
            'Message'     => $this->getMessage(),
            'Code'        => $this->getCode(),
            'Attributes'  => $this->getAttributes(),
            'File Name'   => $this->getFile(),
            'File Line'   => $this->getLine(),
            'Trace-back'  => $this->getTrace(),
        ];
    }
}

/* EOF */
