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

use Scribe\Doctrine\Exception\ORMException;

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
     * Call all initializer methods.
     *
     * @param bool $force
     * @param bool $suppressExceptions
     *
     * @throws ORMException
     *
     * @return $this
     */
    final public function callInitializationMethods($force = false, $suppressExceptions = true)
    {
        if (($this->autoInitializationEnabled === false || $this->autoInitializationCalled === true)
            && $force !== true) {
            return $this;
        }

        $initMethodSearch    = EntityInitializableInterface::INITABLE_METHOD_PREFIX;
        $initMethodSearchLen = strlen($initMethodSearch);

        $initMethods = array_filter(get_class_methods($this),
            function ($method) use ($initMethodSearch, $initMethodSearchLen) {
                return (bool) (substr($method, 0, $initMethodSearchLen) === $initMethodSearch);
            }
        );

        foreach ($initMethods as $method) {
            try {
                $this->$method();
            } catch (ORMException $e) {
                if ($suppressExceptions !== true) {
                    throw $e;
                }
            }
        }

        $this->autoInitializationCalled = true;

        return $this;
    }
}

/* EOF */
