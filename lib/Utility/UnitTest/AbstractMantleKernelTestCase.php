<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\UnitTest;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class AbstractMantleKernelTestCase.
 *
 * Extension of Symfony's KernelTestCase that implements the basic logic to setup and tear down the Kernel.
 */
abstract class AbstractMantleKernelTestCase extends KernelTestCase
{
    use MantleTestCaseTrait;

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public $container;

    public function setUp()
    {
        $this->setupKernel();
        $this->setupContainer();
    }

    public function setupKernel()
    {
        self::bootKernel();
    }

    public function setupContainer()
    {
        $this->container = static::$kernel->getContainer();
    }

    public function tearDown()
    {
        $this->clearKernelCache();
    }

    public function clearKernelCache()
    {
        return;

        if (!$this->container instanceof ContainerInterface) {
            return;
        }

        $cacheDir = $this->container->getParameter('kernel.cache_dir');

        if (true === is_dir($cacheDir)) {
            $this->removeDirectory($cacheDir);
        }

        parent::tearDown();
    }
}
