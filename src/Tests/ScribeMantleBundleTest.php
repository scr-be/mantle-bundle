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
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Scribe\MantleBundle\ScribeMantleBundle;
use Scribe\MantleBundle\Tests\app\AppKernelInvalidCompilerPasses;

/**
 * Class ScribeMantleBundleTest.
 */
class ScribeMantleBundleTest extends PHPUnit_Framework_TestCase
{
    const FULLY_QUALIFIED_CLASS_NAME = 'Scribe\MantleBundle\ScribeMantleBundle';

    /**
     * @var ContainerInterface
     */
    public static $container;

    public function setUp()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();
        static::$container = $kernel->getContainer();
    }

    public function getNewBundle()
    {
        return new ScribeMantleBundle();
    }

    public function getReflection()
    {
        return new ReflectionClass(self::FULLY_QUALIFIED_CLASS_NAME);
    }

    public function testCanBuildContainer()
    {
        static::assertTrue((static::$container instanceof Container));
    }

    public function testInvalidCompilerPasses()
    {
        $kernel = new AppKernelInvalidCompilerPasses('test', true);
        $kernel->boot();
        $container = $kernel->getContainer();

        static::assertFalse($container->has('service-does-not-exist'));

        $cacheDir = static::$container->getParameter('kernel.cache_dir');

        if (true === is_dir($cacheDir)) {
            $this->removeDirectoryRecursive($cacheDir);
        }
    }

    public function testCanAccessContainerServices()
    {
        static::assertTrue(static::$container->has('s.mantle.node.repo'));
        static::assertInstanceOf(
            'Scribe\MantleBundle\Doctrine\Repository\Node\NodeRepository',
            static::$container->get('s.mantle.node.repo')
        );
    }

    public function testCanApplyCompilerPass()
    {
        static::assertTrue(static::$container->has('s.mantle.node_creator.renderer.registrar'));

        $nodeRenderer = static::$container->get('s.mantle.node_creator.renderer.registrar');
        static::assertInstanceOf(
            'Scribe\MantleBundle\Component\DependencyInjection\Compiler\AbstractCompilerPassChain',
            $nodeRenderer
        );
        static::assertInstanceOf(
            'Scribe\MantleBundle\Component\DependencyInjection\Compiler\AbstractCompilerPassChain',
            $nodeRenderer
        );

        static::assertNotEquals([], $nodeRenderer->getHandlerCollection());
        static::assertTrue($nodeRenderer->hasHandlerCollection());
        static::assertEquals(2, count($nodeRenderer->getHandlerCollection()));
    }

    public function tearDown()
    {
        if (!static::$container instanceof ContainerInterface) {
            return;
        }

        $cacheDir = static::$container->getParameter('kernel.cache_dir');

        if (true === is_dir($cacheDir)) {
            $this->removeDirectoryRecursive($cacheDir);
        }
    }

    public function removeDirectoryRecursive($path)
    {
        $files = glob($path.'/*');

        foreach ($files as $file) {
            is_dir($file) ? $this->removeDirectoryRecursive($file) : unlink($file);
        }

        rmdir($path);
    }
}

/* EOF */
