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

use Symfony\Component\DependencyInjection\ContainerInterface;
use Scribe\WonkaBundle\Component\Templating\AbstractTwigExtension;
use Scribe\WonkaBundle\Component\DependencyInjection\Container\ContainerAwareTrait;

/**
 * Class ParameterExtension.
 */
class ParameterExtension extends AbstractTwigExtension
{
    use ContainerAwareTrait;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();

        $this->setContainer($container);

        $this
            ->enableOptionHtmlSafe()
            ->addFunction('param', [ $this, 'getParameter' ]);
    }

    /**
     * @param string      $key
     * @param null|string $inner
     *
     * @return mixed
     */
    public function getParameter($key, $inner = null)
    {
        $parameter = $this->getContainerParameter($key);

        if ($inner !== null && is_array($parameter)) {
            $parameter = $this->getParameterArrayInnerValue($parameter, $inner);
        }

        return $parameter;
    }

    /**
     * @param array  $parameter
     * @param string $inner
     *
     * @return mixed
     */
    protected function getParameterArrayInnerValue(array $parameter, $inner)
    {
        $keySet     = explode('.', $inner);
        $resolution = $parameter;

        foreach ($keySet as $key) {
            if (!array_key_exists($key, $resolution)) { return null; }
            $resolution = $resolution[$key];
        }

        return $resolution;
    }
}

/* EOF */
