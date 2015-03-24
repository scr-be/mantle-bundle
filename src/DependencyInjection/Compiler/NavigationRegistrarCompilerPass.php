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
 * Class NavigationRegistrarCompilerPass.
 */
class NavigationRegistrarCompilerPass implements CompilerPassInterface
{
    /**
     * Process the bundle's container. Perform compiler pass to provide cache chain
     * handler with all services tagged as handler types.
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (true === $container->hasDefinition('s.mantle.navigation_registrar')) {
            $chainDefinition = $container->getDefinition(
                's.mantle.navigation_registrar'
            );
            $handlerDefinitions = $container->findTaggedServiceIds(
                's.mantle.navigation_member'
            );

            foreach ($handlerDefinitions as $id => $attributes) {
                $chainDefinition->addMethodCall(
                    'addMember',
                    [ new Reference($id) ]
                );
            }
        }
    }
}

/* EOF */
