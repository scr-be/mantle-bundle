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

use Scribe\MantleBundle\Entity\Icon;
use Scribe\Utility\Reflection\ClassReflectionAnalyser;
use Scribe\Tests\Helper\AbstractMantleKernelUnitTestHelper;

/**
 * Class ClassReflectionAnalyserTest.
 */
class ClassReflectionAnalyserTest extends AbstractMantleKernelUnitTestHelper
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
            ->get('s.mantle.utils.reflection_analyser')
        ;
    }

    public function testFunctionsOutsideOfContainer()
    {
        $refOfClassReflectionAnalyser = new \ReflectionClass(self::FQCN);
        $reflectionClassAnalyser      = new ClassReflectionAnalyser($refOfClassReflectionAnalyser);

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
}

/* EOF */
