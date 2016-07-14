<?php

namespace Happyr\SerializerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('happyr_serializer');

        $root->children()
            ->booleanNode('twig_extension')->defaultFalse()->end()
            ->arrayNode('source')
                ->prototype('scalar')
                ->validate()
                ->always(function ($v) {
                    $v = str_replace(DIRECTORY_SEPARATOR, '/', $v);

                    if (!is_dir($v)) {
                        throw new \Exception(sprintf('The directory "%s" does not exist.', $v));
                    }

                    return $v;
                })
                ->end()
            ->end();

        return $treeBuilder;
    }
}
