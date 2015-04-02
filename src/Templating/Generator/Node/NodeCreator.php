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

use Scribe\MantleBundle\Entity\Node;
use Scribe\MantleBundle\EntityRepository\NodeRepository;

/**
 * NodeCreator.
 */
class NodeCreator
{
    /**
     * @var string
     */
    private $nodeRepository;

    /**
     * @var string
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
     * render function
     *
     * @param Node
     * @param array
     * @return array 
     */
    protected function getFullArgs(Node $node, $args)
    {
         $args['title'] = $node->getTitle();

         return $args;
    }

    /**
     * Render twig template from Node
     *
     * @param Node
     * @param array
     * @return string 
     */
    public function render(Node $node, $args = array())
    {
        $nodeRevision = $node->getLatestRevision();
        $content = $nodeRevision->getContent();

        if ($nodeRevision->hasRenderEngine()) {
            $engineType = $nodeRevision
                ->getRenderEngine()
                ->getService()
            ;
            $fullArgs = $this->getFullArgs($node, $args);
            $finder = $this->serviceFinder;
            $engine = $finder($engineType);
            $rendered = $engine->render($content, $fullArgs);

            return $rendered;
        } else {

            return $content;
        }
    }

    /**
     * Lookup node by slug and 
     * render twig template from Node
     *
     * @param string 
     * @param array
     * @return string 
     */
    public function renderFromSlug($slug, $args = array())
    {
        $node = $this->findNodeBySlug($slug);
        $content = $this->render($node, $args);

        return $content;
    }

    /**
     * Find node by slug
     *
     * @param string
     * @return void
     *
     * @throws NodeException
     */
    public function findNodeBySlug($slug)
    {
        try {
            $node = $this
                ->nodeRepository
                ->findOneBySlug($slug) 
            ;

            return $node;
        } catch (\Exception $e) {
            throw new NodeException(
                sprintf("Node with slug %s could not be found.", $slug),
                NodeException::CODE_MISSING_ENTITY,
                $e
            );
        } 
    }
}
