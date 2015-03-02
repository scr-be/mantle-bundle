<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\DependencyInjection;

use PHPUnit_Framework_TestCase;
use Scribe\MantleBundle\DependencyInjection\ScribeMantleExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class AbstractScribeMantleExtensionTest
 *
 * @package Scribe\MantleBundle\Tests\DependencyInjection
 */
abstract class AbstractScribeMantleExtensionTest extends PHPUnit_Framework_TestCase
{
    private $extension;
    private $container;

    protected function setUp()
    {
        $this->extension = new ScribeMantleExtension();

        $this->container = new ContainerBuilder();
        $this->container->registerExtension($this->extension);
    }

    abstract protected function loadConfiguration(ContainerBuilder $container, $resource);

    public function testWithoutConfiguration()
    {
        $this->container->loadFromExtension($this->extension->getAlias());
        $this->container->compile();

        $this->assertTrue($this->container->hasParameter('s.cache.global.enabled'));
        $this->assertTrue($this->container->getParameter('s.cache.global.enabled'));
    }

    public function testDisabledConfiguration()
    {
        $this->loadConfiguration($this->container, 'disabled');
        $this->container->compile();

        $this->assertTrue($this->container->hasParameter('s.cache.global.enabled'));
        $this->assertFalse($this->container->getParameter('s.cache.global.enabled'));
    }

    public function testEnabledConfiguration()
    {
        $this->loadConfiguration($this->container, 'enabled');
        $this->container->compile();

        $this->assertTrue($this->container->hasParameter('s.cache.global.enabled'));
        $this->assertTrue($this->container->getParameter('s.cache.global.enabled'));
    }
}

/* EOF */
