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
     * Return the name of the service that handles registering the handlers (the chain manager).
     *
     * @return string
     */
    abstract protected function getChainServiceName();

    /**
     * Return the name of the service tag to attach to the chain manager (the handlers).
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

        if (0 === count($handlerSet)) {
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
        $parameters = [
            new Reference($serviceId),
        ];

        foreach ($serviceAttributes as $attributeSet) {
            $chainDefinition->addMethodCall(
                'addHandler',
                $this->determineTaggedServiceParameters($parameters, $attributeSet)
            );
        }
    }

    /**
     * @param array $parameters
     * @param array $attributeSet
     *
     * @return array
     */
    protected function determineTaggedServiceParameters(array $parameters, array $attributeSet)
    {
        $returnParameters = (array) array_merge(
            $parameters,
            $this->determineTaggedServiceParameterPriority($attributeSet),
            $this->determineTaggedServiceParameterExtra($attributeSet)
        );

        return $returnParameters;
    }

    /**
     * @param array $attributeSet
     *
     * @return array[]
     */
    protected function determineTaggedServiceParameterPriority(array $attributeSet)
    {
        if (false === array_key_exists('priority', $attributeSet)) {
            return [];
        }

        return ['priority' => $attributeSet['priority']];
    }

    /**
     * @param array $attributeSet
     *
     * @return array[]
     */
    protected function determineTaggedServiceParameterExtra(array $attributeSet)
    {
        if (true === array_key_exists('priority', $attributeSet)) {
            unset($attributeSet['priority']);
        }

        if (0 === count($attributeSet)) {
            return [];
        }

        return ['extra' => $attributeSet];
    }
}

/* EOF */
