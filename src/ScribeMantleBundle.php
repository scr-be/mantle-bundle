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

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Scribe\MantleBundle\DependencyInjection\Compiler\NodeRendererCompilerPass;
use Scribe\MantleBundle\DependencyInjection\Compiler\NavigationRegistrarCompilerPass;

/**
 * Class ScribeMantleBundle.
 */
class ScribeMantleBundle extends Bundle
{
    /**
     * Build the container for Mantle bundle!
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new NavigationRegistrarCompilerPass);
        $container->addCompilerPass(new NodeRendererCompilerPass);
    }
}
