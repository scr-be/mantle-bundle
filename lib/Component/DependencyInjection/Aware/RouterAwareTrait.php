<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection\Aware;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RouterAwareTrait.
 */
trait RouterAwareTrait
{
    /**
     * Instance of router object.
     *
     * @var RouterInterface|null
     */
    protected $router = null;

    /**
     * Setter for router property from container.
     *
     * @param ContainerInterface $container container object
     *
     * @return $this
     */
    public function setRouterFromContainer(ContainerInterface $container)
    {
        $this->setRouter($container->get('router'));

        return $this;
    }

    /**
     * Setter for router property.
     *
     * @param RouterInterface|null $router instance of router object
     *
     * @return $this
     */
    public function setRouter(RouterInterface $router = null)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * Getter for router property.
     *
     * @return RouterInterface|null
     */
    public function getRouter()
    {
        return $this->router;
    }
}

/* EOF */
