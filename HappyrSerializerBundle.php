<?php

namespace Happyr\SerializerBundle;

use Happyr\SerializerBundle\DependencyInjection\CompilerPass\MetadataPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HappyrSerializerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new MetadataPass());
    }
}
