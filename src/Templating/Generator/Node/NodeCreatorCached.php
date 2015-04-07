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

use Scribe\CacheBundle\Cache\Handler\Chain\HandlerChainAwareTrait;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;

/**
 * Class: NodeCreatorCached.
 */
class NodeCreatorCached extends NodeCreator
{
    use HandlerChainAwareTrait;

    /**
     * Render template from Node.
     *
     * @param Node
     * @param array
     *
     * @return string
     */
    public function render(Node $node, $args = [])
    {
        $this
            ->getCacheHandlerChain()
            ->setKey($node->getMaterializedPath())
        ;

        if (null === ($renderedNode = $this->getCacheHandlerChain()->get())) {
            $renderedNode = parent::render($node, $args);
            $this->getCacheHandlerChain()->set($renderedNode);
        }

        return $renderedNode;
    }
}
