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

use Scribe\Utility\System\FileSystem;
use Scribe\Utility\UnitTest\AbstractMantleTestCase;

class FilesystemTest extends AbstractMantleTestCase
{
    public function testGenerateRandom()
    {
        $path = '//www///some/path/to///dir//';
        $expected = '/www/some/path/to/dir/';

        static::assertEquals($expected, FileSystem::sanitizePath($path));
    }

    public function testParseDirectoryPathToParts()
    {
        $path = '//www///some/path/to///dir//';
        list($parts,,) = FileSystem::parseDirectoryPathToParts($path);

        static::assertEquals(5, count($parts));

        $path = '//www///some/path/to///dir//';
        $parts = FileSystem::parseDirectoryPathToParts($path, true);

        static::assertEquals(5, count($parts));
    }

    public function testConvertSizeUnitType()
    {
        $bytes = 100000000;

        list($sizeInfo02) = FileSystem::convertSizeUnitType($bytes, Filesystem::UNIT_TYPE_BYTE, FileSystem::UNIT_TYPE_KILOBYTE, FileSystem::UNIT_BASE_02);

        static::assertEquals(97656.25, $sizeInfo02->size);
        static::assertEquals('KB', $sizeInfo02->unit);

        list($sizeInfo10) = FileSystem::convertSizeUnitType($bytes, Filesystem::UNIT_TYPE_BYTE, FileSystem::UNIT_TYPE_GIGABYTE, FileSystem::UNIT_BASE_10);

        static::assertEquals(100, $sizeInfo10->size);
        static::assertEquals('MB', $sizeInfo10->unit);

        $this->setExpectedException(
            'Scribe\Exception\InvalidArgumentException',
            'Invalid unit type specified in "Scribe\Utility\System\FileSystem::convertSizeUnitType" of "1024".'
        );

        FileSystem::convertSizeUnitType($bytes, 'NOTSIZE');
    }
}

/* EOF */
