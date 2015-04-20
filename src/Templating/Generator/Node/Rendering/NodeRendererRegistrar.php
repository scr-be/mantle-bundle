<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Templating\Generator\Node\Rendering;

use Scribe\Component\DependencyInjection\Compiler\CompilerPassChainInterface;
use Scribe\Component\DependencyInjection\Compiler\CompilerPassHandlerInterface;

/**
 * Class NodeRendererRegistrar.
 */
class NodeRendererRegistrar implements CompilerPassChainInterface
{
    /**
     * @var NodeRendererInterface[]
     */
    protected $nodeRendererHandlers;

    /**
     * Construct object with empty handlers array.
     */
    public function __construct()
    {
        $this->nodeRendererHandlers = [];
    }

    /**
     * Add render handler type.
     *
     * @param CompilerPassHandlerInterface $handler
     * @param null                         $priority
     */
    public function addHandler(CompilerPassHandlerInterface $handler, $priority = null)
    {
        if ($handler instanceof NodeRendererInterface) {
            $this->nodeRendererHandlers[$priority] = $handler;
        }
    }

    /**
     * Get renderer.
     *
     * @param string $rendererType
     *
     * @return null|NodeRendererInterface
     */
    public function getHandler($rendererType)
    {
        ksort($this->nodeRendererHandlers);

        foreach ($this->nodeRendererHandlers as $renderer) {
            if ($renderer->isSupported($rendererType)) {
                return $renderer;
            }
        }

        return;
    }
}

/* EOF */
