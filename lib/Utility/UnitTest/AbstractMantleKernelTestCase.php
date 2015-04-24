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
    protected $container;

    /**
     * handle constructing the object instance.
     */
    public function setUp()
    {
        parent::setUp();

        $this
            ->setupKernel()
            ->setupContainer()
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown()
    {
        $this->clearKernelCache();
        $this->container = null;

        static::$kernel->shutdown();

        parent::tearDown();
    }

    /**
     * @return $this
     */
    private function setupKernel()
    {
        static::bootKernel();

        return $this;
    }

    /**
     * @return $this
     */
    private function setupContainer()
    {
        $this->container = static::$kernel->getContainer();

        if (false === ($this->container instanceof ContainerInterface)) {
            throw new \RuntimeException('Unable to obtain a valid Symfony Container instance.');
        }

        return $this;
    }

    /**
     * Clear kernel cache.
     */
    protected function clearKernelCache()
    {
        if (!$this->container instanceof ContainerInterface) {
            return;
        }

        $cacheDir = $this->container->getParameter('kernel.cache_dir');

        if (true === is_dir($cacheDir)) {
            $this->removeDirectory($cacheDir);
        }
    }
}
