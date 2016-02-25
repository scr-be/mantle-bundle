<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Repository\Translation;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Scribe\MantleBundle\Doctrine\Entity\Meta\MetaTitle;
use Scribe\MantleBundle\Doctrine\Exception\ORMException;

/**
 * Class TranslationDomainRepository.
 */
class TranslationDomainRepository extends EntityRepository
{
    /**
     * @param string $domain
     *
     * @throws ORMException If no valid entries are found or other ORM error occurs.
     *
     * @return MetaTitle
     */
    public function fineOneByName($domain)
    {
        $q = $this
            ->createQueryBuilder('d')
            ->where('d.name = :name')
            ->setParameters([
                'name' => $domain,
            ])
            ->setMaxResults(1)
            ->getQuery()
        ;

        try {
            return $q->getSingleResult(Query::HYDRATE_OBJECT);
        } catch (\Exception $e) {
            throw new ORMException(
                sprintf('Could not find entry for the domain of %s provided.', $domain),
                null, $e
            );
        }
    }
}

/* EOF */
