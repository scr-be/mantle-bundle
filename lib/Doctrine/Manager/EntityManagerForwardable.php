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
 * Class EntityManagerForwardable.
 */
class EntityManagerForwardable implements EntityManagerForwardableInterface
{
    use EntityManagerForwardableTrait;

    /**
     * @param EntityManager|null $entityManager
     */
    public function __construct(EntityManager $entityManager = null)
    {
        if (null === $entityManager) {
            return;
        }

        $this->setEntityManager($entityManager);
    }
}

/* EOF */
