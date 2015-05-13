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
     * @return array
     */
    public function loadIconByFamilyAndSlug(IconFamily $family, $iconSlug)
    {
        $q = $this
            ->createQueryBuilder('i')
            ->where('i.slug = :slug')
            ->where('i.families MEMBER OF :family')
            ->setParameter('slug', $iconSlug)
            ->setParameter('family', $family)
            ->getQuery()
        ;

        try {
            return $q->getResult();
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

/* EOF */
