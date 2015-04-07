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

/**
 * Class NodeRendererRegistrar.
 */
class NodeRendererRegistrar
{
    /**
     * @var NodeRendererInterface[]
     */
    protected $nodeRendererHandlers;

    /**
     * Construct object with empty handlers array
     */
    public function __construct()
    {
        $this->nodeRendererHandlers = [];
    }

    /**
     * Add render handler
     *
     * @param NodeRendererInterface $nodeRenderer
     * @param int|null              $priority
     *
     * @return void
     */
    public function addHandler(NodeRendererInterface $nodeRenderer, $priority = null)
    {
        if (null !== $priority) {
            $this->nodeRendererHandlers[(int) $priority] = $nodeRenderer;
        } else {
            $this->nodeRendererHandlers[] = $nodeRenderer;
        }
    }

    /**
     * Get renderer
     *
     * @param string $rendererType
     *
     * @return null|NodeRendererInterface
     */
    public function getHandler($rendererType)
    {
        ksort($this->nodeRendererHandlers);

        foreach ($this->nodeRendererHandlers as $renderer)
        {
            if ($renderer->isSupported($rendererType)) {
                return $renderer;
            }
        }

        return null;
    }
}

/* EOF */
