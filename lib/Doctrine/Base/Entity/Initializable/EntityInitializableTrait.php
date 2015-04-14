<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Doctrine\Base\Entity\Initializable;

/**
 * Trait EntityInitializableTrait.
 *
 * Supports auto-initializing of included traits
 */
trait EntityInitializableTrait
{
    /**
     * Ability to disable auto-initialization of traits.
     *
     * @var bool
     */
    protected $autoInitializationEnabled = true;

    /**
     * Has auto-initialization already been called elsewhere?
     *
     * @var bool
     */
    protected $autoInitializationCalled = false;

    /**
     * An array of the methods that were called during auto-initialization.
     *
     * @var array
     */
    protected $autoInitializationMethods = [];

    /**
     * Disable auto-initialization method calling.
     *
     * @return $this
     */
    final public function disableAutoInitialization()
    {
        $this->autoInitializationEnabled = false;

        return $this;
    }

    /**
     * Enable auto-initialization method calling.
     *
     * @return $this
     */
    final public function enableAutoInitialization()
    {
        $this->autoInitializationEnabled = true;

        return $this;
    }

    /**
     * Has this entity been initialized?
     *
     * @return bool
     */
    final public function isAutoInitialized()
    {
        return (bool) ($this->autoInitializationCalled === true ?: false);
    }

    /**
     * Returns the methods called during auto initialization.
     *
     * @return array
     */
    final public function getAutoInitializedMethods()
    {
        return (array) $this->autoInitializationMethods;
    }

    /**
     * Call all initializer methods.
     *
     * @param bool $force
     *
     * @return $this
     */
    final public function callInitializationMethods($force = false)
    {
        if (($this->autoInitializationEnabled === false || $this->autoInitializationCalled === true) &&
            $force !== true) {
            return $this;
        }

        $initMethodSearch    = EntityInitializableInterface::INITABLE_METHOD_PREFIX;
        $initMethodSearchLen = strlen($initMethodSearch);

        $this->autoInitializationMethods = array_filter(get_class_methods($this),
            function ($method) use ($initMethodSearch, $initMethodSearchLen) {
                return (bool) (substr($method, 0, $initMethodSearchLen) === $initMethodSearch);
            }
        );

        $this->autoInitializationMethods = array_values($this->autoInitializationMethods);

        foreach ($this->autoInitializationMethods as $method) {
            $this->$method();
        }

        $this->autoInitializationCalled = true;

        return $this;
    }
}

/* EOF */
