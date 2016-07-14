<?php

namespace Happyr\SerializerBundle\DependencyInjection\CompilerPass;

use Happyr\SerializerBundle\Metadata\Metadata;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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
