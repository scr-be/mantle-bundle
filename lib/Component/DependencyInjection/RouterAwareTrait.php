<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RouterAwareTrait
 *
 * @package Scribe\SharedBundle\DependencyInjection\Traits
 */
trait RouterAwareTrait
{
    /**
     * Instance of router object
     *
     * @var RouterInterface|null
     */
    protected $router = null;

    /**
     * Setter for router property from container
     *
     * @param ContainerInterface $container container object
     */
    public function setRouterFromContainer(ContainerInterface $container)
    {
        $this->setRouter($container->get('router'));
    }

    /**
     * Setter for router property
     *
     * @param  RouterInterface|null $router instance of router object
     * @return $this
     */
    public function setRouter(RouterInterface $router = null)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * Getter for router property
     *
     * @return RouterInterface|null
     */
    public function getRouter()
    {
        return $this->router;
    }
}
