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

use Scribe\MantleBundle\Doctrine\Entity\Node\Node;

/**
 * Class EntityBaseEquatableTest.
 */
class EntityBaseEquatableTest extends AbstractEntityBaseTest
{
    public function testIsEqualTo()
    {
        $this->assertTrue($this->baseEntity->isEqualTo($this->baseEntity));
    }

    public function testIsEqualToId()
    {
        $reflectionProperty1 = $this->reflectionAnalyser->setPropertyPublic('id');
        $reflectionProperty1->setValue($this->baseEntity, '123');

        $secondBaseEntity = clone $this->baseEntity;
        $thirdBaseEntity = clone $this->baseEntity;

        $reflectionProperty2 = $this->reflectionAnalyser->setPropertyPublic('id');
        $reflectionProperty2->setValue($thirdBaseEntity, '456');

        $this->assertFalse($this->baseEntity->isEqualTo($secondBaseEntity));
        $this->assertFalse($this->baseEntity->isEqualTo($thirdBaseEntity));
        $this->assertTrue($this->baseEntity->isEqualToId($secondBaseEntity));
        $this->assertFalse($this->baseEntity->isEqualToId($thirdBaseEntity));
    }

    public function testIsEqualToProperties()
    {
        $reflectionProperty1 = $this->reflectionAnalyser->setPropertyPublic('id');
        $reflectionProperty1->setValue($this->baseEntity, '123');

        $secondBaseEntity = clone $this->baseEntity;
        $thirdBaseEntity = clone $this->baseEntity;
        $forthBaseEntity = new Node();

        $reflectionProperty2 = $this->reflectionAnalyser->setPropertyPublic('id');
        $reflectionProperty2->setValue($thirdBaseEntity, '456');

        $this->assertTrue($this->baseEntity->isEqualToProperties($secondBaseEntity));
        $this->assertFalse($this->baseEntity->isEqualToProperties($thirdBaseEntity));
        $this->assertFalse($this->baseEntity->isEqualToProperties($forthBaseEntity));
    }
}

/* EOF */
