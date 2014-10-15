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

use Symfony\Component\DependencyInjection\ContainerAwareTrait as SymfonyContainerAwareTrait;

/**
 * Class ContainerAwareTrait
 *
 * @package Scribe\SharedBundle\DependencyInjection
 */
trait ContainerAwareTrait
{
    use SymfonyContainerAwareTrait;

    /**
     * Getter for container property
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}
