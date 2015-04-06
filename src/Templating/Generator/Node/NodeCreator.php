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

use Scribe\Component\DependencyInjection\Container\ServiceFinder;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;
use Scribe\MantleBundle\Doctrine\Repository\Node\NodeRepository;

/**
 * NodeCreator.
 */
class NodeCreator
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;

    /**
     * @var ServiceFinder
     */
    private $serviceFinder;

    /**
     * Setup the object instance.
     */
    public function __construct(ServiceFinder $serviceFinder, NodeRepository $nodeRepository)
    {
        $this->serviceFinder = $serviceFinder;
        $this->nodeRepository = $nodeRepository;
    }

    /**
     * Adds node title to paired array passed to
     * render function.
     *
     * @param Node
     * @param array
     *
     * @return array
     */
    protected function getFullArgs(Node $node, $args)
    {
        $args['title'] = $node->getTitle();

        return $args;
    }

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
        $nodeRevision = $node->getLatestRevision();
        $content = $nodeRevision->getContent();

        if ($nodeRevision->hasRenderEngine()) {
            $serviceName = $nodeRevision
                ->getRenderEngine()
                ->getService()
            ;
            $fullArgs = $this->getFullArgs($node, $args);
            $engine = $this->findRenderEngineService($serviceName);
            $rendered = $engine->render($content, $fullArgs);

            return $rendered;
        } else {
            return $content;
        }
    }

    /**
     * Lookup node by slug and
     * render template from Node.
     *
     * @param string
     * @param array
     *
     * @return string
     */
    public function renderFromSlug($slug, $args = [])
    {
        $node = $this->findNodeBySlug($slug);
        $content = $this->render($node, $args);

        return $content;
    }

    /**
     * Lookup node by materializedPath and
     * render template from Node.
     *
     * @param string
     * @param array
     *
     * @return string
     */
    public function renderFromMaterializedPath($slug, $args = [])
    {
        $node = $this->findNodeByMaterializedPath($slug);
        $content = $this->render($node, $args);

        return $content;
    }

    /**
     * Find node rendering service by
     * service name, via service finder.
     *
     * @param string
     *
     * @return Object
     *
     * @throws NodeException
     */
    protected function findRenderEngineService($serviceName)
    {
        $finder = $this->serviceFinder;

        try {
            return $finder($serviceName);
        } catch (\Exception $e) {
            throw new NodeException(
                sprintf('The requested node rendering service %s could not be found.', $serviceName),
                NodeException::CODE_MISSING_SERVICE,
                $e
            );
        }
    }

    /**
     * Find node by slug.
     *
     * @param string
     *
     * @throws NodeException
     */
    protected function findNodeBySlug($slug)
    {
        $node = $this->findNodeByField('slug', 'findOneBySlug', $slug);

        return $node;
    }

    /**
     * Find node by materializedPath.
     *
     * @param string
     *
     * @throws NodeException
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
     * @param string
     * @param string
     * @param string
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
