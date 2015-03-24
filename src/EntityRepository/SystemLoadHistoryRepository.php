<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

/**
 * Class SystemLoadHistoryRepository.
 */
class SystemLoadHistoryRepository extends EntityRepository
{
    public function loadLatestOrderByDate($limit = 1)
    {
        $q = $this
            ->createQueryBuilder('l')
            ->orderBy('l.date', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
        ;

        $loadHistory = $q->getResult();

        if ($limit === 1 && count($loadHistory) > 0) {
            return $loadHistory[0];
        }

        return $loadHistory;
    }
}

/* EOF */
