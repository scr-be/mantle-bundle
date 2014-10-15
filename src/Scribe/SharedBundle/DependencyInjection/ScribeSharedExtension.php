<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Scribe\Component\DependencyInjection\Extension;
use Symfony\Component\Config\FileLocator;

/**
 * Class ScribeSharedExtension
 *
 * @package Scribe\SharedBundle\DependencyInjection
 */
class ScribeSharedExtension extends Extension
{
    /**
     * Load the configuration from the yaml config based on definitions defined
     * within the {@see Configuration.php} file.
     *
     * @param  array            $configs   the configs to load
     * @param  ContainerBuilder $container symfony container for configurations
     * @return void
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->setContainer($container);

        $configuration = new Configuration();
        $config = $this->processConfiguration(
            $configuration,
            $configs
        );

        $this->processConfigToParameter($config);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('services.yml');
    }
}
