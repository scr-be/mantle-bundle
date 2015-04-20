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

use Scribe\MantleBundle\Doctrine\Entity\Node\Node;
use Scribe\MantleBundle\Templating\Extension\Part\AdvancedExtensionTrait;

/**
 * Class NodeCreatorExtension.
 */
class NodeCreatorTwigExtension extends \Twig_Extension
{
    use AdvancedExtensionTrait;

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
        $this->nodeCreator = $nodeCreator;

        $this->setParameters([
            'is_safe'           => ['html'],
            'needs_environment' => true,
        ]);

        $this->addFunctionMethod('getNode', 'get_node');
        $this->addFunctionMethod('getNodeFromSlug', 'get_node_from_slug');
        $this->addFunctionMethod('getNodeFromMaterializedPath', 'get_node_from_materialized_path');
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
