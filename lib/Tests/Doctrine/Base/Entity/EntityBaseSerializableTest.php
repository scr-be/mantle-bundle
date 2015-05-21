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

use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class EntityBaseSerializableTest.
 */
class EntityBaseSerializableTest extends AbstractEntityBaseTest
{
    /**
     * @var AbstractEntity
     */
    public $baseEntity;

    public function testIsCloneSafe()
    {
        static::assertFalse($this->baseEntity->isCloneSafe());

        $entity = $this->reflectionAnalyser->setPropertyPublic('id');
        $entity->setValue($this->baseEntity, 100);

        static::assertTrue($this->baseEntity->isCloneSafe());
    }

    public function testIsSerializable()
    {
        $serializedEntity = serialize($this->baseEntity);
        $unserializedEntity = unserialize($serializedEntity);

        static::assertEquals($this->baseEntity, $unserializedEntity);
    }
}

/* EOF */
