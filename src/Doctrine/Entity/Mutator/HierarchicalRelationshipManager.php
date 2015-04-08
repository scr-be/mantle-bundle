<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Entity\Mutator;

use Doctrine\ORM\EntityManager;
use Scribe\MantleBundle\Doctrine\Repository\Node\NodeRepository;
use Scribe\MantleBundle\Doctrine\Entity\Node\Node;
use Scribe\Doctrine\Manager\EntityManagerForwardableTrait;

/**
 * Class HierarchicalRelationshipManager.
 */
class HierarchicalRelationshipManager 
{
    use EntityManagerForwardableTrait;

    /**
     * @var string
     */
    private $nodeRepo;

    /**
     * Object initialization.
     */
    public function __construct(EntityManager $entityManager, NodeRepository $nodeRepo)
    {
        $this
            ->setEntityManager($entityManager)        
            ->setNodeRepo($nodeRepo)
        ;
    }

    /**
     * Gets the value of nodeRepo
     *
     * @return nodeRepo
     */
    protected function getNodeRepo()
    {
        return $this->nodeRepo;
    }

    /**
     * Sets the value of nodeRepo
     *
     * @param NodeRepository $nodeRepo
     *
     * @return $this
     */
    protected function setNodeRepo(NodeRepository $nodeRepo)
    {
        $this->nodeRepo = $nodeRepo;

        return $this;
    }

    /**
     * Deletes node and recursively deletes children
     * of node, their children, etc. Treats given node
     * as entire branch to be trimmed. Flushes changes.
     *
     * @param Node $node
     *
     * @return $this
     */
    public function deleteAndCascade(Node $node)
    {
        $this->recursivelyDeleteBranch($node);
        $this->flush();

        return $this;
    }

    /**
     * Recursively calls remove on branch.
     *
     * @param Node $node
     *
     * @return $this
     */
    protected function recursivelyDeleteBranch(Node $node)
    {
        foreach($node->getChildNodes() as $child) {
            $this->recursivelyDeleteBranch($child);
        }
        $this->remove($node);
 
        return $this; 
    }
}
