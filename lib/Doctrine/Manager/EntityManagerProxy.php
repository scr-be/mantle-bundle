<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Manager;

use Doctrine\ORM\EntityManager;

/**
 * Class EntityManagerProxy.
 */
class EntityManagerProxy implements EntityManagerProxyInterface
{
    use EntityManagerProxyTrait;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }
}

/* EOF */
