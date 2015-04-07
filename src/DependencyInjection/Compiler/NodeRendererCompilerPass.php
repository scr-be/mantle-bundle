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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class NodeRendererCompilerPass.
 */
class NodeRendererCompilerPass implements CompilerPassInterface
{
    /**
     * Process the bundle's container in search of services tagged as node renders.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (true === $container->hasDefinition('s.mantle.node_creator.renderer_registrar')) {
            $chainDefinition = $container->getDefinition(
                's.mantle.node_creator.renderer_registrar'
            );
            $handlerDefinitions = $container->findTaggedServiceIds(
                'node_creator.renderer'
            );

            foreach ($handlerDefinitions as $id => $attributes) {
                $chainDefinition->addMethodCall(
                    'addRenderer',
                    [new Reference($id)]
                );
            }
        }
    }
}

/* EOF */
