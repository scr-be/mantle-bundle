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

use Scribe\Utility\ClassInfo;
use Scribe\Utility\UnitTest\AbstractMantleTestCase;

class ClassInfoTest extends AbstractMantleTestCase
{
    public function testGet()
    {
        static::assertEquals(
            'ClassInfoTest',
            ClassInfo::get(__CLASS__, ClassInfo::CLASS_STR)
        );

        static::assertEquals(
            'ClassInfoTest',
            ClassInfo::getByInstance($this, ClassInfo::CLASS_STR)
        );

        $this->setExpectedException(
            'Scribe\Exception\BadFunctionCallException',
            'The requested static function getinvalidMethodCall does not exist for class Scribe\Utility\ClassInfo (or is not callable).'
        );

        static::assertEquals(
            'ClassInfoTest',
            ClassInfo::get(__CLASS__, 'invalidMethodCall')
        );
    }

    public function testGetNamespace()
    {
        static::assertEquals(
            'Scribe\Tests\Utility\\',
            ClassInfo::getNamespace(__CLASS__)
        );

        static::assertEquals(
            [
                'Scribe',
                'Tests',
                'Utility',
            ],
            ClassInfo::getNamespaceSet(__CLASS__)
        );

        static::assertEquals(
            'Scribe\Tests\Utility\\',
            ClassInfo::getNamespaceByInstance($this)
        );

        static::assertEquals(
            [
                'Scribe',
                'Tests',
                'Utility',
            ],
            ClassInfo::getNamespaceSetByInstance($this)
        );

        static::assertEquals(
            3,
            ClassInfo::getNamespaceLevels(__CLASS__)
        );

        static::assertEquals(
            3,
            ClassInfo::getNamespaceLevelsByInstance($this)
        );
    }

    public function testGetClassName()
    {
        static::assertEquals(
            'ClassInfoTest',
            ClassInfo::getClassName(__CLASS__)
        );

        static::assertEquals(
            'ClassInfoTest',
            ClassInfo::getClassNameByInstance($this)
        );
    }

    public function testGetTraitName()
    {
        $trait = 'Scribe\SomeRandomTrait';

        static::assertEquals(
            'SomeRandomTrait',
            ClassInfo::getTraitName($trait)
        );
    }
}

/* EOF */
