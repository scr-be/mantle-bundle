<?php
/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator;

use Symfony\Component\Templating\EngineInterface;
use Scribe\Templating\Engine\EngineAwareTrait;

/**
 * Class AbstractGenerator
 *
 * @package Scribe\MantleBundle\Templating\Generator
 */
abstract class AbstractGenerator
{
    use EngineAwareTrait;

    /**
     * Setup the object instance
     *
     * @param EngineInterface $engine
     */
    public function __construct(EngineInterface $engine = null)
    {
        if (null !== $engine) {
            $this->setEngine($engine);
        }
    }
}

/* EOF */