<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\Tests;

use Scribe\MantleBundle\ScribeMantleBundle;
use Scribe\MantleBundle\Tests\DependencyInjection\Compiler\CompilerPassInvalidChainFixture;
use Scribe\MantleBundle\Tests\DependencyInjection\Compiler\CompilerPassInvalidHandlerFixture;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ScribeMantleBadCompilerPassesBundle.
 */
class ScribeMantleBadCompilerPassesBundle extends ScribeMantleBundle
{
    /**
     * Build the container for Mantle bundle!
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new CompilerPassInvalidChainFixture());
        $container->addCompilerPass(new CompilerPassInvalidHandlerFixture());
    }
}
