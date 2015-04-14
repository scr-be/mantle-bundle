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
 * Class EntityBaseDebuggableTest.
 */
class EntityBaseDebuggableTest extends AbstractEntityBaseTest
{
    public function testDebugInfo()
    {
        $expected = [
            'self' => 'Scribe\Doctrine\Base\Entity\AbstractEntity',
            'parent' => 'Scribe\Doctrine\Base\Entity\AbstractEntity',
            'properties' => [
                'id' => null,
                'autoInitializationEnabled' => true,
                'autoInitializationCalled' => true,
                'autoInitializationMethods' => [0 => 'initializeId'],
            ],
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

        $this->assertEquals($expected, $this->baseEntity->__debugInfo());
    }

    public function testDebugInfoToString()
    {
        $expected = '{self} Scribe\Doctrine\Base\Entity\AbstractEntity; '.
            '{parent} Scribe\Doctrine\Base\Entity\AbstractEntity; '.
            '{properties} id:NULL:,autoInitializationEnabled:boolean:1,'.
                'autoInitializationCalled:boolean:1,'.
                'autoInitializationMethods:array:[initializeId]; '.
            '{methods}__construct,triggerError,__toString,__toArray,__debugInfo,__debugInfoToString,isEqualTo,isEqualToId,isEqualToProperties,isCloneSafe,serialize,unserialize,callOrmPreRemove,callOrmPostRemove,callOrmPrePersist,callOrmPostPersist,callOrmPreUpdate,callOrmPostUpdate,callOrmPostLoad,callOrmLifecycleEvent,disableAutoInitialization,enableAutoInitialization,isAutoInitialized,getAutoInitializedMethods,callInitializationMethods,initializeId,getId;';

        $this->assertEquals($expected, $this->baseEntity->__debugInfoToString());
    }

    public function testDebugInfoToStringNested()
    {
        $expected = '{self} Scribe\Doctrine\Base\Entity\AbstractEntity; '.
            '{parent} Scribe\Doctrine\Base\Entity\AbstractEntity; '.
            '{properties} id:NULL:,autoInitializationEnabled:boolean:1,'.
                'autoInitializationCalled:boolean:1,'.
                'autoInitializationMethods:array:[initializeId],'.
                'innerClone:object:({self} Scribe\Doctrine\Base\Entity\AbstractEntity; {parent} Scribe\Doctrine\Base\Entity\AbstractEntity; {properties} id:NULL:,autoInitializationEnabled:boolean:1,autoInitializationCalled:boolean:1,autoInitializationMethods:array:[initializeId]; {methods}__construct,triggerError,__toString,__toArray,__debugInfo,__debugInfoToString,isEqualTo,isEqualToId,isEqualToProperties,isCloneSafe,serialize,unserialize,callOrmPreRemove,callOrmPostRemove,callOrmPrePersist,callOrmPostPersist,callOrmPreUpdate,callOrmPostUpdate,callOrmPostLoad,callOrmLifecycleEvent,disableAutoInitialization,enableAutoInitialization,isAutoInitialized,getAutoInitializedMethods,callInitializationMethods,initializeId,getId;); '.
            '{methods}__construct,triggerError,__toString,__toArray,__debugInfo,__debugInfoToString,isEqualTo,isEqualToId,isEqualToProperties,isCloneSafe,serialize,unserialize,callOrmPreRemove,callOrmPostRemove,callOrmPrePersist,callOrmPostPersist,callOrmPreUpdate,callOrmPostUpdate,callOrmPostLoad,callOrmLifecycleEvent,disableAutoInitialization,enableAutoInitialization,isAutoInitialized,getAutoInitializedMethods,callInitializationMethods,initializeId,getId;';

        $this->baseEntity->innerClone = clone $this->baseEntity;
        $this->assertEquals($expected, $this->baseEntity->__debugInfoToString());
    }
}

/* EOF */
