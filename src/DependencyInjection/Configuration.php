<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\MantleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Form\Exception\InvalidConfigurationException;

/**
 * Class Configuration.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Create the config tree builder object.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('scribe_mantle');

        $rootNode
            ->children()
                ->append($this->getHttpResponseNode())
                ->append($this->getMaintenanceNode())
                ->append($this->getNodeCreatorNode())
                ->append($this->getMetadataNode())
                ->append($this->getHTMLNode())
                ->append($this->getDateNode())
                ->append($this->getBootstrapNode())
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * Create maintenance mode node.
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getHttpResponseNode()
    {
        return (new TreeBuilder())
            ->root('response')
            ->addDefaultsIfNotSet()
            ->children()
                ->append($this->getHttpResponseTypeNode('global', [['key' => 'X-Framework-Layers', 'value' => 'Symfony/Mantle']]))
                ->append($this->getHttpResponseTypeNode('html', [['key' => 'Content-Type', 'value' => 'text/html']]))
                ->append($this->getHttpResponseTypeNode('json', [['key' => 'Content-Type', 'value' => 'application/json']]))
                ->append($this->getHttpResponseTypeNode('yaml', [['key' => 'Content-Type', 'value' => 'application/yaml']]))
                ->append($this->getHttpResponseTypeNode('text', [['key' => 'Content-Type', 'value' => 'Symfony/Mantle']]))
            ->end()
        ;
    }

    /**
     * @param string       $type
     * @param array[array] $default
     *
     * @return NodeDefinition
     */
    protected function getHttpResponseTypeNode($type, $default)
    {
        return (new TreeBuilder())
            ->root($type)
                ->addDefaultsIfNotSet()
                ->beforeNormalization()
                    ->always(function ($configuration) {
                        if (array_key_exists('headers_list', $configuration)) {
                            $headers = $configuration['headers_list'];
                            for ($i = 0; $i < count($headers); $i++) {
                                if (strtolower(str_replace('_', '-', $headers[$i]['key'])) === 'content-type') {
                                    return $configuration;
                                }
                            }
                        }
                        throw new InvalidConfigurationException('If you change the headers_list values, you must provide a Content-Type.    ');
                    })
                ->end()
                ->children()
                    ->arrayNode('headers_list')
                        ->defaultValue($default)
                        ->info('Headers to be appends to HTTP response type group '.$type.'.')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('key')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('value')
                                    ->isRequired()
                                    ->cannotBeEmpty()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->floatNode('protocol')
                        ->defaultValue(1.1)
                        ->info('The HTTP protocol to use for the response type group '.$type.'.')
                    ->end()
                    ->scalarNode('charset')
                        ->defaultValue('utf-8')
                        ->info('The HTTP charset to use for the response type group '.$type.'.')
                    ->end()
                ->end()
        ;
    }

    /**
     * Create maintenance mode node.
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getMaintenanceNode()
    {
        return (new TreeBuilder())
            ->root('maintenance')
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enabled')
                    ->defaultFalse()
                    ->info('Enables or disabled maintenance mode completly.')
                ->end()
                ->arrayNode('bundles')
                    ->defaultValue([])
                    ->info('If empty, apply to all bundles. Otherwise, apply to the bundles listed.')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('exempt')
                    ->defaultValue([])
                    ->info('A list of excempt controllers from maintenance listener. Overrides all other options.')
                    ->prototype('scalar')->end()
                ->end()
                ->arrayNode('override')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('request_argument')
                            ->defaultValue('maintenance_override')
                            ->info('URL request argument to allow overriding maintenance mode.')
                        ->end()
                        ->scalarNode('request_value')
                            ->defaultValue(bin2hex(openssl_random_pseudo_bytes(20)))
                            ->info('URL request argument value to allow overriding maintenance mode.')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Create node creator node.
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getNodeCreatorNode()
    {
        return (new TreeBuilder())
            ->root('node_creator')
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('caching')
                    ->defaultTrue()
                    ->info('Enables or disabled node caching.')
                ->end()
            ->end()
        ;
    }

    /**
     * Create metadata node.
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getMetadataNode()
    {
        return (new TreeBuilder())
            ->root('meta')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('charset')
                    ->defaultValue('utf8')
                ->end()
                ->scalarNode('viewport')
                    ->defaultValue('width=device-width, minimum-scale=1.0, initial-scale=1.0, user-scalable=yes')
                ->end()
                ->scalarNode('author')
                    ->defaultValue('Scribe Inc.')
                ->end()
                ->scalarNode('description')
                    ->defaultValue('Scribe helps clients publish using the most intuitive, advanced, practical, and durative workflow on the market.')
                ->end()
                ->arrayNode('keywords')
                    ->defaultValue(['scribe', 'scribenet', 'scml', 'ebook', 'epub', 'digital-hub'])
                    ->prototype('scalar')->end()
                ->end()
                ->scalarNode('publisher')
                    ->defaultValue('Scribe Inc.')
                ->end()
                ->scalarNode('title_pre')
                    ->defaultValue('')
                ->end()
                ->scalarNode('title_post')
                    ->defaultValue(' [ Scribe Inc ]')
                ->end()
                ->append($this->getMetadataTwitterNode())
                ->append($this->getMetadataOpenGraphNode())
                ->append($this->getMetadataGPlusNode())
                ->append($this->getMetadataSchemaNode())
            ->end()
        ;
    }

    /**
     * Create twitter metadata node.
     *
     * @return NodeDefinition
     */
    private function getMetadataTwitterNode()
    {
        return (new TreeBuilder())
            ->root('twitter')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('card')
                    ->defaultValue('summary')
                ->end()
                ->scalarNode('site')
                    ->defaultValue('@ScribeInc')
                ->end()
                ->scalarNode('image')
                    ->defaultValue('https://static.scribenet.com/images/logo/logo-web_0200.png')
                ->end()
            ->end()
        ;
    }

    /**
     * Create twitter metadata node.
     *
     * @return NodeDefinition
     */
    private function getMetadataOpenGraphNode()
    {
        return (new TreeBuilder())
            ->root('open_graph')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('site_name')
                    ->defaultValue('Scribe Inc.')
                ->end()
                ->scalarNode('locale')
                    ->defaultValue('en_US')
                ->end()
                ->scalarNode('type')
                    ->defaultValue('article')
                ->end()
                ->scalarNode('image')
                    ->defaultValue('https://static.scribenet.com/images/logo/logo-web_0400.png')
                ->end()
            ->end()
        ;
    }

    /**
     * Create google+ metadata node.
     *
     * @return NodeDefinition
     */
    private function getMetadataGPlusNode()
    {
        return (new TreeBuilder())
            ->root('gplus')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('profile')
                    ->defaultValue('https://plus.google.com/+Scribenet')
                ->end()
            ->end()
        ;
    }

    /**
     * Create schema.org metadata node.
     *
     * @return NodeDefinition
     */
    private function getMetadataSchemaNode()
    {
        return (new TreeBuilder())
            ->root('organization')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('name')
                    ->defaultValue('Scribe Inc.')
                ->end()
                ->arrayNode('phone_list')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return ['main' => ['number' => $v]]; })
                    ->end()
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('number')
                                ->isRequired()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('address_physical_list')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('address')
                                ->isRequired()
                            ->end()
                            ->scalarNode('locality')
                                ->isRequired()
                            ->end()
                            ->scalarNode('region')
                                ->isRequired()
                            ->end()
                            ->scalarNode('postal_code')
                                ->isRequired()
                            ->end()
                            ->scalarNode('country')->end()
                            ->floatNode('latitude')->end()
                            ->floatNode('longitude')->end()
                            ->scalarNode('url')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('address_website_list')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return ['main' => ['url' => $v, 'alt' => '']]; })
                    ->end()
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('url')
                                ->isRequired()
                            ->end()
                            ->scalarNode('alt')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('address_web_contact_list')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return ['main' => ['email' => $v, 'alt' => '']]; })
                    ->end()
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('email')
                                ->isRequired()
                            ->end()
                            ->scalarNode('contact')->end()
                            ->scalarNode('alt')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('address_social_list')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($v) { return ['main' => ['url' => $v, 'alt' => '', 'desc' => '', 'props' => []]]; })
                    ->end()
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('url')
                                ->isRequired()
                            ->end()
                            ->scalarNode('alt')->end()
                            ->scalarNode('desc')->end()
                            ->arrayNode('props')
                                ->prototype('scalar')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Create HTML node.
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getHTMLNode()
    {
        return (new TreeBuilder())
            ->root('html')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('title_post')
                    ->defaultValue('Scribe Inc.')
                    ->info('This value is added to the end of the HTML title value.')
                ->end()
                ->scalarNode('title_pre')
                    ->defaultValue('')
                    ->info('This value is added to the beginning of the HTML title value.')
                ->end()
                    ->scalarNode('footer_text')
                    ->info('This value is added to page footer globally.')
                ->end()
            ->end()
        ;
    }

    /**
     * Create date node.
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getDateNode()
    {
        return (new TreeBuilder())
            ->root('date')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('format')
                    ->defaultValue('D, M j @ G:i')
                    ->info('The default date format passed to php\'s date function.')
                ->end()
                ->scalarNode('format_detailed')
                    ->defaultValue('D, M j @ G:i:s')
                    ->info('The detailed date format passed to php\'s date function.')
                ->end()
            ->end()
        ;
    }

    /**
     * Create date node.
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getBootstrapNode()
    {
        return (new TreeBuilder())
            ->root('bs')
            ->addDefaultsIfNotSet()
            ->children()
                ->integerNode('affix_top_offset')
                    ->defaultValue('100')
                    ->info('This value is applied as the value of data-offset-top on bootstrap affix-ed elements.')
                ->end()
            ->end()
        ;
    }
}

/* EOF */
