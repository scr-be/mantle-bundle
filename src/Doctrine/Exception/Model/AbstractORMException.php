<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Exception\Model;

use Doctrine\ORM\ORMException;
use Scribe\Wonka\Exception\ExceptionTrait;

/**
 * Class AbstractORMException.
 */
abstract class AbstractORMException extends ORMException implements ORMExceptionInterface
{
    use ExceptionTrait;

    /**
     * An enhanced constructor that allows for passing the default \Exception parameters, as well as an array of additional
     * attributes followed by any number of additional arguments that will be passed to sprintf against the message.
     *
     * @param string|null  $message    An error message string (optionally fed to sprintf if optional args are given)
     * @param int|null     $code       The error code (which should be from ORMExceptionInterface). If null, the value
     *                                 of ExceptionInterface::CODE_GENERIC will be used.
     * @param mixed        $previous   The previous exception (when re-thrown within another exception), if applicable.
     * @param mixed        ...$sprintfArgs Optional additional parameters that will be passed to sprintf against the
     *                                 message string provided.
     */
    public function __construct($message = null, $code = null, $previous = null, ...$sprintfArgs)
    {
        parent::__construct(
            $this->getFinalMessage((string) $message, ...$sprintfArgs),
            $this->getFinalCode((int) $code),
            $this->getFinalPrevious($previous)
        );

        $this->setAttributes([]);
    }
}

/* EOF */
