<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Component\Navigation\Registrar;

use Scribe\Component\DependencyInjection\Compiler\CompilerPassChainInterface;

use Scribe\Component\DependencyInjection\Compiler\CompilerPassHandlerInterface;
use Scribe\MantleBundle\Component\Navigation\Member\NavigationHandlerInterface;

/**
 * Class NavigationRegistrar.
 */
class NavigationRegistrar implements CompilerPassChainInterface
{
    /**
     * @var array
     */
    protected $handlers = [];

    /**
     * @param CompilerPassHandlerInterface $handler
     * @param null                         $priority
     */
    public function addHandler(CompilerPassHandlerInterface $handler, $priority = null)
    {
        if ($handler instanceof NavigationHandlerInterface) {
            $this->handlers[$priority] = $handler;
        }
    }
}

/* EOF */
