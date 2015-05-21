<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests\DependencyInjection\Compiler;

use Scribe\MantleBundle\DependencyInjection\Compiler\AbstractCompilerPass;

/**
 * Class CompilerPassInvalidHandlerFixture.
 */
class CompilerPassInvalidHandlerFixture extends AbstractCompilerPass
{
    /**
     * Return the name of the service that handles registering the handlers (the chain manager).
     *
     * @return string
     */
    protected function getChainServiceName()
    {
        return 's.mantle.node_creator.renderer.registrar';
    }

    /**
     * Return the name of the service tag to attach to the chain manager (the handlers).
     *
     * @return string
     */
    protected function getHandlerTagName()
    {
        return 'bad-tag-name';
    }
}

/* EOF */
