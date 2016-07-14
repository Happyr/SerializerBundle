<?php

namespace Happyr\SerializerBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
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
