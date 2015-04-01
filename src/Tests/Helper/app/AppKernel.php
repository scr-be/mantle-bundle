<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * Class AppKernel.
 */
class AppKernel extends \Symfony\Component\HttpKernel\Kernel
{
    /**
     * Return array of bundles requires for tests.
     *
     * @return array
     */
    public function registerBundles()
    {
        $bundles = [
            new \Symfony\Bundle\MonologBundle\MonologBundle(),
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(),
            new \Scribe\CacheBundle\ScribeCacheBundle(),
            new \Scribe\MantleBundle\ScribeMantleBundle(),
            new \Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'])) {
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    /**
     * Load the required config file based on the environment.
     *
     * @param \Symfony\Component\Config\Loader\LoaderInterface $loader
     */
    public function registerContainerConfiguration(\Symfony\Component\Config\Loader\LoaderInterface $loader)
    {
        $loader->load(
            __DIR__ . '/config/config_' . $this->getEnvironment() . '.yml'
        );
    }

    /**
     * @throws Exception
     */
    protected function initializeContainer()
    {
        parent::initializeContainer();

        return;

        static $first = true;

        if ('test' !== $this->getEnvironment()) {
            parent::initializeContainer();

            return;
        }

        $debug = $this->debug;

        if (!$first) {
            $this->debug = false;
        }

        $first = false;

        try {
            parent::initializeContainer();
        } catch (\Exception $e) {
            $this->debug = $debug;
            throw $e;
        }

        $this->debug = $debug;
    }
}

/* EOF */
