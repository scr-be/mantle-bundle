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

/**
 * Class ServiceContainerAwareTrait.
 */
trait ServiceContainerAwareTrait
{
    /**
     * @var ContainerInterface
     */
    protected $serviceContainer;

    /**
     * Getter for container property.
     *
     * @return ContainerInterface
     */
    public function getServiceContainer()
    {
        return $this->serviceContainer;
    }

    /**
     * @param ContainerInterface $container
     *
     * @return $this
     */
    public function setServiceContainer(ContainerInterface $container)
    {
        $this->serviceContainer = $container;

        return $this;
    }
}

/* EOF */
