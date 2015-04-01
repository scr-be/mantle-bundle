<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Tests\Utility\Config;

use Scribe\Tests\Helper\MantleFrameworkKernelHelper;
use Scribe\Utility\Config\ConfigContainer;

class ConfigContainerTest extends MantleFrameworkKernelHelper
{
    /**
     * @var ConfigContainer
     */
    protected $config;

    public function setUp()
    {
        parent::setUp();

        $this->config = new ConfigContainer($this->container);
    }

    public function testGetParameter()
    {
        $this->assertEquals([], $this->config->get('scribe.maintenance.bundles'));
        $this->assertEquals('Symfony\Component\HttpKernel\Controller\TraceableControllerResolver', $this->config->get('debug.controller_resolver.class'));
    }

    public function testSetParameter()
    {
        $this->setExpectedException(
            'Scribe\Exception\RuntimeException',
            'Cannot set YAML config'
        );

        $this->config->set('key', 'val');
    }
}

/* EOF */
