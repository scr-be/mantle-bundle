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
        if (true === $container->hasDefinition('s.mantle.node_creator.renderer.registrar')) {
            $rendererRegistrar = $container->getDefinition(
                's.mantle.node_creator.renderer.registrar'
            );

            $rendererHandlers = $container->findTaggedServiceIds(
                'node_creator.renderer'
            );

            if (false === (count($rendererHandlers) > 0)) {
                return;
            }

            foreach ($rendererHandlers as $id => $attributes) {
                foreach ($attributes as $attr) {
                    $rendererRegistrar->addMethodCall(
                        'addHandler',
                        [
                            new Reference($id),
                            isset($attr['priority']) ? $attr['priority'] : null
                        ]
                    );
                }
            }
        }
    }
}

/* EOF */
