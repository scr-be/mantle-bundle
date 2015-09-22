<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Doctrine\Base\Entity\Initializable;

/**
 * Trait EntityInitializableTrait.
 *
 * Supports auto-initializing of included traits
 */
interface EntityInitializableInterface
{
    /**
     * @var string
     */
    const INITABLE_METHOD_PREFIX = 'initialize';

    /**
     * Disable auto-initialization method calling.
     *
     * @return $this
     */
    public function disableAutoInitialization();

    /**
     * Enable auto-initialization method calling.
     *
     * @return $this
     */
    public function enableAutoInitialization();

    /**
     * Has this entity been initialized?
     *
     * @return bool
     */
    public function isAutoInitialized();

    /**
     * Returns the methods called during auto initialization.
     *
     * @return array
     */
    public function getAutoInitializedMethods();

    /**
     * Call all initializer methods.
     *
     * @param bool $force
     *
     * @return $this
     */
    public function callInitializationMethods($force = false);
}

/* EOF */
