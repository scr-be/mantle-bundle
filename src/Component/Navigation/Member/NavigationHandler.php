<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\Navigation\Member;

use Scribe\MantleBundle\Component\DependencyInjection\Compiler\AbstractCompilerPassHandler;

/**
 * Class NavigationHandler.
 */
class NavigationHandler extends AbstractCompilerPassHandler
{
    /**
     * @param mixed ...$by
     *
     * @return bool
     */
    public function isSupported(...$by)
    {
        return false;
    }
}

/* EOF */
