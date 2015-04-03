<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Icon\IconTraits;

use Scribe\CacheBundle\Cache\Handler\Chain\HandlerChainAwareTrait;

/**
 * Trait IconCreatorCachedServicesTrait.
 */
trait IconCreatorCachedServicesTrait
{
    use IconCreatorServicesTrait,
        HandlerChainAwareTrait;
}

/* EOF */
