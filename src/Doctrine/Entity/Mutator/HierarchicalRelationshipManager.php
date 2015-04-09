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
use Scribe\MantleBundle\Doctrine\RepositoryAware\NodeRepositoryAwareTrait;
use Scribe\MantleBundle\Entity\Mutator\HierarchicalRelationshipException;

/**
 * Class HierarchicalRelationshipManager.
 */
class HierarchicalRelationshipManager
{
    use EntityManagerForwardableTrait,
        NodeRepositoryAwareTrait;

    /**
     * Object initialization.
     */
    public function __construct(EntityManager $entityManager, NodeRepository $nodeRepo)
    {
        $this
            ->setEntityManager($entityManager)
            ->setNodeRepository($nodeRepo)
        ;
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
        $this
            ->recursivelyDeleteBranch($node)
            ->flush()
        ;

        return $this;
    }

    /**
     * Finds node by slug.
     * Deletes node and recursively deletes children
     * of node, their children, etc. Treats given node
     * as entire branch to be trimmed. Flushes changes.
     *
     * @param string $slug
     *
     * @return $this
     */
    public function deleteAndCascadeBySlug($slug)
    {
        $node = $this->findNodeBySlug($slug);

        $this->deleteAndCascade($node);

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
        foreach ($node->getChildNodes() as $child) {
            $this->recursivelyDeleteBranch($child);
        }
        $this->remove($node);

        return $this;
    }

    /**
     * Deletes given node and moves all children
     * up the chain, setting the children of node
     * as children of node's parent. Resets all
     * descendant relationships so materialized
     * paths stay intact.
     *
     * @param Node $node
     *
     * @return $this
     */
    public function deleteAndReparentChildren(Node $node)
    {
        if (false === $node->isRootNode()) {
            $this->reparentChildrenUpBranch($node);
        }

        $this
            ->remove($node)
            ->flush()
        ;

        return $this;
    }

    /**
     * Sets children of node as children of node's
     * parent, then calls recursive method to ensure
     * integrity of descendant relationships.
     *
     * @param Node $node
     *
     * @return $this
     */
    protected function reparentChildrenUpBranch(Node $node)
    {
        $parent = $node->getParentNode();
        foreach ($node->getChildNodes() as $child) {
            $child->setChildNodeOf($parent);
            $this->recursivelyResetRelationships($child);
        }

        return $this;
    }

    /**
     * Recursively resestablishes parentage to
     * maintain materialized path integrity.
     *
     * @param Node $node
     *
     * @return $this
     */
    protected function recursivelyResetRelationships(Node $node)
    {
        foreach ($node->getChildNodes() as $child) {
            $child->setChildNodeOf($node);
            $this->recursivelyResetRelationships($child);
        }

        return $this;
    }

    /**
     * Sets given node as a root node.
     * Recursively resestablishes parentage to
     * maintain materialized path integrity.
     *
     * @param Node $node
     *
     * @return $this
     */
    public function setAsRoot(Node $node)
    {
        $node->setAsRoot();
        foreach ($node->getChildNodes() as $child) {
            $child->setChildNodeOf($node);
            $this->recursivelyResetRelationships($child);
        }
        $this->flush();

        return $this;
    }

    /**
     * Ensures materializedPath and paths for all children
     * are correct according to slug of given node. Triggers
     * slug event first to ensure slug is set.
     *
     * @author Me
     */
    public function updateAndCascade(Node $node)
    {
        $node->triggerGenerateSlugEvent();
        $newPath =
            ($node->isRootNode() ? '' : $node->getParentMaterializedPath()).
            $node->getMaterializedPathSeparator().$node->getSlug()
        ;
        $node->setMaterializedPath($newPath);

        $this
            ->recursivelyResetRelationships($node)
            ->flush()
        ;

        return $this;
    }

    protected function unfoundEntityException($field, $criteria, $e)
    {
        throw new HierarchicalRelationshipException(
            sprintf('Node with %s %s could not be found.', $field, $criteria),
            HierarchicalRelationshipException::CODE_MISSING_ENTITY,
            $e
        );
    }
}
