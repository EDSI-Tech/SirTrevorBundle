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
                ->arrayNode('extra_js_files')
                    ->defaultValue([])
                    ->prototype('scalar')
                    ->end()
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
