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

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Scribe\Component\DependencyInjection\Aware\EntityManagerAwareTrait;
use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class EntityManagerForwardableTrait.
 */
trait EntityManagerForwardableTrait
{
    use EntityManagerAwareTrait;

    /**
     * Forwards flush action to the entity manager. Please use this method with caution; Doctrine generally performs
     * better handling flushes on it's own.
     *
     * @return $this
     */
    protected function flush()
    {
        $this->em->flush();

        return $this;
    }

    /**
     * Removed the provided entity from the database.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    protected function remove(AbstractEntity $entity)
    {
        $this->em->remove($entity);

        return $this;
    }

    /**
     * Persists the provided entity to the database.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    protected function persist(AbstractEntity $entity)
    {
        $this->em->persist($entity);

        return $this;
    }

    /**
     * Refreshes the persistent state of the passed entity back to that of the DB state.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    public function refresh(AbstractEntity $entity)
    {
        $this->em->refresh($entity);

        return $this;
    }

    /**
     * Detaches the passed entity from the current manager such that it is no longer consider a "managed" entity
     * and will therefore not be persisted in any way.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    public function detach(AbstractEntity $entity)
    {
        $this->em->detach($entity);

        return $this;
    }

    /**
     * Merges a detached entity back into a managed state by this managers, essentially reverting the effect of
     * {@see detach()}.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    public function merge(AbstractEntity $entity)
    {
        $this->em->merge($entity);

        return $this;
    }

    /**
     * Allows you to pass a callable that will be provided the entity manager as its sole argument.
     *
     * @param callable $callable
     *
     * @return mixed
     */
    public function execute(callable $callable)
    {
        return $callable($this->em);
    }

    /**
     * Works the same as {@see execute} but within a transaction.
     *
     * @param callable $callable
     *
     * @return mixed
     */
    public function executeTransaction(callable $callable)
    {
        return $this->em->transactional($callable);
    }

    /**
     * Changes the current hydrator mode.
     *
     * @param int $mode
     *
     * @return $this
     */
    public function setHydrator($mode = Query::HYDRATE_OBJECT)
    {
        $this->em->newHydrator($mode);

        return $this;
    }

    /**
     * Creates a copy of the passed object and returns it. By default this is a shallow copy, but a deep copy can be
     * toggled via the second parameter.
     *
     * @param AbstractEntity $entity
     * @param bool           $deep
     *
     * @return AbstractEntity
     */
    public function getCopy(AbstractEntity $entity, $deep = false)
    {
        return $this->em->copy($entity, $deep);
    }

    /**
     * Returns the mapping metadata for the passed entity instance or entity class name string.
     *
     * @param AbstractEntity|string $entity
     *
     * @return ClassMetadata
     */
    public function getMetadata($entity)
    {
        return $this->em->getClassMetadata($entity);
    }

    /**
     * Checks if the entity manager is open or closed and returns a corresponding boolean value.
     *
     * @return bool
     */
    public function isOpen()
    {
        return $this->em->isOpen();
    }
}

/* EOF */
