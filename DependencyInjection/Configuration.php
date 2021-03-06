<?php

namespace EdsiTech\SirTrevorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @inheritdoc
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('edsi_tech_sir_trevor');

        $rootNode
            ->children()
                ->scalarNode('blocks_theme')
                    ->defaultValue('EdsiTechSirTrevorBundle:Render:_blocks_theme.html.twig')
                ->end()
                ->scalarNode('render_template')
                    ->defaultValue('EdsiTechSirTrevorBundle:Render:base.html.twig')
                ->end()
                ->scalarNode('extra_js_file')
                    ->defaultValue(null)
                ->end()
                ->scalarNode('extra_css_file')
                    ->defaultValue(null)
                ->end()
                ->arrayNode('allowed_blocks')
                    ->defaultValue(['Heading', 'Text', 'List', 'Quote'])
                    ->prototype('scalar')
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
