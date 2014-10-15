<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Extension;

use Scribe\SharedBundle\Templating\Extension\Part\ConfigExtensionTrait;
use Scribe\SharedBundle\Templating\Extension\Part\SimpleExtensionTrait;
use Scribe\SharedBundle\Utility\Config\ConfigInterface;
use Twig_Extension;

/**
 * ContainerExtension
 */
class ConfigExtension extends Twig_Extension
{
    /**
     * @see ConfigExtensionTrait
     * @see SimpleExtentionTrait
     */
    use ConfigExtensionTrait,
        SimpleExtensionTrait;

    /**
     * @param ConfigInterface $config
     */
    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
        $this->init('get_config_yml', 'getConfig');
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            'get_config_yml' => new \Twig_Function_Method(
                $this,
                'getConfig',
                ['is_safe' => ['html']]
            ),
            'get_config' => new \Twig_Function_Method(
                $this,
                'getConfig',
                ['is_safe' => ['html']]
            )

        ];
    }
}
