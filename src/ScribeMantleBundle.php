<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle;

use Scribe\WonkaBundle\Component\Bundle\AbstractCompilerAwareBundle;

/**
 * Class ScribeMantleBundle.
 */
class ScribeMantleBundle extends AbstractCompilerAwareBundle
{
    public function getCompilerPassInstances()
    {
        return [];
    }
}
