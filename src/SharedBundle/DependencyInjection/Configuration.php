<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SharedBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Scribe\SharedBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Create the config tree builder object
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('scribe_git_hub');

        $rootNode
            ->children()
                ->append($this->getMaintenanceNode())
                ->append($this->getMetadataNode())
                ->append($this->getHTMLNode())
                ->append($this->getDateNode())
                ->append($this->getBootstrapNode())
            ->end()
        ;

        return $treeBuilder;
    }

    /**
     * Create maintenance mode node
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getMaintenanceNode()
    {
        return (new TreeBuilder)
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
     * Create metadata node
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getMetadataNode()
    {
        return (new TreeBuilder)
            ->root('meta')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('author')
                    ->defaultValue('Scribe Inc.')
                ->end()
                ->scalarNode('description')
                    ->defaultValue('Scribe helps clients publish using the most intuitive, advanced, practical, and durative workflow on the market.')
                ->end()
                ->scalarNode('keywords')
                    ->defaultValue('scribe,scribenet,scml,ebook,epub')
                ->end()
                ->append($this->getMetadataTwitterNode())
                ->append($this->getMetadataOpenGraphNode())
                ->append($this->getMetadataGPlusNode())
            ->end()
        ;
    }

    /**
     * Create twitter metadata node
     *
     * @return NodeDefinition
     */
    private function getMetadataTwitterNode()
    {
        return (new TreeBuilder)
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
     * Create twitter metadata node
     *
     * @return NodeDefinition
     */
    private function getMetadataOpenGraphNode()
    {
        return (new TreeBuilder)
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
     * Create google+ metadata node
     *
     * @return NodeDefinition
     */
    private function getMetadataGPlusNode()
    {
        return (new TreeBuilder)
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
     * Create HTML node
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getHTMLNode()
    {
        return (new TreeBuilder)
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
     * Create date node
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getDateNode()
    {
        return (new TreeBuilder)
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
     * Create date node
     *
     * @return \Symfony\Component\Config\Definition\Builder\NodeDefinition
     */
    private function getBootstrapNode()
    {
        return (new TreeBuilder)
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
