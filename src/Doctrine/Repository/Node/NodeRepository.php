<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Repository\Node;

use Doctrine\ORM\EntityRepository;
use Scribe\Doctrine\Behavior\Repository\Hierarchical\HierarchicalNodeTreeBehaviorTrait;

/**
 * Class NodeRepository.
 */
class NodeRepository extends EntityRepository
{
    use HierarchicalNodeTreeBehaviorTrait;

    /**
     * @param $slug
     *
     * @return mixed
     *
     * @throws \Exception
     *
     * @todo move this into SlugAwareRepoTrait
     */
    public function loadBySlug($slug)
    {
        $q = $this
          ->createQueryBuilder('i')
          ->where('i.slug = :slug')
          ->setParameter('slug', $slug)
          ->setMaxResults(1)
          ->getQuery()
        ;

        try {
            return $q->getSingleResult();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $materializedPath
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public function loadByMaterializedPath($materializedPath)
    {
        $q = $this
          ->createQueryBuilder('i')
          ->where('i.materializedPath= :materializedPath')
          ->setParameter('materializedPath', $materializedPath)
          ->setMaxResults(1)
          ->getQuery()
        ;

        try {
            return $q->getSingleResult();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

/* EOF */
