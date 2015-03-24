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

use Scribe\MantleBundle\Templating\Extension\Part\ConfigExtensionTrait;
use Scribe\MantleBundle\Templating\Extension\Part\SimpleExtensionTrait;
use Scribe\Utility\Config\ConfigInterface;
use Twig_Extension;

/**
 * ContainerExtension.
 */
class ConfigExtension extends Twig_Extension
{
    /*
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
            ),

        ];
    }
}
