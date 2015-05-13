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
use Doctrine\ORM\NonUniqueResultException;
use Scribe\MantleBundle\Doctrine\Entity\Icon\IconFamily;
use Scribe\MantleBundle\Doctrine\Entity\Icon\IconTemplate;

/**
 * Class IconTemplateRepository.
 */
class IconTemplateRepository extends EntityRepository
{
    /**
     * @param IconFamily $family
     *
     * @throws \Exception
     *
     * @return array
     */
    public function loadHighestPriorityByFamily(IconFamily $family)
    {
        $q = $this
          ->createQueryBuilder('t')
          ->where('t.family = :family')
          ->setParameter('family', $family)
          ->orderBy('t.priority', 'DESC')
          ->setMaxResults(1)
          ->getQuery()
        ;

        try {
            return $q->getResult();
        } catch (NonUniqueResultException $e) {
            throw $e;
        }
    }

    /**
     * @param string $iconTemplateSlug
     *
     * @throws \Exception
     *
     * @return IconTemplate
     */
    public function loadIconTemplateBySlug($iconTemplateSlug)
    {
        $q = $this
          ->createQueryBuilder('i')
          ->where('i.slug = :slug')
          ->setParameter('slug', $iconTemplateSlug)
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
