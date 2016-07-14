<?php

namespace Happyr\SerializerBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class Exclude implements SerializerAnnotation
{
    public function getName()
    {
        return 'exclude';
    }

    public function getValue()
    {
        return true;
    }
}
