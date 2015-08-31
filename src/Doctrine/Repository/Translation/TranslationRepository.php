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
use Scribe\MantleBundle\Doctrine\Entity\Locale\Locale;
use Scribe\MantleBundle\Doctrine\Entity\Meta\MetaTitle;
use Scribe\Doctrine\Exception\ORMException;
use Scribe\MantleBundle\Doctrine\Entity\Translation\TranslationDomain;

/**
 * Class TranslationRepository.
 */
class TranslationRepository extends EntityRepository
{
    /**
     * @param string            $slug
     * @param TranslationDomain $domain
     * @param Locale            $locale
     *
     * @throws ORMException If no valid entries are found or other ORM error occurs.
     *
     * @return MetaTitle
     */
    public function fineOneBySlugAndLocaleAndDomain($slug, TranslationDomain $domain, Locale $locale)
    {
        $q = $this
            ->createQueryBuilder('t')
            ->where('t.slug = :slug')
            ->andWhere('t.locale = :locale')
            ->andWhere('t.domain = :domain')
            ->setParameters([
                'slug' => $slug,
                'locale' => $locale,
                'domain' => $domain,
            ])
            ->setMaxResults(1)
            ->getQuery();

        try {
            return $q->getSingleResult(Query::HYDRATE_ARRAY);
        } catch (\Exception $e) {
            throw new ORMException(
                sprintf('Could not find translation for locale %s and slug %s within domain %s.', $locale->getName(), $slug, $domain->getName()),
                null, $e
            );
        }
    }

    /**
     * @param TranslationDomain $domain
     * @param Locale            $locale
     *
     * @throws ORMException If no valid entries are found or other ORM error occurs.
     *
     * @return array
     */
    public function findAllByLocaleAndDomain(TranslationDomain $domain, Locale $locale)
    {
        $q = $this
            ->createQueryBuilder('t')
            ->where('t.locale = :locale')
            ->andWhere('t.domain = :domain')
            ->setParameters([
                'locale' => $locale,
                'domain' => $domain,
            ])
            ->getQuery()
        ;

        try {
            return $q->getResult(Query::HYDRATE_ARRAY);
        } catch(\Exception $e) {
            throw new ORMException(
                sprintf('Could not find any translations for locale %s within domain %s.', $locale->getName(), $domain->getName()),
                null, $e
            );
        }
    }
}

/* EOF */
