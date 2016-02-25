<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Manager;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Scribe\Doctrine\ORM\Mapping\Entity;

/**
 * Class EntityManagerProxyInterface.
 */
interface EntityManagerProxyInterface
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
     * @param Entity $entity
     *
     * @return $this
     */
    public function remove(Entity $entity);

    /**
     * Persists the provided entity to the database.
     *
     * @param Entity $entity
     *
     * @return $this
     */
    public function persist(Entity $entity);

    /**
     * Refreshes the persistent state of the passed entity back to that of the DB state.
     *
     * @param Entity $entity
     *
     * @return $this
     */
    public function refresh(Entity $entity);

    /**
     * Detaches the passed entity from the current manager such that it is no longer consider a "managed" entity
     * and will therefore not be persisted in any way.
     *
     * @param Entity $entity
     *
     * @return $this
     */
    public function detach(Entity $entity);

    /**
     * Merges a detached entity back into a managed state by this managers, essentially reverting the effect of
     * {@see detach()}.
     *
     * @param Entity $entity
     *
     * @return $this
     */
    public function merge(Entity $entity);

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
     * Changes the current hydration mode. {@see Doctrine\ORM\Query} for acceptable constants you can pass to this method.
     *
     * @param int $mode
     *
     * @return $this
     */
    public function setHydration($mode = Query::HYDRATE_OBJECT);

    /**
     * Changes the current hydration mode back to the default. The default is {@see Doctrine\ORM\Query::HYDRATE_OBJECT}
     * which returns hydrated object entities for queries.
     *
     * @return $this
     */
    public function resetHydration();

    /**
     * Creates a copy of the passed object and returns it. By default this is a shallow copy, but a deep copy can be
     * toggled via the second parameter.
     *
     * @param Entity $entity
     * @param bool   $deep
     *
     * @return Entity
     */
    public function getCopy(Entity $entity, $deep = false);

    /**
     * Returns the mapping metadata for the passed entity instance or entity class name string.
     *
     * @param Entity|string $entity
     *
     * @return ClassMetadata
     */
    public function getMetadata($entity);

    /**
     * Returns a new query builder, allowing you to build a Doctrine query using DQL and execute it.
     *
     * @return QueryBuilder
     */
    public function getQueryCreator();

    /**
     * Checks if the entity manager is open or closed and returns a corresponding boolean value.
     *
     * @return bool
     */
    public function isOpen();

    /**
     * Checks if the entity manager is closed. Inverse of {@see isOpen()}.
     *
     * @return bool
     */
    public function isClosed();
}

/* EOF */
