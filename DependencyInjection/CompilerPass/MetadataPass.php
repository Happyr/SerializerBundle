<?php

namespace Happyr\SerializerBundle\DependencyInjection\CompilerPass;

use Happyr\SerializerBundle\Metadata\Metadata;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Collect and give the metadata to the normalizers.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class MetadataPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        $provider = $container->get('happyr.serializer.metadata.metadata_provider');
        $metadata = $provider->getMetadata();

        $normalizerDef = $container->getDefinition('happyr.serializer.normalizer.metadata_aware');
        $metadataString = Metadata::convertToStrings($metadata);
        $normalizerDef->replaceArgument(0, $metadataString);

        $normalizerDef = $container->getDefinition('happyr.serializer.denormalizer.metadata_aware');
        $normalizerDef->replaceArgument(0, $metadataString);
    }
}
