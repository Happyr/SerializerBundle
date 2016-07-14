<?php

namespace Happyr\SerializerBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD"})
 */
final class Expose implements SerializerAnnotation
{
    public function getName()
    {
        return 'expose';
    }

    public function getValue()
    {
        return true;
    }
}
