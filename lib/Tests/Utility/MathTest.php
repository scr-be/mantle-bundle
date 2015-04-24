<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Utility;

use Scribe\Utility\UnitTest\AbstractMantleTestCase;
use Scribe\Utility\Math;

class MathTest extends AbstractMantleTestCase
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'RuntimeException',
            'Cannot instantiate static class Scribe\Utility\Math.'
        );

        new Math();
    }

    public function testShouldAcceptNoLessThanThreeArguments()
    {
        $this->setExpectedException(
            'PHPUnit_Framework_Error',
            'Missing argument 1 for Scribe\Utility\Math::toBase()'
        );

        Math::toBase();
    }

    public function testToBase()
    {
        $provider = [
            [1,     10, 100, null, false, 10],
            [50,    50, 200, null, false, 200],
            [1.333, 10, 50,  2,    false, 6.67],
            [20,    10, 100, null, true,  100],
        ];

        foreach ($provider as $p) {
            $result = Math::toBase($p[0], $p[1], $p[2], $p[3], $p[4]);
            $this->assertEquals($result, $p[5]);
        }
    }

    public function testToBaseShouldThrowExceptionOnZeroBase()
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            'Cannot convert to a base of zero.'
        );

        Math::toBase(5, 0, 100);
    }
}

/* EOF */
