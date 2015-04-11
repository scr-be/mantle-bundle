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

use Scribe\Component\DependencyInjection\EntityManagerAwareTrait;
use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class EntityManagerForwardableTrait.
 */
trait EntityManagerForwardableTrait
{
    use EntityManagerAwareTrait;

    /**
     * Forwards flush action to $entityManager.
     *
     * @return $this
     */
    protected function flush()
    {
        $this
            ->getEntityManager()
            ->flush()
        ;

        return $this;
    }

    /**
     * Forwards remove action to $entityManager.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    protected function remove(AbstractEntity $entity)
    {
        $this
            ->getEntityManager()
            ->remove($entity)
        ;

        return $this;
    }

    /**
     * Forwards persist action to $entityManager.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    protected function persist(AbstractEntity $entity)
    {
        $this
            ->getEntityManager()
            ->remove($entity)
        ;

        return $this;
    }
}
