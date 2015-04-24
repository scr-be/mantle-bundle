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
use Scribe\CacheBundle\ScribeCacheBundle;
use Scribe\MantleBundle\ScribeMantleBundle;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ScribeMantleBundleTest.
 */
class ScribeMantleBundleTest extends PHPUnit_Framework_TestCase
{
    const FULLY_QUALIFIED_CLASS_NAME = 'Scribe\MantleBundle\ScribeMantleBundle';

    private $container;

    protected function setUp()
    {
        $kernel = new \AppKernel('test', true);
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

    public function testCanAccessContainerServices()
    {
        $this->assertTrue($this->container->has('s.mantle.node.repo'));
        $this->assertInstanceOf(
            'Scribe\MantleBundle\Doctrine\Repository\Node\NodeRepository',
            $this->container->get('s.mantle.node.repo')
        );
    }

    public function testCanApplyCompilerPass()
    {
        $this->assertTrue($this->container->has('s.mantle.node_creator.renderer.registrar'));
        $nodeRenderer = $this->container->get('s.mantle.node_creator.renderer.registrar');
        $this->assertInstanceOf(
            'Scribe\Component\DependencyInjection\Compiler\AbstractCompilerPassChain',
            $nodeRenderer
        );
        $this->assertInstanceOf(
            'Scribe\Component\DependencyInjection\Compiler\AbstractCompilerPassChain',
            $nodeRenderer
        );
        $this->assertNotEquals([], $nodeRenderer->getHandlerCollection());
        $this->assertTrue($nodeRenderer->hasHandlerCollection());
        $this->assertEquals(1, count($nodeRenderer->getHandlerCollection()));
    }

    protected function tearDown()
    {
        if (!$this->container instanceof ContainerInterface) {
            return;
        }
        $cacheDir = $this->container->getParameter('kernel.cache_dir');
        if (true === is_dir($cacheDir)) {
            $this->removeDirectoryRecursive($cacheDir);
        }
    }

    protected function removeDirectoryRecursive($path)
    {
        $files = glob($path . '/*');
        foreach ($files as $file) {
            is_dir($file) ? $this->removeDirectoryRecursive($file) : unlink($file);
        }
        rmdir($path);
    }
}

/* EOF */
