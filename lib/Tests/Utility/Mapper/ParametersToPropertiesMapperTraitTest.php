<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Utility\System;

use Scribe\Tests\Utility\Mapper\MapperFixture;
use Scribe\Utility\UnitTest\AbstractMantleTestCase;

class ParametersToPropertiesMapperTraitTest extends AbstractMantleTestCase
{
    public function testAssignment()
    {
        $mapper = new MapperFixture([
            ['propertyString' => 'some-random-string'],
            ['something' => 'not-a-property']
        ]);

        static::assertEquals(
            null,
            $mapper->getPropertyString()
        );
    }
}

/* EOF */
