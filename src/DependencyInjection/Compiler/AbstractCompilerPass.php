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
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AbstractCompilerPass.
 */
abstract class AbstractCompilerPass implements CompilerPassInterface
{
    /**
     * Return the name of the service that handles registering the handlers (the chain manager)
     *
     * @return string
     */
    abstract protected function getChainServiceName();

    /**
     * Return the name of the service tag to attach to the chain manager (the handlers)
     *
     * @return string
     */
    abstract protected function getHandlerTagName();

    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (true !== $container->hasDefinition($this->getChainServiceName())) {
            return;
        }

        $chainDefinition = $container->getDefinition(
            $this->getChainServiceName()
        );

        $handlerSet = $container->findTaggedServiceIds(
            $this->getHandlerTagName()
        );
        if (true === empty($handlerSet)) {
            return;
        }

        foreach ($handlerSet as $serviceId => $serviceAttributes) {
            $this->registerTaggedService($chainDefinition, $serviceId, $serviceAttributes);
        }
    }

    /**
     * @param Definition $chainDefinition
     * @param string     $serviceId
     * @param array|null $serviceAttributes
     */
    protected function registerTaggedService(Definition $chainDefinition, $serviceId, array $serviceAttributes = [])
    {
        foreach ($serviceAttributes as $attribute) {
            $chainDefinition->addMethodCall(
                'addHandler',
                [
                    new Reference($serviceId),
                    try_for_array_value('priority', $attribute)
                ]
            );
        }
    }
}

/* EOF */
