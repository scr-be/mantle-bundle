<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Extension;

use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;
use Scribe\Utility\Config\ConfigInterface;

/**
 * ContainerExtension.
 */
class ConfigExtension extends AbstractTwigExtension
{
    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        parent::__construct();

        $this->config = $config;

        $this->enableOptionHtmlSafe();

        $this->addFunction('get_config_yml', [$this, 'getConfig']);
        $this->addFunction('get_config',     [$this, 'getConfig']);
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getConfig($key)
    {
        return $this->config->get($key);
    }
}
