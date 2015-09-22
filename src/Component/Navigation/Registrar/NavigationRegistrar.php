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

use Scribe\MantleBundle\Component\DependencyInjection\Compiler\AbstractCompilerPassChain;

/**
 * Class NavigationRegistrar.
 */
class NavigationRegistrar extends AbstractCompilerPassChain
{
    /**
     * Construct object with empty handlers array.
     */
    public function __construct()
    {
        parent::__construct(
            ['handlerInstanceRestriction' => 'Scribe\MantleBundle\Component\Navigation\Member\NavigationHandlerInterface']
        );
    }
}

/* EOF */
