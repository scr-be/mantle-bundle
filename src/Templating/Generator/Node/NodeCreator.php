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
use Scribe\MantleBundle\Doctrine\Repository\Node\NodeRepository;
use Scribe\MantleBundle\Templating\Generator\Node\Rendering\NodeRendererInterface;
use Scribe\MantleBundle\Templating\Generator\Node\Rendering\NodeRendererRegistrar;

/**
 * Class NodeCreator.
 */
class NodeCreator implements NodeCreatorInterface
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;

    /**
     * @var NodeRendererRegistrar
     */
    private $rendererRegistrar;

    /**
     * @param NodeRepository        $nodeRepository
     * @param NodeRendererRegistrar $rendererRegistrar
     */
    public function __construct(NodeRepository $nodeRepository, NodeRendererRegistrar $rendererRegistrar)
    {
        $this->nodeRepository = $nodeRepository;
        $this->rendererRegistrar = $rendererRegistrar;
    }

    /**
     * Adds node title to paired array passed to
     * render function.
     *
     * @param Node  $node
     * @param array $args
     *
     * @return array
     */
    protected function getFullArgs(Node $node, array $args = [])
    {
        $args['title'] = $node->getTitle();

        return $args;
    }

    /**
     * Render template from Node.
     *
     * @param Node  $node
     * @param array $args
     *
     * @return string
     */
    public function render(Node $node, array $args = [])
    {
        $nodeRevision = $node->getLatestRevision();
        $content = $nodeRevision->getContent();

        if ($nodeRevision->hasRenderEngine()) {
            $rendererSlug = $nodeRevision
                ->getRenderEngine()
                ->getSlug()
            ;

            $fullArgs = $this->getFullArgs($node, $args);

            $rendered = $this
                ->findRenderer($rendererSlug)
                ->render($content, $fullArgs)
            ;

            return $rendered;
        }

        return $content;
    }

    /**
     * Lookup node by slug and render template from Node.
     *
     * @param string $slug
     * @param array  $args
     *
     * @return string
     */
    public function renderFromSlug($slug, array $args = [])
    {
        $node = $this->findNodeBySlug($slug);

        return $this->render($node, $args);
    }

    /**
     * Lookup node by materializedPath and render template from Node.
     *
     * @param string $slug
     * @param array  $args
     *
     * @return string
     */
    public function renderFromMaterializedPath($slug, array $args = [])
    {
        $node = $this->findNodeByMaterializedPath($slug);

        return $this->render($node, $args);
    }

    /**
     * Find node rendering service by service name, via service finder.
     *
     * @param string $rendererSlug
     *
     * @throws NodeException If the requested rendering engine type cannot be found.
     *
     * @return NodeRendererInterface
     */
    protected function findRenderer($rendererSlug)
    {
        $renderer = $this
            ->rendererRegistrar
            ->getHandler($rendererSlug)
        ;

        if ($renderer instanceof NodeRendererInterface) {
            return $renderer;
        }

        throw new NodeException(
            sprintf('Could not find a renderer for the requested type template type of "%s".', $rendererSlug),
            NodeException::CODE_MISSING_SERVICE
        );
    }

    /**
     * Find node by slug.
     *
     * @param string $slug
     */
    protected function findNodeBySlug($slug)
    {
        $node = $this->findNodeByField('slug', 'findOneBySlug', $slug);

        return $node;
    }

    /**
     * Find node by materializedPath.
     *
     * @param string $materializedPath
     */
    protected function findNodeByMaterializedPath($materializedPath)
    {
        $node = $this->findNodeByField('materializedPath', 'findOneByMaterializedPath', $materializedPath);

        return $node;
    }

    /**
     * Generic method for finding node based on given
     * field and value.
     *
     * @param string $field
     * @param string $repoMagicMethod
     * @param string $criteria
     *
     * @throws NodeException
     */
    protected function findNodeByField($field, $repoMagicMethod, $criteria)
    {
        try {
            $node = $this
                ->nodeRepository
                ->{$repoMagicMethod}($criteria)
            ;

            return $node;
        } catch (\Exception $e) {
            throw new NodeException(
                sprintf('Node with %s %s could not be found.', $field, $criteria),
                NodeException::CODE_MISSING_ENTITY,
                $e
            );
        }
    }
}

/* EOF */
