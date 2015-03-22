<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Utility;

use PHPUnit_Framework_TestCase;
use Scribe\Utility\Math;
use Scribe\Exception\InvalidArgumentException;

class MathTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @expectedException        RuntimeException
     * @expectedExceptionMessage Cannot instantiate static class Scribe\Utility\Math.
     */
    public function shouldThrowExceptionOnInstantiation()
    {
        new Math();
    }

    /**
     * @test
     * @expectedException              PHPUnit_Framework_Error
     * @expectedExceptionMessageRegExp /Missing argument 1 for Scribe\\Utility\\Math::toBase\(\)/
     */
    public function shouldAcceptNoLessThanThreeArguments()
    {
        Math::toBase();
    }

    public function toBaseProvider()
    {
        return [
            [1,     10, 100, null, false, 10  ],
            [50,    50, 200, null, false, 200 ],
            [1.333, 10, 50,  2,    false, 6.67],
            [20,    10, 100, null, true,  100 ],
        ];
    }

    /**
     * @dataProvider toBaseProvider
     */
    public function testToBase($integer, $base, $newBase, $precision, $newBaseAsMax, $expected)
    {
        $result = Math::toBase($integer, $base, $newBase, $precision, $newBaseAsMax);
        $this->assertEquals($result, $expected);
    }

    /**
     * @test
     * @expectedException        InvalidArgumentException
     * @expectedExceptionMessage Cannot convert to a base of zero.
     */
    public function toBaseShouldThrowExceptionOnZeroBase()
    {
        Math::toBase(5, 0, 100);
    }
}

/* EOF */
