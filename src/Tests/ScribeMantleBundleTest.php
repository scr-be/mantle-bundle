<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Scribe\MantleBundle\ScribeMantleBundle;
use Symfony\Component\DependencyInjection\Container;
use AppKernel;

/**
 * Class ScribeMantleBundleTest.
 */
class ScribeMantleBundleTest extends PHPUnit_Framework_TestCase
{
    const FULLY_QUALIFIED_CLASS_NAME = 'Scribe\MantleBundle\ScribeMantleBundle';

    private $container;

    protected function setUp()
    {
        $kernel = new AppKernel('test', true);
        $kernel->boot();

        $this->container = $kernel->getContainer();
    }

    protected function getNewBundle()
    {
        return new ScribeMantleBundle();
    }

    protected function getReflection()
    {
        return new ReflectionClass(self::FULLY_QUALIFIED_CLASS_NAME);
    }

    public function testCanBuildContainer()
    {
        $this->assertTrue(($this->container instanceof Container));
    }
}

/* EOF */
