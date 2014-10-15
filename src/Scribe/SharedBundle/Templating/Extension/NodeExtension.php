<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Extension;

use Scribe\SharedBundle\Templating\Extension\Part\AdvancedExtensionTrait;
use Scribe\LearningBundle\Entity\NodeRepository;
use Twig_Extension;

/**
 * Class NodeExtension
 */
class NodeExtension extends Twig_Extension
{
    use AdvancedExtensionTrait;

    /**
     * @var NodeRepository
     */
    private $nodeRepo;

    /**
     * constructor
     */
    public function __construct(NodeRepository $nodeRepo)
    {
        $this->nodeRepo = $nodeRepo;
        $this->addFunctionMethod('getNode', 'get_node');
        $this->addFunctionMethod('getNodeContent', 'get_node_content');
    }

    /**
     * @param  string $k
     * @param  string $context
     * @return \Scribe\LearningBundle\Entity\Node|null
     */
    public function getNode($k, $context)
    {
        $node = $this
            ->nodeRepo
            ->findOneByKInContext($k, $context)
        ;

        return $node;
    }

    /**
     * @param  string $k
     * @param  string $context
     * @return string
     */
    public function getNodeContent($k, $context)
    {
        return $this
            ->getNode($k, $context)
            ->getContent()
        ;
    }
}
