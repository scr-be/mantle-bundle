<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Node;

use Scribe\CacheBundle\DependencyInjection\Aware\CacheChainAwareTrait;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;

/**
 * Class: NodeCreatorCached.
 */
class NodeCreatorCached extends NodeCreator
{
    use CacheChainAwareTrait;

    /**
     * Render template from Node, caching enabled.
     *
     * @param Node  $node
     * @param array $args
     *
     * @return string
     */
    public function render(Node $node, array $args = [])
    {
        if (null === ($renderedNode = $this->getCacheChain()->get($node->getMaterializedPath()))) {
            $renderedNode = parent::render($node, $args);
            $this->getCacheChain()->set($renderedNode, $node->getMaterializedPath());
        }

        return $renderedNode;
    }
}
