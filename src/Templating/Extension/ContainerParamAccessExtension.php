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

use Scribe\WonkaBundle\Component\DependencyInjection\Container\ContainerAwareTrait;
use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ContainerExtension.
 */
class ContainerParamAccessExtension extends AbstractTwigExtension
{
    use ContainerAwareTrait;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->setContainer($container);

        $this->enableOptionHtmlSafe();

        $this->addFunction('param',          [$this, 'getParameter']);
        $this->addFunction('get_param',      [$this, 'getParameter']);
        $this->addFunction('get_config',     [$this, 'getParameter']);
        $this->addFunction('get_config_yml', [$this, 'getParameter']);
    }

    /**
     * @param string $parameterKey
     *
     * @return mixed
     */
    public function getParameter($parameterKey)
    {
        return false === $this->hasContainerParameter($parameterKey) ? null : $this->getContainerParameter($parameterKey);
    }
}

/* EOF */
