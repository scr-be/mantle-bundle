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
use Scribe\Doctrine\Base\Entity\AbstractEntity;

/**
 * Class EntityManagerForwardableInterface.
 */
interface EntityManagerForwardableInterface
{
    /**
     * Forwards flush action to the entity manager. Please use this method with caution; Doctrine generally performs
     * better handling flushes on it's own.
     *
     * @return $this
     */
    public function flush();

    /**
     * Removed the provided entity from the database.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    public function remove(AbstractEntity $entity);

    /**
     * Persists the provided entity to the database.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    public function persist(AbstractEntity $entity);

    /**
     * Refreshes the persistent state of the passed entity back to that of the DB state.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    public function refresh(AbstractEntity $entity);

    /**
     * Detaches the passed entity from the current manager such that it is no longer consider a "managed" entity
     * and will therefore not be persisted in any way.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    public function detach(AbstractEntity $entity);

    /**
     * Merges a detached entity back into a managed state by this managers, essentially reverting the effect of
     * {@see detach()}.
     *
     * @param AbstractEntity $entity
     *
     * @return $this
     */
    public function merge(AbstractEntity $entity);

    /**
     * Allows you to pass a callable that will be provided the entity manager as its sole argument.
     *
     * @param callable $callable
     *
     * @return mixed
     */
    public function execute(callable $callable);

    /**
     * Works the same as {@see execute} but within a transaction.
     *
     * @param callable $callable
     *
     * @return mixed
     */
    public function executeTransaction(callable $callable);

    /**
     * Changes the current hydrator mode.
     *
     * @param int $mode
     *
     * @return mixed
     */
    public function setHydrator($mode = Query::HYDRATE_OBJECT);

    /**
     * Creates a copy of the passed object and returns it. By default this is a shallow copy, but a deep copy can be
     * toggled via the second parameter.
     *
     * @param AbstractEntity $entity
     * @param bool           $deep
     *
     * @return $this
     */
    public function getCopy(AbstractEntity $entity, $deep = false);

    /**
     * Returns the mapping metadata for the passed entity.
     *
     * @param AbstractEntity|string $entity
     *
     * @return ClassMetadata
     */
    public function getMetadata($entity);

    /**
     * Checks if the entity manager is open or closed and returns a corresponding boolean value.
     *
     * @return bool
     */
    public function isOpen();
}

/* EOF */
