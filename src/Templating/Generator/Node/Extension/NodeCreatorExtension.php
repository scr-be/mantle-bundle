<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Node\Extension;

use Scribe\MantleBundle\Doctrine\Entity\Node\Node;
use Scribe\MantleBundle\Templating\Generator\Node\Model\NodeCreatorInterface;
use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;

/**
 * Class NodeCreatorExtension.
 */
class NodeCreatorExtension extends AbstractTwigExtension
{
    /**
     * @var NodeCreatorInterface
     */
    private $nodeCreator;

    /**
     * @param NodeCreatorInterface $nodeCreator
     *
     * @internal param NodeCreatorInterface $container
     */
    public function __construct(NodeCreatorInterface $nodeCreator)
    {
        parent::__construct();

        $this->nodeCreator = $nodeCreator;

        $this
            ->enableOptionHtmlSafe()
            ->enableOptionNeedsEnv()
        ;

        $this->addFunction('get_node',                        [$this, 'getNode']);
        $this->addFunction('get_node_from_slug',              [$this, 'getNodeFromSlug']);
        $this->addFunction('get_node_by_slug',                [$this, 'getNodeFromSlug']);

        $this->addFunction('get_node_from_materialized_path', [$this, 'getNodeFromMaterializedPath']);
        $this->addFunction('get_node_by_path',                [$this, 'getNodeFromMaterializedPath']);
    }

    /**
     * @param Node  $node
     * @param array $args
     *
     * @return string
     */
    public function getNode(Node $node, $args = [])
    {
        return (string) $this->nodeCreator->render($node, $args);
    }

    /**
     * @param string $slug
     * @param array  $args
     *
     * @return string
     */
    public function getNodeFromSlug($slug, $args = [])
    {
        return (string) $this->nodeCreator->renderFromSlug($slug, $args);
    }

    /**
     * @param string $materializedPath
     * @param array  $args
     *
     * @return string
     */
    public function getNodeFromMaterializedPath($materializedPath, $args = [])
    {
        return (string) $this->nodeCreator->renderFromMaterializedPath($materializedPath, $args);
    }
}

/* EOF */
