<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Doctrine\Base\Exception;

use Scribe\Doctrine\Exception\ORMException;
use Scribe\Utility\UnitTest\AbstractMantleTestCase;

/**
 * Class ORMExceptionTest.
 */
class ORMExceptionTest extends AbstractMantleTestCase
{
    public function testORMExceptionSprintf()
    {
        $this->setExpectedException(
            'Scribe\Doctrine\Exception\ORMException',
            'Testing trigger error function in test class Scribe\Tests\Doctrine\Base\Exception\ORMExceptionTest and function testORMExceptionSprintf'
        );

        throw new ORMException(
            'Testing trigger error function in test class %s and function %s',
            1,
            null,
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
            null,
            __CLASS__,
            __FUNCTION__
        );

        $castException = (string) $exception;

        static::assertContains('Scribe\Doctrine\Exception\ORMException', $castException);
    }
}

/* EOF */
