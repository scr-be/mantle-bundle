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

use Scribe\Tests\Helper\MantleFrameworkHelper;
use Scribe\Utility\Arrays;

class ArraysTest extends MantleFrameworkHelper
{
    public function testShouldThrowExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'Scribe\Exception\RuntimeException',
            'Cannot instantiate static class Scribe\Utility\Arrays.'
        );

        new Arrays;
    }

    public function testIsHash()
    {
        $data = [
            [['a', 'b', 'c', 'd'], false],
            [[0=>'a',1=>'b',2=>'c',3=>'d'], false],
            [[20=>'a',3=>'b',12=>'c',9=>'d'], true],
            [['abc'=>'a','def'=>'b','ghi'=>'c','jkl'=>'d'], true],
        ];

        foreach ($data as $d) {
            $actual = Arrays::isHash($d[0]);
            $this->assertEquals($d[1], $actual);
        }
    }

    public function testIsHashException()
    {
        $this->setExpectedException(
            'Scribe\Exception\RuntimeException',
            'There is no way to determine if en empty array is a hash or not.'
        );

        Arrays::isHash([]);
    }
}

/* EOF */
