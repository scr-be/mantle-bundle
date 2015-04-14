<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Doctrine\Base\Entity;

/**
 * Class EntityBaseCastableTest.
 */
class EntityBaseCastableTest extends AbstractEntityBaseTest
{
    public function testStringCastableOnNoId()
    {
        $expected = self::FQCN.':unknown-id';

        $this->assertEquals($expected, (string) $this->baseEntity);
        $this->assertEquals($expected, (string) $this->baseEntity->__toString());
    }

    public function testStringCastableWithValidId()
    {
        $reflectionProperty = $this->reflectionAnalyser->setPropertyPublic('id');
        $reflectionProperty->setValue($this->baseEntity, '123');

        $expected = self::FQCN.':123';

        $this->assertEquals($expected, (string) $this->baseEntity);
        $this->assertEquals($expected, (string) $this->baseEntity->__toString());
    }

    public function testArrayCastable()
    {
        $expected = [
            'properties' => false,
            'methods' => [
                '__construct',
                'triggerError',
                '__toString',
                '__toArray',
                '__debugInfo',
                '__debugInfoToString',
                'isEqualTo',
                'isEqualToId',
                'isEqualToProperties',
                'isCloneSafe',
                'serialize',
                'unserialize',
                'callOrmPreRemove',
                'callOrmPostRemove',
                'callOrmPrePersist',
                'callOrmPostPersist',
                'callOrmPreUpdate',
                'callOrmPostUpdate',
                'callOrmPostLoad',
                'callOrmLifecycleEvent',
                'disableAutoInitialization',
                'enableAutoInitialization',
                'isAutoInitialized',
                'getAutoInitializedMethods',
                'callInitializationMethods',
                'initializeId',
                'getId',
            ],
        ];

        $this->assertEquals($expected, $this->baseEntity->__toArray());
    }
}

/* EOF */
