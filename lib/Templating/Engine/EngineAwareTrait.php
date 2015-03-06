<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Templating\Engine;

use Scribe\Exception\RuntimeException;
use Symfony\Component\Templating\EngineInterface;

/**
 * Trait EngineAwareTrait
 *
 * @package Scribe\Templating\Engine
 */
trait EngineAwareTrait
{
    /**
     * @var \Symfony\Component\Templating\EngineInterface
     */
    private $engine = null;

    /**
     * @var array
     */
    private $engineTypeDefinitions = [
        'twig' => '\Symfony\Bridge\Twig\TwigEngine'
    ];

    /**
     * Getter for templating engine
     *
     * @return EngineInterface
     *
     * @throws RuntimeException If engine property has not yet been set.
     */
    public function getEngine()
    {
        if (null === $this->engine) {
            throw new RuntimeException('Cannot retrieve templating engine as it has not been set.');
        }

        return $this->engine;
    }

    /**
     * Setter for templating engine
     *
     * @param EngineInterface $engine
     * @return $this
     */
    public function setEngine(EngineInterface $engine)
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * Checker for templating engine
     *
     * @return bool
     */
    public function hasEngine()
    {
        return (bool) ($this->engine instanceof EngineInterface);
    }

    /**
     * Attempt to determine the engine type
     *
     * @return string|false
     */
    public function getEngineType()
    {
        foreach ($this->engineTypeDefinitions as $type => $namespace) {
            if ($this->engine instanceof $namespace) {
                return $type;
            }
        }

        return false;
    }
}

/* EOF */

/* EOF */