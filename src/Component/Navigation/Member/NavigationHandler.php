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

/**
 * Class NavigationHandler.
 */
class NavigationHandler implements NavigationHandlerInterface
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
