<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 * (c) KnpLabs     <http://knplabs.com/>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\RepositoryAware;

use Scribe\MantleBundle\Doctrine\Repository\Node\NodeRepository;

/**
 * Class HierarchicalNodeBehaviorTrait.
 */
trait NodeRepositoryAwareTrait
{
    /**
     * @var NodeRepository
     */
    private $nodeRepository;

    /**
     * Gets the value of nodeRepo.
     *
     * @return NodeRepoRepository
     */
    protected function getNodeRepository()
    {
        return $this->nodeRepository;
    }

    /**
     * Sets the value of nodeRepo.
     *
     * @param NodeRepository $nodeRepo
     *
     * @return $this
     */
    protected function setNodeRepository(NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;

        return $this;
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
                ->getNodeRepository()
                ->{$repoMagicMethod}($criteria)
            ;

            return $node;
        } catch (\Exception $e) {
            $this->unfoundEntityException($field, $criteria, $e);
        }
    }
}

/* EOF */
