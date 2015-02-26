<?php
/*
 * This file is part of scribe-foundation-bundle.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\Templating\Generator;

use Symfony\Component\Templating\EngineInterface;
use Scribe\Templating\Engine\EngineAwareTrait;

/**
 * Class AbstractGenerator
 *
 * @package Scribe\SharedBundle\Templating\Generator
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