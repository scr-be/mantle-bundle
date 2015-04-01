<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Utility\Serializer;

use Scribe\Tests\Helper\AbstractMantleUnitTestHelper;
use Scribe\Utility\Serializer\Serializer;

class SerializerTest extends AbstractMantleUnitTestHelper
{
    public function testThrowsExceptionOnInstantiation()
    {
        $this->setExpectedException(
            'Scribe\Exception\RuntimeException',
            'Cannot instantiate static class Scribe\Utility\Serializer\Serializer'
        );

        new Serializer();
    }

    public function testSerializerIgbinary()
    {
        $expectedUnserialized = [1, 'something', ['2, 3', 4]];
        $expectedSerialized   = igbinary_serialize($expectedUnserialized);

        $serialized   = Serializer::sleep($expectedUnserialized, Serializer::SERIALIZE_METHOD_IGBINARY);
        $unserialized = Serializer::wake($serialized, Serializer::SERIALIZE_METHOD_IGBINARY);
        $this->assertEquals($expectedSerialized, $serialized);
        $this->assertEquals($expectedUnserialized, $unserialized);
    }

    public function testSerializerJson()
    {
        $expectedUnserialized = [1, 'something', ['2, 3', 4]];
        $expectedSerialized   = json_encode($expectedUnserialized);

        $serialized   = Serializer::sleep($expectedUnserialized, Serializer::SERIALIZE_METHOD_JSON);
        $unserialized = Serializer::wake($serialized, Serializer::SERIALIZE_METHOD_JSON);
        $this->assertEquals($expectedSerialized, $serialized);
        $this->assertEquals($expectedUnserialized, $unserialized);
    }

    public function testSerializerNative()
    {
        $expectedUnserialized = [1, 'something', ['2, 3', 4]];
        $expectedSerialized   = serialize($expectedUnserialized);

        $serialized   = Serializer::sleep($expectedUnserialized, Serializer::SERIALIZE_METHOD_NATIVE);
        $unserialized = Serializer::wake($serialized, Serializer::SERIALIZE_METHOD_NATIVE);
        $this->assertEquals($expectedSerialized, $serialized);
        $this->assertEquals($expectedUnserialized, $unserialized);
    }
}

/* EOF */
