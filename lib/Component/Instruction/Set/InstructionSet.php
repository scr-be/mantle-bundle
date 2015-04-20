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

use Scribe\Utility\Caller\Call;
use Scribe\Utility\Reflection\ClassReflectionAnalyserInterface;

/**
 * Class InstructionSet.
 *
 * Defines the instructions that should be carried out by the calling code.
 */
class InstructionSet implements InstructionSetInterface
{
    /**
     * @var
     */
    private $propertySet;
    /**
     * An array of property names to act on via the property values provided. {@see $propertyValues
     *
     * @var array
     */
    private $propertyNames;

    /**
     * An array of the property values to set the property names as. {@see $propertyNames}
     *
     * @var array
     */
    private $propertyValues;
    private $methodName;
    private $methodParameters;

    public function __construct(ClassReflectionAnalyserInterface $classAnalyzer, $class, $name = null)
    {

    }

    public function __invoke($caller)
    {
        Call::method($caller, $this->method, $this->arguments);
    }
}

/* EOF */
