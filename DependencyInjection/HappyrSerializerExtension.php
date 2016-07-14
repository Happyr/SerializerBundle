<?php

namespace Happyr\SerializerBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class HappyrSerializerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        if (empty($config['source'])) {
            // Try to help
            $path = $container->getParameter('kernel.root_dir').'/../src';
            if (!is_dir($path)) {
                throw new \Exception('You must specify a path at happyr_serializer.source');
            }
            $config['source'] = [$path];
        }
        $container->getDefinition('happyr.serializer.metadata.annotation_reader')
            ->replaceArgument(0, $config['source']);
    }
}
