<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Repository\Icon;

use Doctrine\ORM\EntityRepository;

/**
 * Class IconFamilyRepository.
 */
class IconFamilyRepository extends EntityRepository
{
    /**
     * @param string $slug
     *
     * @throws \Exception
     *
     * @return mixed
     */
    public function loadIconFamilyBySlug($slug)
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
}

/* EOF */
