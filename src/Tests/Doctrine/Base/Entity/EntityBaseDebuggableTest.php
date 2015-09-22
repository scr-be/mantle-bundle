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

/**
 * Class EntityBaseDebuggableTest.
 */
class EntityBaseDebuggableTest extends AbstractEntityBaseTest
{
    public function testDebugInfo()
    {
        $expected = [
            'self' => 'Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity',
            'parent' => 'Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity',
            'properties' => [
                'id' => null,
                'autoInitializationEnabled' => true,
                'autoInitializationCalled' => true,
                'autoInitializationMethods' => [0 => 'initializeId'],
                'serializablePropertyCollection' => ['id']
            ],
            'methods' => [
                '__construct',
                'isCloneSafe',
                'triggerError',
                '__toString',
                '__toArray',
                '__debugInfo',
                '__debugInfoToString',
                'isEqualTo',
                'isEqualToId',
                'isEqualToProperties',
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
                'setSerializablePropertyCollection',
                'addSerializableProperty'
            ],
        ];

        static::assertEquals($expected, $this->baseEntity->__debugInfo());
    }

    public function testDebugInfoToString()
    {
        $expected = '{self} Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity; '.
            '{parent} Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity; '.
            '{properties} id:NULL:,serializablePropertyCollection:array:[id],autoInitializationEnabled:boolean:1,'.
                'autoInitializationCalled:boolean:1,'.
                'autoInitializationMethods:array:[initializeId]; '.
            '{methods}__construct,isCloneSafe,triggerError,__toString,__toArray,__debugInfo,__debugInfoToString,isEqualTo,isEqualToId,isEqualToProperties,serialize,unserialize,callOrmPreRemove,callOrmPostRemove,callOrmPrePersist,callOrmPostPersist,callOrmPreUpdate,callOrmPostUpdate,callOrmPostLoad,callOrmLifecycleEvent,disableAutoInitialization,enableAutoInitialization,isAutoInitialized,getAutoInitializedMethods,callInitializationMethods,initializeId,getId,setSerializablePropertyCollection,addSerializableProperty;';

        static::assertEquals($expected, $this->baseEntity->__debugInfoToString());
    }

    public function testDebugInfoToStringNested()
    {
        $expected = '{self} Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity; '.
            '{parent} Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity; '.
            '{properties} id:NULL:,serializablePropertyCollection:array:[id],autoInitializationEnabled:boolean:1,'.
                'autoInitializationCalled:boolean:1,'.
                'autoInitializationMethods:array:[initializeId],'.
                'innerClone:object:({self} Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity; {parent} Scribe\MantleBundle\Doctrine\Base\Entity\AbstractEntity; {properties} id:NULL:,serializablePropertyCollection:array:[id],autoInitializationEnabled:boolean:1,autoInitializationCalled:boolean:1,autoInitializationMethods:array:[initializeId]; {methods}__construct,isCloneSafe,triggerError,__toString,__toArray,__debugInfo,__debugInfoToString,isEqualTo,isEqualToId,isEqualToProperties,serialize,unserialize,callOrmPreRemove,callOrmPostRemove,callOrmPrePersist,callOrmPostPersist,callOrmPreUpdate,callOrmPostUpdate,callOrmPostLoad,callOrmLifecycleEvent,disableAutoInitialization,enableAutoInitialization,isAutoInitialized,getAutoInitializedMethods,callInitializationMethods,initializeId,getId,setSerializablePropertyCollection,addSerializableProperty;); '.
            '{methods}__construct,isCloneSafe,triggerError,__toString,__toArray,__debugInfo,__debugInfoToString,isEqualTo,isEqualToId,isEqualToProperties,serialize,unserialize,callOrmPreRemove,callOrmPostRemove,callOrmPrePersist,callOrmPostPersist,callOrmPreUpdate,callOrmPostUpdate,callOrmPostLoad,callOrmLifecycleEvent,disableAutoInitialization,enableAutoInitialization,isAutoInitialized,getAutoInitializedMethods,callInitializationMethods,initializeId,getId,setSerializablePropertyCollection,addSerializableProperty;';

        $this->baseEntity->innerClone = clone $this->baseEntity;
        static::assertEquals($expected, $this->baseEntity->__debugInfoToString());
    }
}

/* EOF */
