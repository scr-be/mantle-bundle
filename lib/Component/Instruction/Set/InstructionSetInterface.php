<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Instruction\Set;

/**
 * Class InstructionSetInterface.
 *
 * Defines the instructions that should be carried out by the calling code.
 */
interface InstructionSetInterface
{
    const DEFAULT_NAME = 'GenericInstructionSet';

    public function __construct($name = null);

    public function __invoke($caller);
}

/* EOF */
