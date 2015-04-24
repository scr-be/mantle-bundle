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

use Scribe\Component\DependencyInjection\Compiler\CompilerPassHandlerInterface;

/**
 * Class AbstractNodeRenderer.
 */
abstract class AbstractNodeRenderer implements NodeRendererInterface, CompilerPassHandlerInterface
{
    /**
     * Given the provided rendererName, does this renderer match?
     *
     * @param mixed ...$by
     *
     * @return bool
     */
    public function isSupported(...$by)
    {
        return (bool) ($this->normalizeRendererName(array_first($by)) === $this->getType() ?: false);
    }

    /**
     * Perform any string normalization required on the passed renderName value.
     *
     * @param string $rendererName
     *
     * @return string
     */
    protected function normalizeRendererName($rendererName)
    {
        return (string) strtolower($rendererName);
    }

    /**
     * Get the handler type (generally this will return the class name).
     *
     * @param bool $fqcn
     *
     * @return string
     */
    abstract public function getType($fqcn = false);
}

/* EOF */
