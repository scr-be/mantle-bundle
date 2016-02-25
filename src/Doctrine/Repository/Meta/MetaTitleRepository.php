<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Repository\Meta;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Scribe\MantleBundle\Doctrine\Exception\ORMException;

/**
 * Class MetaTitleRepository.
 */
class MetaTitleRepository extends EntityRepository
{
    /**
     * @param string $locale
     * @param string $bundle
     * @param string $controller
     * @param string $action
     *
     * @throws ORMException
     *
     * @return mixed
     */
    public function findOneByExactStringMatches($locale, $bundle, $controller, $action)
    {
        $builder = $this
            ->createQueryBuilder('t')
            ->innerJoin('t.locale', 'l')
            ->innerJoin('t.bundle', 'b')
            ->innerJoin('t.controller', 'c')
            ->innerJoin('t.action', 'a')
            ->where('l.name = :locale')
            ->andWhere('b.name = :bundle')
            ->andWhere('c.name = :controller')
            ->andWhere('a.name = :action')
            ->setParameters(
                [
                    'locale' => $locale,
                    'bundle' => $bundle,
                    'controller' => $controller,
                    'action' => $action,
                ]
            );

        $query = $builder
            ->setMaxResults(1)
            ->getQuery();

        try {
            return $query->getSingleResult(Query::HYDRATE_ARRAY);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param string      $locale
     * @param string      $bundle
     * @param null|string $controller
     * @param null|string $action
     *
     * @throws ORMException
     *
     * @return mixed
     */
    public function findOneByFizzyStringMatches($locale, $bundle, $controller = null, $action = null)
    {
        $parameters = [
            'locale' => $locale,
            'bundle' => $bundle,
        ];

        $builder = $this
            ->createQueryBuilder('t')
            ->innerJoin('t.locale', 'l')
            ->innerJoin('t.bundle', 'b');

        if ($controller !== null) {
            $builder->innerJoin('t.controller', 'c');
            $parameters['controller'] = $controller;
        }

        if ($action !== null) {
            $builder->innerJoin('t.action', 'a');
            $parameters['action'] = $action;
        }

        $builder
            ->where('l.name = :locale')
            ->andWhere('b.name = :bundle');

        if ($controller !== null) {
            $builder->andWhere('c.name = :controller');
        }

        if ($action !== null) {
            $builder->andWhere('a.name = :action');
        }

        $builder->setParameters($parameters);

        $query = $builder
            ->setMaxResults(1)
            ->getQuery();

        try {
            return $query->getSingleResult(Query::HYDRATE_ARRAY);
        } catch (\Exception $e) {
            return false;
        }
    }
}

/* EOF */
