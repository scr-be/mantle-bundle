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

use Scribe\MantleBundle\Templating\Generator\Node\Rendering\NodeRendererRegistrar;
use Scribe\MantleBundle\Doctrine\Repository\Node\NodeRepository;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;

/**
 * Interface NodeInterface.
 */
interface NodeCreatorInterface
{
    /**
     * @param NodeRepository        $nodeRepository
     * @param NodeRendererRegistrar $rendererRegistrar
     */
    public function __construct(NodeRepository $nodeRepository, NodeRendererRegistrar $rendererRegistrar);

    /**
     * Render template from Node.
     *
     * @param Node  $node
     * @param array $args
     *
     * @return string
     */
    public function render(Node $node, array $args = []);

    /**
     * Lookup node by slug and render template from Node.
     *
     * @param string $slug
     * @param array  $args
     *
     * @return string
     */
    public function renderFromSlug($slug, array $args = []);

    /**
     * Lookup node by materializedPath and render template from Node.
     *
     * @param string $slug
     * @param array  $args
     *
     * @return string
     */
    public function renderFromMaterializedPath($slug, array $args = []);
}

/* EOF */
