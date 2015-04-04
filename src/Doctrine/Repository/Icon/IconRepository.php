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
 * NavMenuItemRepository.
 */
class IconRepository extends EntityRepository
{
    /**
     * loadIconByFamilyAndSlug.
     *
     * @param IconFamily $family
     * @param            $iconSlug
     *
     * @throws \Exception
     */
    public function loadIconByFamilyAndSlug(IconFamily $family, $iconSlug)
    {
        $q = $this
          ->createQueryBuilder('i')
          ->where('i.slug = :slug')
          ->setParameter('slug', $iconSlug)
          ->getQuery()
        ;

        try {
            $results = $q->getResult();
            foreach ($results as $icon) {
                $fams = $icon->getFamilies();
                if (in_array($family, $fams)) {
                    return $icon;
                }
            }

            return;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}

/* EOF */
