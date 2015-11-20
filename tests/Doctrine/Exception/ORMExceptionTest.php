<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Doctrine\Exception;

use Scribe\MantleBundle\Doctrine\Exception\ORMException;
use Scribe\WonkaBundle\Utility\TestCase\WonkaTestCase;

/**
 * Class ORMExceptionTest.
 */
class ORMExceptionTest extends WonkaTestCase
{
    public function testORMExceptionSprintf()
    {
        $this->setExpectedException(
            'Scribe\MantleBundle\Doctrine\Exception\ORMException',
            'Testing trigger error function in test class Scribe\MantleBundle\Tests\Doctrine\Exception\ORMExceptionTest and function testORMExceptionSprintf'
        );

        throw new ORMException(
            'Testing trigger error function in test class %s and function %s',
            1,
            null,
            __CLASS__,
            __FUNCTION__
        );
    }

    public function testToString()
    {
        $exception = new ORMException(
            'Testing trigger error function in test class %s and function %s',
            1,
            null,
            __CLASS__,
            __FUNCTION__
        );

        $castException = (string) $exception;

        static::assertContains('Scribe\MantleBundle\Doctrine\Exception\ORMException', $castException);
    }
}

/* EOF */
