<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Config;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Scribe\Component\DependencyInjection\ContainerAwareTrait;
use Scribe\Exception\RuntimeException;

/**
 * Class ConfigContainer.
 */
class ConfigContainer implements ConfigInterface, ContainerAwareInterface
{
    /*
     * import container property and get/set functions
     */
    use ContainerAwareTrait;

    /**
     * setup with container instance.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
    }

    /**
     * Getter for YAML config value.
     *
     * @param string $key config key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $this
            ->getContainer()
            ->getParameter($key)
        ;
    }

    /**
     * Setter for YAML config cannot occur.
     *
     * @param string $key config key
     * @param mixed  $value config value
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function set($key, $value)
    {
        throw new RuntimeException('Cannot set YAML config');
    }
}

/* EOF */
