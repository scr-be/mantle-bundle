<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Utility\Reflection;

use Scribe\MantleBundle\Doctrine\Entity\Icon\Icon;
use Scribe\Utility\Reflection\ClassReflectionAnalyser;
use Scribe\Utility\UnitTest\AbstractMantleKernelTestCase;

/**
 * Class ClassReflectionAnalyserTest.
 */
class ClassReflectionAnalyserTest extends AbstractMantleKernelTestCase
{
    /**
     * @var string
     */
    const FQCN = 'Scribe\Utility\Reflection\ClassReflectionAnalyser';

    /**
     * @var ClassReflectionAnalyser
     */
    protected $reflectionClassAnalyser = null;

    /**
     * @var \ReflectionClass
     */
    protected $refOfClassReflectionAnalyser;

    public function setUp()
    {
        parent::setup();

        $this->reflectionClassAnalyser = $this
            ->container
            ->get('s.mantle.reflection_analyser')
        ;
    }

    public function testFunctionsOutsideOfContainer()
    {
        $refOfClassReflectionAnalyser = new \ReflectionClass(self::FQCN);
        $reflectionClassAnalyser = new ClassReflectionAnalyser($refOfClassReflectionAnalyser);

        $this->assertFalse($reflectionClassAnalyser->hasTrait(
            'doesNotHaveThisTrait', $refOfClassReflectionAnalyser
        ));

        $this->assertTrue($reflectionClassAnalyser->hasTrait(
            'Scribe\Utility\Reflection\ClassReflectionAnalyserTrait', $refOfClassReflectionAnalyser
        ));
    }

    public function testThrowsExceptionWhenReflectionClassNotProvided()
    {
        $this->reflectionClassAnalyser->unsetReflectionClass();

        $this->setExpectedException(
            'Scribe\Exception\InvalidArgumentException',
            'No valid object reflection class instance provided explicitly via method call or injected into object instance.'
        );

        $this->reflectionClassAnalyser->hasTrait(
            'Scribe\Utility\Reflection\ClassReflectionAnalyserTrait', $this->refOfClassReflectionAnalyser
        );
    }

    public function testHasTraitViaConstructorSet()
    {
        $this->refOfClassReflectionAnalyser =
            new \ReflectionClass(self::FQCN);

        $this->assertFalse($this->reflectionClassAnalyser->hasTrait(
            'doesNotHaveThisTrait', $this->refOfClassReflectionAnalyser
        ));

        $this->assertTrue($this->reflectionClassAnalyser->hasTrait(
            'Scribe\Utility\Reflection\ClassReflectionAnalyserTrait', $this->refOfClassReflectionAnalyser
        ));
    }

    public function testHasTraitViaManualReflectionObjectInjection()
    {
        $this->refOfClassReflectionAnalyser = new \ReflectionClass(self::FQCN);

        $this->reflectionClassAnalyser->unsetReflectionClass();

        $this->reflectionClassAnalyser->setReflectionClass(new \ReflectionClass(self::FQCN));

        $this->assertFalse($this->reflectionClassAnalyser->hasTrait(
            'doesNotHaveThisTrait', $this->refOfClassReflectionAnalyser
        ));

        $this->assertTrue($this->reflectionClassAnalyser->hasTrait(
            'Scribe\Utility\Reflection\ClassReflectionAnalyserTrait', $this->refOfClassReflectionAnalyser
        ));
    }

    public function testHasTraitViaClassInstanceSet()
    {
        $iconEntity = new Icon();
        $this->reflectionClassAnalyser->setReflectionClassFromClassInstance($iconEntity);

        $this->assertFalse($this->reflectionClassAnalyser->hasTrait(
            'doesNotHaveThisTrait', null, true
        ));

        $this->assertFalse($this->reflectionClassAnalyser->hasTrait(
            'doesNotHaveThisTrait', null, false
        ));

        $this->assertTrue($this->reflectionClassAnalyser->hasTrait(
            'Scribe\Doctrine\Base\Model\HasName', null, true
        ));

        $this->assertTrue($this->reflectionClassAnalyser->hasTrait(
            'Scribe\Doctrine\Base\Model\HasName', null, false
        ));

        $this->assertTrue($this->reflectionClassAnalyser->hasTrait(
            'Scribe\Doctrine\Base\Entity\Serializable\EntitySerializableTrait', null, true
        ));

        $this->assertFalse($this->reflectionClassAnalyser->hasTrait(
            'Scribe\Doctrine\Base\Entity\Serializable\EntitySerializableTrait', null, false
        ));

        $this->assertFalse($this->reflectionClassAnalyser->hasTrait(
            'doesNotHaveThisTrait', null, true
        ));
    }

    public function testHasTraitViaClassNameSet()
    {
        $this->reflectionClassAnalyser->setReflectionClassFromClassName(self::FQCN);

        $this->assertFalse($this->reflectionClassAnalyser->hasTrait(
            'doesNotHaveThisTrait', $this->refOfClassReflectionAnalyser
        ));

        $this->assertTrue($this->reflectionClassAnalyser->hasTrait(
            'Scribe\Utility\Reflection\ClassReflectionAnalyserTrait', $this->refOfClassReflectionAnalyser
        ));
    }

    public function testHasMethodViaConstructorSet()
    {
        $this->refOfClassReflectionAnalyser =
            new \ReflectionClass(self::FQCN);

        $this->assertFalse($this->reflectionClassAnalyser->hasMethod(
            'doesNotHaveThisMethod', $this->refOfClassReflectionAnalyser
        ));

        $this->assertTrue($this->reflectionClassAnalyser->hasMethod(
            'hasMethod', $this->refOfClassReflectionAnalyser
        ));
    }

    public function testHasMethodThrowsExceptionWhenReflectionClassNotProvided()
    {
        $this->reflectionClassAnalyser->unsetReflectionClass();

        $this->setExpectedException(
            'Scribe\Exception\InvalidArgumentException',
            'No valid object reflection class instance provided explicitly via method call or injected into object instance.'
        );

        $this->reflectionClassAnalyser->hasMethod(
            'someMethod', $this->refOfClassReflectionAnalyser
        );
    }

    public function testHasProperty()
    {
        $iconEntity = new Icon();
        $this->reflectionClassAnalyser->setReflectionClassFromClassInstance($iconEntity);

        $this->assertFalse($this->reflectionClassAnalyser->hasProperty(
            'doesNotHaveThisProperty', $this->refOfClassReflectionAnalyser
        ));

        $this->assertTrue($this->reflectionClassAnalyser->hasProperty(
            'families', $this->refOfClassReflectionAnalyser, true
        ));

        $this->assertTrue($this->reflectionClassAnalyser->hasProperty(
            'id', $this->refOfClassReflectionAnalyser, true
        ));
    }

    public function testHasPropertyThrowsExceptionWhenReflectionClassNotProvided()
    {
        $this->reflectionClassAnalyser->unsetReflectionClass();

        $this->setExpectedException(
            'Scribe\Exception\InvalidArgumentException',
            'No valid object reflection class instance provided explicitly via method call or injected into object instance.'
        );

        $this->reflectionClassAnalyser->hasProperty(
            'someProperty', $this->refOfClassReflectionAnalyser
        );
    }

    public function testSetPropertyPublic()
    {
        $this->reflectionClassAnalyser->unsetReflectionClass();
        $this->reflectionClassAnalyser->setReflectionClassFromClassName(self::FQCN);

        $this->reflectionClassAnalyser->setRequireFQN(true);
        $this->assertTrue($this->reflectionClassAnalyser->getRequireFQN());

        $reflectionProperty = $this->reflectionClassAnalyser->setPropertyPublic('requireFQN');

        $reflectionProperty->setValue($this->reflectionClassAnalyser, false);
        $this->assertFalse($this->reflectionClassAnalyser->getRequireFQN());

        $reflectionProperty->setValue($this->reflectionClassAnalyser, true);
        $this->assertTrue($this->reflectionClassAnalyser->getRequireFQN());
    }

    public function testSetPropertyPublicException()
    {
        $this->reflectionClassAnalyser->unsetReflectionClass();
        $this->reflectionClassAnalyser->setReflectionClassFromClassName(self::FQCN);

        $this->setExpectedException(
            'Scribe\Exception\InvalidArgumentException',
            'The requested property property-does-not-exist does not exist on the passed class Scribe\Utility\Reflection\ClassReflectionAnalyser.'
        );

        $this->reflectionClassAnalyser->setPropertyPublic('property-does-not-exist');
    }

    public function testSetMethodPublic()
    {
        $this->reflectionClassAnalyser->unsetReflectionClass();
        $this->reflectionClassAnalyser->setReflectionClassFromClassName(self::FQCN);

        $reflectionMethod = $this->reflectionClassAnalyser->setMethodPublic('getTraitNames');

        $expected = ['Scribe\Utility\Reflection\ClassReflectionAnalyserTrait'];
        $traits = $reflectionMethod->invoke($this->reflectionClassAnalyser, $this->reflectionClassAnalyser->getReflectionClass());

        $this->assertEquals($expected, $traits);
    }

    public function testSetMethodPublicException()
    {
        $this->reflectionClassAnalyser->unsetReflectionClass();
        $this->reflectionClassAnalyser->setReflectionClassFromClassName(self::FQCN);

        $this->setExpectedException(
            'Scribe\Exception\InvalidArgumentException',
            'The requested method method-does-not-exist does not exist on the passed class Scribe\Utility\Reflection\ClassReflectionAnalyser.'
        );

        $this->reflectionClassAnalyser->setMethodPublic('method-does-not-exist');
    }

    public function testGetProperties()
    {
        $this->reflectionClassAnalyser->unsetReflectionClass();
        $this->reflectionClassAnalyser->setReflectionClassFromClassName(self::FQCN);

        $this->assertEquals(2, count($this->reflectionClassAnalyser->getProperties(false)));
        $this->assertEquals(0, count($this->reflectionClassAnalyser->getProperties(\ReflectionProperty::IS_PUBLIC)));
        $this->assertEquals(0, count($this->reflectionClassAnalyser->getProperties(\ReflectionProperty::IS_PROTECTED)));
        $this->assertEquals(2, count($this->reflectionClassAnalyser->getProperties(\ReflectionProperty::IS_PRIVATE)));
    }

    public function testGetPropertiesException()
    {
        $this->reflectionClassAnalyser->unsetReflectionClass();
        $this->reflectionClassAnalyser->setReflectionClassFromClassName(self::FQCN);

        $this->setExpectedException(
            'Scribe\Exception\InvalidArgumentException',
            'Invalid filter provided to getProperties. Valid filters are false (for all properties), '.
            '\ReflectionProperty::IS_PRIVATE \ReflectionProperty::IS_PROTECTED, and \ReflectionProperty::IS_PUBLIC.'
        );
        $this->reflectionClassAnalyser->getProperties(-02020202);
    }

    public function testNoTraits()
    {
        $this->reflectionClassAnalyser->unsetReflectionClass();
        $this->reflectionClassAnalyser->setReflectionClassFromClassInstance(new \stdClass());

        $this->assertFalse($this->reflectionClassAnalyser->hasTrait('Anything'));
    }
}

/* EOF */
