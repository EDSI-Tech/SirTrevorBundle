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
            ->end()
        ;

        return $treeBuilder;
    }
}
