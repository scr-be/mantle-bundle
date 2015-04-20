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

use Scribe\Component\Instruction\Common\AbstractInstructionCommon;

/**
 * Class AbstractInstructionAction.
 */
abstract class AbstractInstructionAction extends AbstractInstructionCommon implements InstructionActionInterface
{

    /**
     * @param mixed $what
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call($what, array $arguments = [])
    {

    }

    /**
     * @param mixed $what
     * @param mixed $to
     *
     * @return mixed
     */
    public function __set($what, $to)
    {

    }

    /**
     * @param mixed $what
     *
     * @return mixed
     */
    public function __get($what)
    {

    }

    /**
     * @return string
     */
    abstract public function getDescription();


    /**
     * Passed to invoke and used as deterministic factor as to what the action attempts to act on.
     *
     * @var object
     */
    /*protected $subject;

    public function __invoke($subject = null)
    {
        $subject = $this->resolveSubject($subject);
        $return = $this->performAction($on);
    }

    public function resolveSubject($subject = null)
    {
        if (null === $subject) {
            $this->invokeOn = $this;
        } elseif (true === is_object($on))
    }

    */
}

/* EOF */
