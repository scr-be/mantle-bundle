<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Component\Instruction\Action;

/**
 * Class InstructionActionInstantiate.
 */
class InstructionActionInstantiate extends AbstractInstructionAction
{
    /**
     * @var string
     */
    private $className;

    /**
     * @return string
     */
    public function getDescription()
    {
        return 'Instantiates a class using a fully-qualified class name.';
    }

    public function __invoke($caller)
    {
        Call::method($caller, $this->method, $this->arguments);
    }
}

/* EOF */
