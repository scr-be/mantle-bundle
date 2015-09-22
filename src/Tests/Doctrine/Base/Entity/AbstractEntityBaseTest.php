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

use Scribe\MantleBundle\Tests\Doctrine\Fixtures\BaseAbstractEntity;
use Scribe\Wonka\Utility\Reflection\ClassReflectionAnalyser;
use Scribe\WonkaBundle\Utility\TestCase\WonkaTestCase;

/**
 * Class AbstractEntityBaseTest.
 */
abstract class AbstractEntityBaseTest extends WonkaTestCase
{
    const FQCN = 'Scribe\MantleBundle\Tests\Doctrine\Fixtures\BaseAbstractEntity';

    /**
     * @var ClassReflectionAnalyser
     */
    protected $reflectionAnalyser;

    /**
     * BaseAbstractEntity.
     */
    protected $baseEntity;

    public function setUp()
    {
        parent::setUp();

        $this->baseEntity = new BaseAbstractEntity();
        $this->reflectionAnalyser = new ClassReflectionAnalyser();
        $this->reflectionAnalyser->setReflectionClassFromClassInstance($this->baseEntity);
    }
}

/* EOF */
