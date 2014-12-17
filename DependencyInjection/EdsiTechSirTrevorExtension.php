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

        // We build options class
        $options = new EditorOptions();
        $options->allowedBlocks = $config['allowed_blocks'];
        $options->blocksTheme   = $config['blocks_theme'];
        $options->extraJsFile   = $config['extra_js_file'];
        $options->extraCssFile  = $config['extra_css_file'];
        $options->renderTemplate = $config['render_template'];

        $container->setParameter('edsi_tech_sir_trevor_options', $options);
    }
}
