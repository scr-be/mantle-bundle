<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Observer;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Scribe\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Class ObserverContainerAware
 *
 * @package Scribe\Utility\Observer
 */
abstract class ObserverContainerAware extends Observer implements ContainerAwareInterface
{
    use ContainerAwareTrait;
}
