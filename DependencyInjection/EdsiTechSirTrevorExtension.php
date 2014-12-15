<?php

namespace EdsiTech\SirTrevorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

class EdsiTechSirTrevorExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container->setParameter('edsi_tech_sir_trevor_blocks_theme', $config['blocks_theme']);
        $container->setParameter('edsi_tech_sir_trevor_render_template', $config['render_template']);
        $container->setParameter('edsi_tech_sir_trevor_extra_js_files', $config['extra_js_files']);
        $container->setParameter('edsi_tech_sir_trevor_allowed_blocks', $config['allowed_blocks']);
    }
}
