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

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Scribe\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ObserverContainerAware.
 */
abstract class ObserverContainerAware extends Observer implements ContainerAwareInterface
{
    use ContainerAwareTrait;
}

/* EOF */
