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
use Scribe\MantleBundle\Doctrine\Entity\Icon\IconFamily;
use Scribe\MantleBundle\Doctrine\Entity\Icon\Icon;

/**
 * Class IconRepository.
 */
class IconRepository extends EntityRepository
{
    /**
     * @param IconFamily $family
     * @param string     $iconSlug
     *
     * @throws \Exception
     *
     * @return Icon|null
     */
    public function loadIconByFamilyAndSlug(IconFamily $family, $iconSlug)
    {
        $q = $this
            ->createQueryBuilder('i')
            ->where('i.slug = :slug')
            ->andWhere(':family MEMBER OF i.familyCollection')
            ->setParameters([
                'slug' => $iconSlug,
                'family' => $family
            ])
            ->setMaxResults(1)
            ->getQuery()
        ;

        try {
            return $q->getSingleResult();
        } catch (\Exception $e) {
            return null;
        }
    }
}

/* EOF */
