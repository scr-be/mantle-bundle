<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Instruction\Builder;

/**
 * Class InstructionBuilderInterface
 *
 * Provides a framework for passing a single Instruction instance into a function allowing it to then determine the
 * appropriate action(s) to take.
 */
interface InstructionBuilderInterface
{
    /**
     * @param string|null $name
     *
     * @return
     */
    public function makeInst($name = null);
}

/* EOF */
