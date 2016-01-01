<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Repository\Route;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Query;
use Scribe\MantleBundle\Doctrine\Entity\Route\RouteRedirect;

/**
 * Class RouteRedirectRepository.
 */
class RouteRedirectRepository extends EntityRepository
{
    /**
     * @param null|string $context
     *
     * @throws \Exception
     *
     * @return array[]
     */
    public function fineByContext($context = null)
    {
        $builder = $this->createQueryBuilder('r');

        if ($context) {
            $builder
                ->where('d.context = :context')
                ->setParameter('context', $context);
        }

        $query = $builder->getQuery();

        try {
            if ($results = $query->getResult(Query::HYDRATE_ARRAY)) {
                return $results;
            }

            throw new ORMException('No results found.');

        } catch (\Exception $exception) {

            throw $exception;
        }
    }
}

/* EOF */
