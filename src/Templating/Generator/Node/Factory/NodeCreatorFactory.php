<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Node\Factory;

use Scribe\Component\DependencyInjection\Container\ServiceFinder;
use Scribe\MantleBundle\Templating\Generator\Node\Model\NodeCreatorInterface;

/**
 * Class NodeCreatorFactory.
 */
class NodeCreatorFactory
{
    /**
     * Service name of Node Creator without caching.
     *
     * @var string
     */
    const NODE_CREATOR_CACHING_DISABLED = 's.mantle.node_creator_caching_disabled';

    /**
     * Service name of Node Creator with caching.
     *
     * @var string
     */
    const NODE_CREATOR_CACHING_ENABLED = 's.mantle.node_creator_caching_enabled';

    /**
     * @param ServiceFinder $serviceFinder
     * @param bool          $cacheEnabled
     *
     * @return NodeCreatorInterface
     */
    public static function getNodeRenderer(ServiceFinder $serviceFinder, $cacheEnabled = true)
    {
        if (true === $cacheEnabled) {
            return $serviceFinder(self::NODE_CREATOR_CACHING_ENABLED);
        }

        return $serviceFinder(self::NODE_CREATOR_CACHING_DISABLED);
    }
}

/* EOF */
