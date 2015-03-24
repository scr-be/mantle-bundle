<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait as SymfonyContainerAwareTrait;

/**
 * Class ContainerAwareTrait.
 */
trait ContainerAwareTrait
{
    /*
     * Build off Symfony's build-in Container aware trait and include methods to
     * both get the container and check if a container has been set.
     *
     * @see Symfony\Component\DependencyInjection\ContainerAwareTrait
     */
    use SymfonyContainerAwareTrait;

    /**
     * Getter for container property.
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Checker for container property.
     *
     * @return bool
     */
    public function hasContainer()
    {
        return (bool) ($this->container instanceof ContainerInterface);
    }
}

/* EOF */
