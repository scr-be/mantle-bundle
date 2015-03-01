<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Scribe\MantleBundle\Entity\IconFamily;

/**
 * NavMenuItemRepository
 *
 * @package Scribe\MantleBundle\Entity
 */
class IconRepository extends EntityRepository
{
    /**
     * loadIconByFamilyAndSlug
     *
     * @param IconFamily $family
     * @param            $iconSlug
     * @return null
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
            foreach($results as $icon) {
                $fams = $icon->getFamilies();
                if(in_array($family, $fams)) {
                    return $icon;
                }
            }
            return null;
        }
        catch(\Exception $e) {
            throw $e;
        }
    }
}
