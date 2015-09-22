<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\Doctrine\Base\Entity;

use Scribe\MantleBundle\Tests\Doctrine\Fixtures\BaseAbstractNoInitEntity;

/**
 * Class EntityBaseInitializableTest.
 */
class EntityBaseInitializableTest extends AbstractEntityBaseTest
{
    public function testBaseEntityWasInitialized()
    {
        static::assertTrue($this->baseEntity->isAutoInitialized());
    }

    public function testInitializedMethods()
    {
        $expected = [
            0 => 'initializeId',
        ];

        static::assertEquals($expected, $this->baseEntity->getAutoInitializedMethods());
    }

    public function testDoNotInitialize()
    {
        $noInitEntity = new BaseAbstractNoInitEntity();

        static::assertFalse($noInitEntity->isAutoInitialized());
        static::assertEquals([], $noInitEntity->getAutoInitializedMethods());
    }

    public function testDoNotInitializeForced()
    {
        $expected = [
            0 => 'initializeId',
        ];

        $noInitEntity = new BaseAbstractNoInitEntity();
        $noInitEntity->callInitializationMethods(true);

        static::assertTrue($noInitEntity->isAutoInitialized());
        static::assertEquals($expected, $noInitEntity->getAutoInitializedMethods());
    }

    public function testDoNotInitializeManualEnable()
    {
        $expected = [
            0 => 'initializeId',
        ];

        $noInitEntity = new BaseAbstractNoInitEntity();
        $noInitEntity->enableAutoInitialization();
        $noInitEntity->callInitializationMethods();

        static::assertTrue($noInitEntity->isAutoInitialized());
        static::assertEquals($expected, $noInitEntity->getAutoInitializedMethods());
    }
}

/* EOF */
