<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\DependencyInjection\Compiler;

/**
 * Class CompilerPassChainInterface.
 */
interface CompilerPassChainInterface
{
    /**
     * Add handler to chain container via compiler pass.
     *
     * @param CompilerPassHandlerInterface $handler
     * @param int|null                     $priority
     */
    public function addHandler(CompilerPassHandlerInterface $handler, $priority = null);

    /**
     * Basic implementation of the get handler based on criteria passed.
     *
     * @param string ...$by
     *
     * @return CompilerPassHandlerInterface|null
     */
    public function getHandler(...$by);
}

/* EOF */
