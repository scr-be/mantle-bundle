<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Config;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Scribe\Component\DependencyInjection\ContainerAwareTrait;
use Scribe\Exception\RuntimeException;

/**
 * Class ConfigContainer
 *
 * @package Scribe\Utility\Config
 */
class ConfigContainer implements ConfigInterface, ContainerAwareInterface
{
    /**
     * import container property and get/set functions
     */
    use ContainerAwareTrait;

    /**
     * setup with container instance
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    /**
     * Getter for YAML config value
     *
     * @param  string $key   config key
     * @throws bool
     */
    public function get($key)
    {
        return $this
            ->getContainer()
            ->getParameter($key)
        ;
    }

    /**
     * Setter for YAML config cannot occur
     *
     * @param  string $key   config key
     * @param  mixed  $value config value
     * @throws RuntimeException
     */
    public function set($key, $value)
    {
        throw new RuntimeException('Cannot set YAML config');
    }
}
