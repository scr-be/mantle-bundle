<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\DependencyInjection\Compiler;

use Scribe\WonkaBundle\Component\DependencyInjection\Compiler\Pass\AbstractCompilerPass;

/**
 * Class NavigationCompilerPass.
 */
class NavigationCompilerPass extends AbstractCompilerPass
{
    /**
     * {@inherit-doc}
     *
     * @return string
     */
    public function getRegistrarSrvName()
    {
        return 's.mantle.navigation_registrar';
    }

    /**
     * Return the name of the service tag to attach to the chain manager (the handlers).
     *
     * @return string
     */
    public function getAttendantTagName()
    {
        return 's.mantle.navigation_member';
    }
}

/* EOF */
