<?php

namespace KnpUniversity\WebpackEncoreBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class WebpackEncoreExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->getDefinition('webpack_encore.entrypoint_lookup')
            ->replaceArgument(0, $config['output_path'].'/entrypoints.json');

        $container->getDefinition('webpack_encore.tag_renderer')
            ->replaceArgument(1, $config['asset_path_prefix'])
            ->replaceArgument(2, $config['output_path'].'/manifest.json');
    }
}
