<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Exception\Model;

use Scribe\Exception\Model\ExceptionInterface;

/**
 * Interface ORMExceptionInterface.
 */
interface ORMExceptionInterface extends ExceptionInterface
{
    /**
     * Generic ORM exception message. Should be avoided.
     *
     * @var string
     */
    const MSG_ORM_GENERIC = 'An undefined ORM exception was thrown.';

    /**
     * Generic exception code for...absolutely generic, unspecified exceptions.
     *
     * @var int
     */
    const CODE_ORM_GENERIC = 5000;
}

/* EOF */
