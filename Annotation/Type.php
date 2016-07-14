<?php

namespace Happyr\SerializerBundle\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
final class Type implements SerializerAnnotation
{
    public $value;

    public function getName()
    {
        return 'type';
    }

    public function getValue()
    {
        return $this->value;
    }
}
