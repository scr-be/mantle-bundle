<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Utility\Reflection;

/**
 * Class ClassReflectionAnalyser.
 */
class ClassReflectionAnalyser implements ClassReflectionAnalyserInterface
{
    /*
     * Include base functionality via trait.
     */
    use ClassReflectionAnalyserTrait;

    /**
     * Optional injection at instantiation of reflection class for analysis.
     *
     * @param \ReflectionClass $reflectionClass
     */
    public function __construct(\ReflectionClass $reflectionClass = null)
    {
        if ($reflectionClass instanceof \ReflectionClass) {
            $this->setReflectionClass($reflectionClass);
        }
    }
}

/* EOF */
