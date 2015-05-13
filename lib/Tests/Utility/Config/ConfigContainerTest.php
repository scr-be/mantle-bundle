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

use Scribe\Utility\UnitTest\AbstractMantleKernelTestCase;
use Scribe\Utility\Config\ConfigContainer;

class ConfigContainerTest extends AbstractMantleKernelTestCase
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
        static::assertEquals([], $this->config->get('s.mantle.maintenance.bundles'));
        static::assertEquals(
            'Symfony\Component\HttpKernel\Controller\TraceableControllerResolver',
            $this->config->get('debug.controller_resolver.class')
        );
    }
}

/* EOF */
