<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Observer;

use Scribe\Component\DependencyInjection\Container\ContainerAwareInterface;
use Scribe\Component\DependencyInjection\Container\ContainerAwareTrait;

/**
 * Class ObserverContainerAware.
 */
abstract class ObserverContainerAware extends ObserverAbstract implements ContainerAwareInterface
{
    use ContainerAwareTrait;
}

/* EOF */
