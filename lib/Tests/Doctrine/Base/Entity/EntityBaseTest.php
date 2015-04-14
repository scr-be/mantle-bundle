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

use Scribe\Doctrine\Exception\ORMException;
use Scribe\Utility\Reflection\ClassReflectionAnalyser;

/**
 * Class EntityBaseTest.
 */
class EntityBaseTest extends AbstractEntityBaseTest
{
    public function testIsCloneSafeNoId()
    {
        $this->setExpectedException(
            'Scribe\Doctrine\Exception\ORMException',
            'Testing trigger error function'
        );

        $classAnalyzer = new ClassReflectionAnalyser();
        $classAnalyzer->setReflectionClassFromClassInstance($this->baseEntity);
        $reflectionMethod = $classAnalyzer->setMethodPublic('triggerError');

        $exception = new ORMException(
            sprintf('Testing trigger error function')
        );

        $reflectionMethod->invoke($this->baseEntity, $exception);
    }
}

/* EOF */
