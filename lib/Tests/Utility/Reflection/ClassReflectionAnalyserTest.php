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
use Scribe\Utility\Reflection\ClassReflectionAnalyzer;
use Scribe\Tests\Helper\AbstractMantleKernelUnitTestHelper;

/**
 * Class ClassReflectionAnalyzerTest.
 */
class ClassReflectionAnalyzerTest extends AbstractMantleKernelUnitTestHelper
{
    /**
     * @var string
     */
    const FQCN = 'Scribe\Utility\Reflection\ClassReflectionAnalyzer';

    /**
     * @var ClassReflectionAnalyzer
     */
    protected $reflectionClassAnalyzer = null;

    /**
     * @var \ReflectionClass
     */
    protected $refOfClassReflectionAnalyzer;

    public function setUp()
    {
        parent::setup();

        $this->reflectionClassAnalyzer = $this
            ->container
            ->get('s.mantle.utils.reflection_analyzer')
        ;
    }

    public function testFunctionsOutsideOfContainer()
    {
        $refOfClassReflectionAnalyzer = new \ReflectionClass(self::FQCN);
        $reflectionClassAnalyzer      = new ClassReflectionAnalyzer($refOfClassReflectionAnalyzer);

        $this->assertFalse($reflectionClassAnalyzer->hasTrait(
            'doesNotHaveThisTrait', $refOfClassReflectionAnalyzer
        ));

        $this->assertTrue($reflectionClassAnalyzer->hasTrait(
            'Scribe\Utility\Reflection\ClassReflectionAnalyzerTrait', $refOfClassReflectionAnalyzer
        ));
    }

    public function testThrowsExceptionWhenReflectionClassNotProvided()
    {
        $this->reflectionClassAnalyzer->unsetReflectionClass();

        $this->setExpectedException(
            'Scribe\Exception\InvalidArgumentException',
            'No valid object reflection class instance provided explicitly via method call or injected into object instance.'
        );

        $this->reflectionClassAnalyzer->hasTrait(
            'Scribe\Utility\Reflection\ClassReflectionAnalyzerTrait', $this->refOfClassReflectionAnalyzer
        );
    }

    public function testHasTraitViaConstructorSet()
    {
        $this->refOfClassReflectionAnalyzer =
            new \ReflectionClass(self::FQCN);

        $this->assertFalse($this->reflectionClassAnalyzer->hasTrait(
            'doesNotHaveThisTrait', $this->refOfClassReflectionAnalyzer
        ));

        $this->assertTrue($this->reflectionClassAnalyzer->hasTrait(
            'Scribe\Utility\Reflection\ClassReflectionAnalyzerTrait', $this->refOfClassReflectionAnalyzer
        ));
    }

    public function testHasTraitViaManualReflectionObjectInjection()
    {
        $this->refOfClassReflectionAnalyzer = new \ReflectionClass(self::FQCN);

        $this->reflectionClassAnalyzer->unsetReflectionClass();

        $this->reflectionClassAnalyzer->setReflectionClass(new \ReflectionClass(self::FQCN));

        $this->assertFalse($this->reflectionClassAnalyzer->hasTrait(
            'doesNotHaveThisTrait', $this->refOfClassReflectionAnalyzer
        ));

        $this->assertTrue($this->reflectionClassAnalyzer->hasTrait(
            'Scribe\Utility\Reflection\ClassReflectionAnalyzerTrait', $this->refOfClassReflectionAnalyzer
        ));
    }

    public function testHasTraitViaClassInstanceSet()
    {
        $iconEntity = new Icon();
        $this->reflectionClassAnalyzer->setReflectionClassFromClassInstance($iconEntity);

        $this->assertFalse($this->reflectionClassAnalyzer->hasTrait(
            'doesNotHaveThisTrait', null, true
        ));

        $this->assertFalse($this->reflectionClassAnalyzer->hasTrait(
            'doesNotHaveThisTrait', null, false
        ));

        $this->assertTrue($this->reflectionClassAnalyzer->hasTrait(
            'Scribe\Doctrine\Base\Model\HasName', null, true
        ));

        $this->assertTrue($this->reflectionClassAnalyzer->hasTrait(
            'Scribe\Doctrine\Base\Model\HasName', null, false
        ));

        $this->assertTrue($this->reflectionClassAnalyzer->hasTrait(
            'Scribe\Doctrine\Base\Entity\Serializable\EntitySerializableTrait', null, true
        ));

        $this->assertFalse($this->reflectionClassAnalyzer->hasTrait(
            'Scribe\Doctrine\Base\Entity\Serializable\EntitySerializableTrait', null, false
        ));

        $this->assertFalse($this->reflectionClassAnalyzer->hasTrait(
            'doesNotHaveThisTrait', null, true
        ));
    }

    public function testHasTraitViaClassNameSet()
    {
        $this->reflectionClassAnalyzer->setReflectionClassFromClassName(self::FQCN);

        $this->assertFalse($this->reflectionClassAnalyzer->hasTrait(
            'doesNotHaveThisTrait', $this->refOfClassReflectionAnalyzer
        ));

        $this->assertTrue($this->reflectionClassAnalyzer->hasTrait(
            'Scribe\Utility\Reflection\ClassReflectionAnalyzerTrait', $this->refOfClassReflectionAnalyzer
        ));
    }

    /*
    public function hasMethod($methodName, \ReflectionClass $class = null, $recursiveSearch = true)
    {
        $class = $this->determineWorkingReflectionClass($class);

        if (true === $class->hasMethod($methodName)) {
            return true;
        }

        $parentClass = $class->getParentClass();

        if ((false === $recursiveSearch) || (false === $parentClass) || (null === $parentClass)) {
            return false;
        }

        return (bool) $this->hasMethod($parentClass, $methodName, $recursiveSearch);
    }
    public function hasProperty($propertyName, \ReflectionClass $class = null, $recursiveSearch = true)
    {
        $class = $this->determineWorkingReflectionClass($class);

        if (true === $class->hasProperty($propertyName)) {
            return true;
        }

        $parentClass = $class->getParentClass();

        if ((false === $recursiveSearch) || (false === $parentClass) || (null === $parentClass)) {
            return false;
        }

        return (bool) $this->hasProperty($parentClass, $propertyName, $recursiveSearch);
    }
    private function determineWorkingReflectionClass(\ReflectionClass $reflectionClass = null)
    {
        if ($reflectionClass !== null) {
            return $reflectionClass;
        }

        if ($this->reflectionClass !== null) {
            return $this->reflectionClass;
        }

        throw new InvalidArgumentException(
            'Cannot determine class information without a \ReflectionClass instance set via either the setReflectionClass '.
            'method or passed directly to the calling examination function.'
        );
    }
    */
}

/* EOF */
