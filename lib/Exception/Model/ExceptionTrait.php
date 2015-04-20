<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Exception\Model;

use Scribe\Utility\ClassInfo;
use Symfony\Component\Debug\Exception\ContextErrorException;

/**
 * Class ExceptionTrait.
 */
trait ExceptionTrait
{
    /**
     * Optional array of attributes.
     *
     * @var array
     */
    protected $attributes;

    /**
     * An enhanced constructor that allows for passing the default \Exception parameters, as well as an array of additional
     * attributes followed by any number of additional arguments that will be passed to sprintf against the message.
     *
     * @param string|null  $message        An error message string (optionally fed to sprintf if optional args are given)
     * @param int|null     $code           The error code (which should be from ORMExceptionInterface). If null, the value
     *                                     of ExceptionInterface::CODE_GENERIC will be used.
     * @param mixed        $previous       The previous exception (when re-thrown within another exception), if applicable.
     * @param mixed[]|null $attributes     An optional array of attributes to pass. Will be provided in the debug output.
     * @param mixed        ...$sprintfArgs Optional additional parameters that will be passed to sprintf against the
     *                                     message string provided.
     */
    public function __construct($message = null, $code = null, $previous = null, array $attributes = null, ...$sprintfArgs)
    {
        $this
            ->setAttributes((array) $attributes)
            ->setParentArgs((string) $message, (int) $code, $previous, ...$sprintfArgs)
        ;
    }

    /**
     * Get an instance of the exception, allowing for setting the message and any substitution parameters.
     *
     * @param string|null $message
     * @param mixed       ...$sprintfArgs
     *
     * @return $this
     */
    public static function getInstance($message, ...$sprintfArgs)
    {
        return new self($message, null, null, null, ...$sprintfArgs);
    }

    /**
     * Get an instance of the exception, allowing for providing only string substitution parameters.
     *
     * @param mixed ...$sprintfArgs
     *
     * @return $this
     */
    public static function getDefaultInstance(...$sprintfArgs)
    {
        return new self(null, null, null, null, ...$sprintfArgs);
    }

    /**
     * Output string representation of exception with general, entity, and trace included.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) print_r((array) $this->getDebugOutput(), true);
    }

    /**
     * Handle any required setup of the parent class.
     *
     * @param string|null     $message
     * @param int             $code
     * @param \Exception|null $previous
     * @param mixed           ...$sprintfArgs
     *
     * @internal
     *
     * @return $this
     */
    public function setParentArgs($message, $code, $previous = null, ...$sprintfArgs)
    {
        parent::__construct(
            $this->getFinalMessage($message, ...$sprintfArgs),
            $this->getFinalCode($code),
            $this->getFinalPreviousException($previous)
        );
    }

    /**
     * Validate message by providing a default if one was not provided and optionally calling sprintf on the message
     * if arguments were passed for string replacement.
     *
     * @param null|string $message
     * @param mixed       ...$sprintfArgs
     *
     * @internal
     *
     * @return string
     */
    public function getFinalMessage($message = null, ...$sprintfArgs)
    {
        if (true === empty($message)) {
            $message = $this->getDefaultMessage();
        }

        if (true === is_array_empty($sprintfArgs)) {
            return (string) $message;
        }

        try {
            $message = sprintf($message, ...$sprintfArgs);
        } catch (ContextErrorException $e) {
            $message .= ' (Substitution values for message could not be provided.)';
        }

        return (string) $message;
    }

    /**
     * Validate code by providing a default if one was not provided.
     *
     * @param int|null $code
     *
     * @internal
     *
     * @return int
     */
    public function getFinalCode($code = null)
    {
        if (true === empty($code)) {
            return (int) $this->getDefaultCode();
        }

        return (int) $code;
    }

    /**
     * Validate previous exception by requiring it is a subclass of \Exception or returning null.
     *
     * @param mixed $exception
     *
     * @internal
     *
     * @return null|\Exception
     */
    public function getFinalPreviousException($exception = null)
    {
        if ($exception instanceof \Exception) {
            return $exception;
        }

        return null;
    }

    /**
     * Get the default exception message.
     *
     * @return string
     */
    public function getDefaultMessage()
    {
        return (string) ExceptionInterface::MSG_GENERIC;
    }

    /**
     * Get the default exception code.
     *
     * @return int
     */
    public function getDefaultCode()
    {
        return (int) ExceptionInterface::CODE_GENERIC;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes = [])
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param mixed       $attribute
     * @param null|string $key
     *
     * @return $this
     */
    public function addAttribute($attribute, $key = null)
    {
        if (null === $key) {
            $this->attributes[] = $attribute;
        } else {
            $this->attributes[(string) $key] = $attribute;
        }

        return $this;
    }

    /**
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
            'Trace-back'  => $this->getTraceLimited(),
        ];
    }

    /**
     * Get trace limited to only one object-level of depth.
     *
     * @internal
     *
     * @return array
     */
    public function getTraceLimited()
    {
        $trace = $this->getTrace();

        array_walk($trace, function (&$v, $i) {
            foreach ($v['args'] as &$arg) {
                if (is_object($arg)) {
                    $arg = get_class($arg);
                }
            }
        });

        return (array) $trace;
    }

    /**
     * Get the exception type (class name).
     *
     * @return string
     */
    public function getType()
    {
        return (string) ClassInfo::get($this, ClassInfo::CLASS_STR);
    }

    /**
     * Get the exception namespace (class namespace).
     *
     * @return string
     */
    public function getTypeNamespace()
    {
        return (string) ClassInfo::get($this, ClassInfo::NAMESPACE_STR);
    }

    /**
     * @return string
     */
    abstract public function getMessage();

    /**
     * @return int
     */
    abstract public function getCode();

    /**
     * @return string
     */
    abstract public function getFile();

    /**
     * @return int
     */
    abstract public function getLine();

    /**
     * @return array
     */
    abstract public function getTrace();
}

/* EOF */
